<?php

if (PHP_SAPI !== "cli") {
    http_response_code(404);
    exit;
}

require_once __DIR__ . "/../services/AuthService.php";

function askForValue(string $prompt): string
{
    fwrite(STDOUT, $prompt);
    $value = fgets(STDIN);

    return $value === false ? "" : trim($value);
}

$name = askForValue("Nom de l'administrateur : ");
$email = askForValue("Adresse e-mail : ");
$password = askForValue("Mot de passe (8 caractères minimum) : ");

try {
    $user = (new AuthService(__DIR__ . "/../data/users.json"))
        ->createAdmin($name, $email, $password);
    fwrite(STDOUT, "Compte administrateur créé pour " . $user["email"] . ".\n");
} catch (InvalidArgumentException $error) {
    fwrite(STDERR, $error->getMessage() . "\n");
    exit(1);
}
