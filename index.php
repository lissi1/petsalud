<?php
require_once __DIR__ . '/config/auth.php';

if (estaLogueado()) {
    header('Location: /petsalud/vistas/propietarios.php');
} else {
    header('Location: /petsalud/vistas/login.php');
}
exit;
