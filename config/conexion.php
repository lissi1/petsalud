<?php

class Conexion {

    private static ?Conexion $instancia = null;
    private PDO $conexion;

    private function __construct() {
        $dsn = 'mysql:host=localhost;dbname=petsalud;charset=utf8mb4';
        $this->conexion = new PDO($dsn, 'root', 'root', [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }

    public static function getInstance(): Conexion {
        if (self::$instancia === null) {
            self::$instancia = new Conexion();
        }
        return self::$instancia;
    }

    public function getConexion(): PDO {
        return $this->conexion;
    }
}
