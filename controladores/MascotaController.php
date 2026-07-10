<?php

require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../modelos/Mascota.php';
require_once __DIR__ . '/../modelos/Propietario.php';

requerirLoginJson();
header('Content-Type: application/json');

$pdo = Conexion::getInstance()->getConexion();
$modelo = new Mascota($pdo);
$propietarioModelo = new Propietario($pdo);

$especiesValidas = ['Perro', 'Gato', 'Ave', 'Reptil', 'Otro'];

$accion = $_GET['action'] ?? '';

switch ($accion) {

    case 'listar':
        echo json_encode($modelo->todas());
        break;

    case 'guardar':
        $id             = filter_var($_POST['id'] ?? '', FILTER_VALIDATE_INT);
        $nombre         = htmlspecialchars(trim($_POST['nombre'] ?? ''));
        $especie        = htmlspecialchars(trim($_POST['especie'] ?? ''));
        $raza           = htmlspecialchars(trim($_POST['raza'] ?? ''));
        $raza           = $raza === '' ? null : $raza;
        $fechaNac       = trim($_POST['fecha_nacimiento'] ?? '');
        $fechaNac       = $fechaNac === '' ? null : $fechaNac;
        $pesoKg         = trim($_POST['peso_kg'] ?? '');
        $pesoKg         = $pesoKg === '' ? null : $pesoKg;
        $propietarioId  = filter_var($_POST['propietario_id'] ?? '', FILTER_VALIDATE_INT);

        if (empty($nombre) || !in_array($especie, $especiesValidas, true) || !$propietarioId) {
            echo json_encode(['ok' => false, 'error' => 'Nombre, especie y propietario son obligatorios']);
            break;
        }

        if (!$propietarioModelo->porId($propietarioId)) {
            echo json_encode(['ok' => false, 'error' => 'El propietario seleccionado no existe']);
            break;
        }

        if ($pesoKg !== null && !filter_var($pesoKg, FILTER_VALIDATE_FLOAT)) {
            echo json_encode(['ok' => false, 'error' => 'El peso debe ser un número']);
            break;
        }

        if ($id) {
            $modelo->actualizar($id, $nombre, $especie, $raza, $fechaNac, $pesoKg, $propietarioId);
            echo json_encode(['ok' => true, 'mensaje' => 'Mascota actualizada']);
        } else {
            $modelo->crear($nombre, $especie, $raza, $fechaNac, $pesoKg, $propietarioId);
            echo json_encode(['ok' => true, 'mensaje' => 'Mascota guardada']);
        }
        break;

    case 'eliminar':
        $id = filter_var($_POST['id'] ?? '', FILTER_VALIDATE_INT);

        if (!$id || !$modelo->porId($id)) {
            echo json_encode(['ok' => false, 'error' => 'Mascota no encontrada']);
            break;
        }

        $modelo->eliminar($id);
        echo json_encode(['ok' => true, 'mensaje' => 'Mascota eliminada']);
        break;

    default:
        echo json_encode(['ok' => false, 'error' => 'Acción no válida']);
}
