<?php

require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../modelos/Usuario.php';

$pdo = Conexion::getInstance()->getConexion();
$usuarioModelo = new Usuario($pdo);

$accion = $_GET['action'] ?? '';

switch ($accion) {

    case 'login':
        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            header('Location: /petsalud/vistas/login.php?error=' . urlencode('Rellena todos los campos'));
            exit;
        }

        $usuario = $usuarioModelo->verificar($email, $password);

        if (!$usuario) {
            header('Location: /petsalud/vistas/login.php?error=' . urlencode('Email o contraseña incorrectos'));
            exit;
        }

        $_SESSION['usuario_id']     = $usuario['id'];
        $_SESSION['usuario_nombre'] = $usuario['nombre'];
        header('Location: /petsalud/vistas/propietarios.php');
        exit;

    case 'registro':
        $nombre   = htmlspecialchars(trim($_POST['nombre'] ?? ''));
        $email    = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'] ?? '';

        if (empty($nombre) || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 4) {
            header('Location: /petsalud/vistas/registro.php?error=' . urlencode('Datos inválidos. La contraseña debe tener al menos 4 caracteres'));
            exit;
        }

        if ($usuarioModelo->porEmail($email)) {
            header('Location: /petsalud/vistas/registro.php?error=' . urlencode('Ese email ya está registrado'));
            exit;
        }

        $usuarioModelo->crear($nombre, $email, $password);
        header('Location: /petsalud/vistas/login.php?registrado=1');
        exit;

    case 'logout':
        $_SESSION = [];
        session_destroy();
        header('Location: /petsalud/vistas/login.php');
        exit;

    default:
        header('Location: /petsalud/vistas/login.php');
        exit;
}
