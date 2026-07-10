<?php

function iniciarLayout(string $paginaActiva, string $titulo = 'PetSalud'): void {
    ?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= htmlspecialchars($titulo) ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="/petsalud/vistas/propietarios.php">🐾 PetSalud</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link <?= $paginaActiva === 'propietarios' ? 'active fw-bold' : '' ?>" href="/petsalud/vistas/propietarios.php">Propietarios</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= $paginaActiva === 'mascotas' ? 'active fw-bold' : '' ?>" href="/petsalud/vistas/mascotas.php">Mascotas</a>
        </li>
      </ul>
      <span class="navbar-text text-white me-3">
        <?= htmlspecialchars($_SESSION['usuario_nombre'] ?? '') ?>
      </span>
      <a class="btn btn-outline-light btn-sm" href="/petsalud/controladores/AuthController.php?action=logout">Salir</a>
    </div>
  </div>
</nav>
<div class="container-fluid px-4 pb-5">
    <?php
}

function finalizarLayout(): void {
    ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
    <?php
}
