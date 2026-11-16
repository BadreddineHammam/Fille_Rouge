<?php

require_once __DIR__ . "/../backend/services/PostService.php";

$file = sys_get_temp_dir() . "/ff_posts_" . uniqid() . ".json";
file_put_contents($file, "[]");

try {
    $service = new PostService($file);
    $post = $service->createPost("  Amine Benali  ", "Développeur web", "Premier message");

    if ($post["id"] !== 1 || $post["author"] !== "Amine Benali" || count($service->listPosts()) !== 1) {
        throw new RuntimeException("La création ou la lecture de la publication a échoué.");
    }

    $updatedPost = $service->updatePost(1, "Amine Benali", "Développeur PHP", "Message modifié");

    if ($updatedPost["role"] !== "Développeur PHP" || $updatedPost["content"] !== "Message modifié") {
        throw new RuntimeException("La modification de la publication a échoué.");
    }

    $service->deletePost(1);

    if (count($service->listPosts()) !== 0) {
        throw new RuntimeException("La suppression de la publication a échoué.");
    }

    try {
        $service->createPost("", "Développeur web", "Message");
        throw new RuntimeException("Un nom vide a été accepté.");
    } catch (InvalidArgumentException $error) {
        echo "La validation des champs obligatoires fonctionne.\n";
    }

    try {
        $service->deletePost(999);
        throw new RuntimeException("Une publication inexistante a été supprimée.");
    } catch (OutOfBoundsException $error) {
        echo "La vérification d'une publication inexistante fonctionne.\n";
    }

    echo "Le test CRUD des publications a réussi.\n";
} finally {
    unlink($file);
}
