<?php
require_once __DIR__ . "/../service/category_service.php";

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(200);
    exit;
}

$dataFile = __DIR__ . "/../data/data.json";
$service = new category_service($dataFile);

try {
    if ($_SERVER["REQUEST_METHOD"] === "GET") {
        echo json_encode($service->get_all_service());
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $body = file_get_contents("php://input");
        $input = $body !== false && $body !== "" ? json_decode($body, true) : [];
        $name = trim((string) ($input["name"] ?? $_POST["name"] ?? ""));

        if ($name === "") {
            throw new InvalidArgumentException("Le nom de la catégorie est obligatoire.");
        }

        http_response_code(201);
        echo json_encode($service->add_service($name));
        exit;
    }

    http_response_code(405);
    echo json_encode(["error" => "Method not allowed."]);
    exit;
} catch (Throwable $exception) {
    http_response_code(400);
    echo json_encode(["error" => $exception->getMessage()]);
}