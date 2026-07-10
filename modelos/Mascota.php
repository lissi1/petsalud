<?php

class Mascota {

    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function todas(): array {
        $stmt = $this->pdo->query(
            'SELECT m.*, p.nombre AS propietario_nombre
             FROM mascotas m
             JOIN propietarios p ON p.id = m.propietario_id
             ORDER BY m.nombre'
        );
        return $stmt->fetchAll();
    }

    public function porId(int $id): array|false {
        $stmt = $this->pdo->prepare('SELECT * FROM mascotas WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function crear(
        string $nombre,
        string $especie,
        ?string $raza,
        ?string $fechaNacimiento,
        ?string $pesoKg,
        int $propietarioId
    ): bool {
        $stmt = $this->pdo->prepare(
            'INSERT INTO mascotas (nombre, especie, raza, fecha_nacimiento, peso_kg, propietario_id)
             VALUES (:nombre, :especie, :raza, :fecha_nacimiento, :peso_kg, :propietario_id)'
        );
        return $stmt->execute([
            'nombre'           => $nombre,
            'especie'          => $especie,
            'raza'             => $raza,
            'fecha_nacimiento' => $fechaNacimiento,
            'peso_kg'          => $pesoKg,
            'propietario_id'   => $propietarioId,
        ]);
    }

    public function actualizar(
        int $id,
        string $nombre,
        string $especie,
        ?string $raza,
        ?string $fechaNacimiento,
        ?string $pesoKg,
        int $propietarioId
    ): bool {
        $stmt = $this->pdo->prepare(
            'UPDATE mascotas
             SET nombre = :nombre, especie = :especie, raza = :raza,
                 fecha_nacimiento = :fecha_nacimiento, peso_kg = :peso_kg, propietario_id = :propietario_id
             WHERE id = :id'
        );
        return $stmt->execute([
            'id'               => $id,
            'nombre'           => $nombre,
            'especie'          => $especie,
            'raza'             => $raza,
            'fecha_nacimiento' => $fechaNacimiento,
            'peso_kg'          => $pesoKg,
            'propietario_id'   => $propietarioId,
        ]);
    }

    public function eliminar(int $id): bool {
        $stmt = $this->pdo->prepare('DELETE FROM mascotas WHERE id = :id');
        return $stmt->execute(['id' => $id]);
    }
}
