<?php

class Propietario {

    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function todas(): array {
        $stmt = $this->pdo->query('SELECT * FROM propietarios ORDER BY nombre');
        return $stmt->fetchAll();
    }

    public function porId(int $id): array|false {
        $stmt = $this->pdo->prepare('SELECT * FROM propietarios WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function crear(string $nombre, string $telefono, string $email, ?string $direccion): bool {
        $stmt = $this->pdo->prepare(
            'INSERT INTO propietarios (nombre, telefono, email, direccion)
             VALUES (:nombre, :telefono, :email, :direccion)'
        );
        return $stmt->execute([
            'nombre'    => $nombre,
            'telefono'  => $telefono,
            'email'     => $email,
            'direccion' => $direccion,
        ]);
    }

    public function actualizar(int $id, string $nombre, string $telefono, string $email, ?string $direccion): bool {
        $stmt = $this->pdo->prepare(
            'UPDATE propietarios
             SET nombre = :nombre, telefono = :telefono, email = :email, direccion = :direccion
             WHERE id = :id'
        );
        return $stmt->execute([
            'id'        => $id,
            'nombre'    => $nombre,
            'telefono'  => $telefono,
            'email'     => $email,
            'direccion' => $direccion,
        ]);
    }

    public function eliminar(int $id): bool {
        $stmt = $this->pdo->prepare('DELETE FROM propietarios WHERE id = :id');
        return $stmt->execute(['id' => $id]);
    }
}
