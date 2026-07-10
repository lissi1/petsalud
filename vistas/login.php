<?php
require_once __DIR__ . '/../config/auth.php';

if (estaLogueado()) {
    header('Location: /petsalud/vistas/propietarios.php');
    exit;
}

$error = $_GET['error'] ?? '';
$registrado = isset($_GET['registrado']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Iniciar sesión · PetSalud</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
  <div class="card shadow-sm" style="max-width: 420px; width: 100%;">
    <div class="card-body p-4">
      <h1 class="h4 mb-3 text-center">🐾 PetSalud</h1>
      <p class="text-muted text-center mb-4">Inicia sesión para continuar</p>

      <?php if ($registrado): ?>
        <div class="alert alert-success">Cuenta creada correctamente. Ya puedes iniciar sesión.</div>
      <?php endif; ?>

      <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <form action="/petsalud/controladores/AuthController.php?action=login" method="POST">
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Contraseña</label>
          <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Entrar</button>
      </form>

      <p class="text-center mt-3 mb-0">
        ¿No tienes cuenta? <a href="/petsalud/vistas/registro.php">Regístrate</a>
      </p>
    </div>
  </div>
</div>
</body>
</html>
