<?php

require_once __DIR__ . "/../../backend/services/PostService.php";

$file = sys_get_temp_dir() . "/ff_posts_" . uniqid() . ".json";
file_put_contents($file, "[]");

try {
    $service = new PostService($file);
    $post = $service->createPost("  Amine Benali  ", "Développeur web", "Premier message", 7);

    if ($post["id"] !== 1 || $post["author"] !== "Amine Benali" || count($service->listPosts(7, false)) !== 1) {
        throw new RuntimeException("La création ou la lecture de la publication a échoué.");
    }

    $updatedPost = $service->updatePost(1, "Amine Benali", "Développeur PHP", "Message modifié", 7, false);

    if ($updatedPost["role"] !== "Développeur PHP" || $updatedPost["content"] !== "Message modifié") {
        throw new RuntimeException("La modification de la publication a échoué.");
    }

    $service->deletePost(1, 7, false);

    if (count($service->listPosts(7, false)) !== 0) {
        throw new RuntimeException("La suppression de la publication a échoué.");
    }

    $ownedPost = $service->createPost("Amine Benali", "Développeur web", "Publication privée", 7);

    if ($ownedPost["userId"] !== 7 || count($service->listPosts(8, false)) !== 0) {
        throw new RuntimeException("Une publication n'est pas isolée par utilisateur.");
    }

    try {
        $service->updatePost($ownedPost["id"], "Amine Benali", "Développeur web", "Modification interdite", 8, false);
        throw new RuntimeException("Un utilisateur a modifié la publication d'un autre utilisateur.");
    } catch (OutOfBoundsException $error) {
        echo "La vérification du propriétaire lors de la modification fonctionne.\n";
    }

    try {
        $service->deletePost($ownedPost["id"], 8, false);
        throw new RuntimeException("Un utilisateur a supprimé la publication d'un autre utilisateur.");
    } catch (OutOfBoundsException $error) {
        echo "La vérification du propriétaire lors de la suppression fonctionne.\n";
    }

    if (count($service->listPosts(8, true)) !== 1) {
        throw new RuntimeException("L'administrateur ne voit pas toutes les publications.");
    }

    try {
        $service->createPost("", "Développeur web", "Message", 7);
        throw new RuntimeException("Un nom vide a été accepté.");
    } catch (InvalidArgumentException $error) {
        echo "La validation des champs obligatoires fonctionne.\n";
    }

    try {
        $service->deletePost(999, 7, false);
        throw new RuntimeException("Une publication inexistante a été supprimée.");
    } catch (OutOfBoundsException $error) {
        echo "La vérification d'une publication inexistante fonctionne.\n";
    }

    echo "Le test CRUD des publications a réussi.\n";
} finally {
    unlink($file);
}
