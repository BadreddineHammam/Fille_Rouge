<?php

$requestPath = rawurldecode(parse_url($_SERVER["REQUEST_URI"] ?? "/", PHP_URL_PATH) ?? "/");

if (preg_match("#^/backend/data(?:/|$)#i", $requestPath) === 1) {
    http_response_code(404);
    exit;
}

$filePath = dirname(__DIR__) . $requestPath;

if (is_file($filePath) || is_dir($filePath)) {
    return false;
}

http_response_code(404);
