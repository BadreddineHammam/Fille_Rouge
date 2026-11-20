<?php

require_once __DIR__ . "/../dao/UserDAO.php";

class AuthService
{
    private UserDAO $userDAO;

    public function __construct(string $dataFile)
    {
        $this->userDAO = new UserDAO($dataFile);
    }

    public function register(string $name, string $email, string $password): array
    {
        return $this->createAccount($name, $email, $password, "user");
    }

    public function createAdmin(string $name, string $email, string $password): array
    {
        return $this->createAccount($name, $email, $password, "admin");
    }

    public function login(string $email, string $password): array
    {
        $user = $this->userDAO->findByEmail(strtolower(trim($email)));

        if ($user === null || !password_verify($password, $user["passwordHash"])) {
            throw new DomainException("Adresse e-mail ou mot de passe invalide.");
        }

        return $this->userToArray($user);
    }

    public function findUserById(int $id): ?array
    {
        $user = $this->userDAO->findById($id);

        return $user === null ? null : $this->userToArray($user);
    }

    private function createAccount(string $name, string $email, string $password, string $role): array
    {
        $name = trim($name);
        $email = strtolower(trim($email));

        if ($name === "" || strlen($name) > 80) {
            throw new InvalidArgumentException("Le nom est obligatoire et ne doit pas dépasser 80 caractères.");
        }

        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            throw new InvalidArgumentException("Saisissez une adresse e-mail valide.");
        }

        if (strlen($password) < 8 || strlen($password) > 200) {
            throw new InvalidArgumentException("Le mot de passe doit contenir entre 8 et 200 caractères.");
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        if ($passwordHash === false) {
            throw new RuntimeException("Le mot de passe ne peut pas être sécurisé.");
        }

        return $this->userToArray($this->userDAO->create($name, $email, $passwordHash, $role));
    }

    private function userToArray(array $user): array
    {
        return [
            "id" => $user["id"],
            "name" => $user["name"],
            "email" => $user["email"],
            "role" => $user["role"],
        ];
    }
}
