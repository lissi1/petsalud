<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function estaLogueado(): bool {
    return isset($_SESSION['usuario_id']);
}

function requerirLoginPagina(): void {
    if (!estaLogueado()) {
        header('Location: /petsalud/vistas/login.php');
        exit;
    }
}

function requerirLoginJson(): void {
    if (!estaLogueado()) {
        header('Content-Type: application/json');
        http_response_code(401);
        echo json_encode(['ok' => false, 'error' => 'No autenticado']);
        exit;
    }
}
