<?php
require_once __DIR__ . '/../config/auth.php';

if (estaLogueado()) {
    header('Location: /petsalud/vistas/propietarios.php');
    exit;
}

$error = $_GET['error'] ?? '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Crear cuenta · PetSalud</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
  <div class="card shadow-sm" style="max-width: 420px; width: 100%;">
    <div class="card-body p-4">
      <h1 class="h4 mb-3 text-center">🐾 PetSalud</h1>
      <p class="text-muted text-center mb-4">Crea tu cuenta de acceso</p>

      <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <form action="/petsalud/controladores/AuthController.php?action=registro" method="POST">
        <div class="mb-3">
          <label for="nombre" class="form-label">Nombre completo</label>
          <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Contraseña</label>
          <input type="password" class="form-control" id="password" name="password" minlength="4" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Registrarme</button>
      </form>

      <p class="text-center mt-3 mb-0">
        ¿Ya tienes cuenta? <a href="/petsalud/vistas/login.php">Inicia sesión</a>
      </p>
    </div>
  </div>
</div>
</body>
</html>
