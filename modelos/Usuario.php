<?php

class Usuario {

    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function porEmail(string $email): array|false {
        $stmt = $this->pdo->prepare('SELECT * FROM usuarios WHERE email = :email');
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }

    public function crear(string $nombre, string $email, string $passwordPlano): bool {
        $hash = password_hash($passwordPlano, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare(
            'INSERT INTO usuarios (nombre, email, password) VALUES (:nombre, :email, :password)'
        );
        return $stmt->execute([
            'nombre'   => $nombre,
            'email'    => $email,
            'password' => $hash,
        ]);
    }

    public function verificar(string $email, string $passwordPlano): array|false {
        $usuario = $this->porEmail($email);
        if ($usuario && password_verify($passwordPlano, $usuario['password'])) {
            return $usuario;
        }
        return false;
    }
}
