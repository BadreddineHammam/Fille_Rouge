<?php

require_once __DIR__ . "/../services/AuthService.php";
require_once __DIR__ . "/../services/Session.php";

header("Content-Type: application/json; charset=utf-8");
startAppSession();

function readAuthText(array $input, string $key): string
{
    $value = $input[$key] ?? "";

    if (!is_string($value)) {
        throw new InvalidArgumentException("Un champ contient une valeur invalide.");
    }

    return $value;
}

function setLoggedInUser(array $user): void
{
    renewAppSession();
    $_SESSION["userId"] = $user["id"];
    $_SESSION["role"] = $user["role"];
}

$service = new AuthService(__DIR__ . "/../data/users.json");
$method = $_SERVER["REQUEST_METHOD"] ?? "GET";

try {
    if ($method === "GET") {
        $user = null;

        if (isset($_SESSION["userId"])) {
            $user = $service->findUserById((int) $_SESSION["userId"]);

            if ($user === null) {
                unset($_SESSION["userId"], $_SESSION["role"]);
            }
        }

        echo json_encode([
            "user" => $user,
            "csrfToken" => $_SESSION["csrfToken"],
        ], JSON_UNESCAPED_UNICODE);
    } elseif ($method === "POST") {
        if (!hasValidCsrfToken()) {
            http_response_code(403);
            echo json_encode([
                "success" => false,
                "message" => "La session a expiré. Actualisez la page et réessayez.",
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $input = $_POST;
        $action = readAuthText($input, "action");

        if ($action === "register") {
            $user = $service->register(
                readAuthText($input, "name"),
                readAuthText($input, "email"),
                readAuthText($input, "password")
            );
            setLoggedInUser($user);
        } elseif ($action === "login") {
            $user = $service->login(
                readAuthText($input, "email"),
                readAuthText($input, "password")
            );
            setLoggedInUser($user);
        } elseif ($action === "logout") {
            unset($_SESSION["userId"], $_SESSION["role"]);
            renewAppSession();
            $user = null;
        } else {
            throw new InvalidArgumentException("Cette action n'est pas prise en charge.");
        }

        echo json_encode([
            "success" => true,
            "message" => $action === "logout" ? "Vous êtes déconnecté." : "Connexion réussie.",
            "user" => $user,
            "csrfToken" => $_SESSION["csrfToken"],
        ], JSON_UNESCAPED_UNICODE);
    } else {
        http_response_code(405);
        echo json_encode([
            "success" => false,
            "message" => "Cette méthode de requête n'est pas prise en charge.",
        ], JSON_UNESCAPED_UNICODE);
    }
} catch (InvalidArgumentException $error) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => $error->getMessage()], JSON_UNESCAPED_UNICODE);
} catch (DomainException $error) {
    http_response_code(401);
    echo json_encode(["success" => false, "message" => $error->getMessage()], JSON_UNESCAPED_UNICODE);
} catch (Throwable $error) {
    error_log($error->__toString());
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => "La demande de compte n'a pas pu être terminée.",
    ], JSON_UNESCAPED_UNICODE);
}
