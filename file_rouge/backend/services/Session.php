<?php

function startAppSession(): void
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        return;
    }

    ini_set("session.use_strict_mode", "1");
    session_set_cookie_params([
        "lifetime" => 0,
        "path" => "/",
        "secure" => isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] !== "off",
        "httponly" => true,
        "samesite" => "Lax",
    ]);
    session_start();

    if (!isset($_SESSION["csrfToken"])) {
        $_SESSION["csrfToken"] = bin2hex(random_bytes(32));
    }
}

function hasValidCsrfToken(): bool
{
    $token = $_SERVER["HTTP_X_CSRF_TOKEN"] ?? "";

    return is_string($token)
        && isset($_SESSION["csrfToken"])
        && hash_equals($_SESSION["csrfToken"], $token);
}

function renewAppSession(): void
{
    session_regenerate_id(true);
    $_SESSION["csrfToken"] = bin2hex(random_bytes(32));
}
