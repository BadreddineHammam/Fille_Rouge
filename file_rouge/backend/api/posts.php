<?php

require_once __DIR__ . "/../services/PostService.php";
require_once __DIR__ . "/../services/Session.php";

header("Content-Type: application/json; charset=utf-8");
startAppSession();

if (!isset($_SESSION["userId"], $_SESSION["role"])) {
    http_response_code(401);
    echo json_encode(["success" => false, "message" => "Connectez-vous pour accéder aux publications."], JSON_UNESCAPED_UNICODE);
    exit;
}

$userId = (int) $_SESSION["userId"];
$isAdmin = $_SESSION["role"] === "admin";

function readRequestData(string $method): array
{
    if ($method === "POST") {
        return $_POST;
    }

    $body = file_get_contents("php://input");
    $data = [];
    parse_str($body === false ? "" : $body, $data);

    return $data;
}

function readPostId(array $input): int
{
    $id = filter_var($input["id"] ?? null, FILTER_VALIDATE_INT);

    if ($id === false || $id === null || $id < 1) {
        throw new InvalidArgumentException("L'identifiant de la publication est invalide.");
    }

    return $id;
}

function readText(array $input, string $key): string
{
    $value = $input[$key] ?? "";

    if (!is_string($value)) {
        throw new InvalidArgumentException("Un champ contient une valeur invalide.");
    }

    return $value;
}

$service = new PostService(__DIR__ . "/../data/posts.json");
$method = $_SERVER["REQUEST_METHOD"] ?? "GET";

try {
    if ($method !== "GET" && !hasValidCsrfToken()) {
        http_response_code(403);
        echo json_encode(["success" => false, "message" => "La session a expiré. Actualisez la page et réessayez."], JSON_UNESCAPED_UNICODE);
        exit;
    }

    if ($method === "GET") {
        echo json_encode($service->listPosts($userId, $isAdmin), JSON_UNESCAPED_UNICODE);
    } elseif ($method === "POST") {
        $input = readRequestData($method);
        $post = $service->createPost(
            readText($input, "author"),
            readText($input, "role"),
            readText($input, "content"),
            $userId
        );

        echo json_encode([
            "success" => true,
            "message" => "Votre publication a été créée.",
            "post" => $post,
        ], JSON_UNESCAPED_UNICODE);
    } elseif ($method === "PUT") {
        $input = readRequestData($method);
        $post = $service->updatePost(
            readPostId($input),
            readText($input, "author"),
            readText($input, "role"),
            readText($input, "content"),
            $userId,
            $isAdmin
        );

        echo json_encode([
            "success" => true,
            "message" => "Votre publication a été modifiée.",
            "post" => $post,
        ], JSON_UNESCAPED_UNICODE);
    } elseif ($method === "DELETE") {
        $input = readRequestData($method);
        $service->deletePost(readPostId($input), $userId, $isAdmin);

        echo json_encode([
            "success" => true,
            "message" => "Votre publication a été supprimée.",
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
    echo json_encode([
        "success" => false,
        "message" => $error->getMessage(),
    ], JSON_UNESCAPED_UNICODE);
} catch (OutOfBoundsException $error) {
    http_response_code(404);
    echo json_encode([
        "success" => false,
        "message" => $error->getMessage(),
    ], JSON_UNESCAPED_UNICODE);
} catch (Throwable $error) {
    error_log($error->__toString());
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => "La demande concernant la publication n'a pas pu être terminée.",
    ], JSON_UNESCAPED_UNICODE);
}
