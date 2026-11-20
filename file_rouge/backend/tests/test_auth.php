<?php

require_once __DIR__ . "/../../backend/services/AuthService.php";

$file = sys_get_temp_dir() . "/ff_users_" . uniqid() . ".json";
file_put_contents($file, "[]");

try {
    $service = new AuthService($file);
    $user = $service->register(" Amine Benali ", "AMINE@example.com", "motdepasse123");
    $admin = $service->createAdmin("Administrateur", "admin@example.com", "adminpass123");

    if (
        $user["name"] !== "Amine Benali"
        || $user["email"] !== "amine@example.com"
        || $user["role"] !== "user"
        || isset($user["passwordHash"])
        || $admin["role"] !== "admin"
    ) {
        throw new RuntimeException("La création des comptes ou la protection du mot de passe a échoué.");
    }

    $loggedInUser = $service->login(" AMINE@example.com ", "motdepasse123");

    if ($loggedInUser["id"] !== $user["id"]) {
        throw new RuntimeException("La connexion n'a pas retrouvé le bon utilisateur.");
    }

    try {
        $service->login("amine@example.com", "mauvais-mot-de-passe");
        throw new RuntimeException("Un mot de passe incorrect a été accepté.");
    } catch (DomainException $error) {
        echo "La vérification du mot de passe fonctionne.\n";
    }

    try {
        $service->register("Autre compte", "amine@example.com", "motdepasse123");
        throw new RuntimeException("Une adresse e-mail déjà utilisée a été acceptée.");
    } catch (InvalidArgumentException $error) {
        echo "La vérification d'adresse e-mail en double fonctionne.\n";
    }

    echo "Le test des comptes a réussi.\n";
} finally {
    unlink($file);
}
