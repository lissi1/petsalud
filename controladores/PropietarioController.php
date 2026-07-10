<?php

require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../modelos/Propietario.php';

requerirLoginJson();
header('Content-Type: application/json');

$pdo = Conexion::getInstance()->getConexion();
$modelo = new Propietario($pdo);

$accion = $_GET['action'] ?? '';

switch ($accion) {

    case 'listar':
        echo json_encode($modelo->todas());
        break;

    case 'guardar':
        $id       = filter_var($_POST['id'] ?? '', FILTER_VALIDATE_INT);
        $nombre   = htmlspecialchars(trim($_POST['nombre'] ?? ''));
        $telefono = htmlspecialchars(trim($_POST['telefono'] ?? ''));
        $email    = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
        $direccion = htmlspecialchars(trim($_POST['direccion'] ?? ''));
        $direccion = $direccion === '' ? null : $direccion;

        if (empty($nombre) || empty($telefono) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['ok' => false, 'error' => 'Nombre, teléfono y un email válido son obligatorios']);
            break;
        }

        if ($id) {
            $modelo->actualizar($id, $nombre, $telefono, $email, $direccion);
            echo json_encode(['ok' => true, 'mensaje' => 'Propietario actualizado']);
        } else {
            $modelo->crear($nombre, $telefono, $email, $direccion);
            echo json_encode(['ok' => true, 'mensaje' => 'Propietario guardado']);
        }
        break;

    case 'eliminar':
        $id = filter_var($_POST['id'] ?? '', FILTER_VALIDATE_INT);

        if (!$id || !$modelo->porId($id)) {
            echo json_encode(['ok' => false, 'error' => 'Propietario no encontrado']);
            break;
        }

        $modelo->eliminar($id);
        echo json_encode(['ok' => true, 'mensaje' => 'Propietario eliminado']);
        break;

    default:
        echo json_encode(['ok' => false, 'error' => 'Acción no válida']);
}
