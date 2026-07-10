<?php
require_once __DIR__ . '/../config/auth.php';
requerirLoginPagina();
require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../modelos/Propietario.php';
require_once __DIR__ . '/layout.php';

$pdo = Conexion::getInstance()->getConexion();
$propietarios = (new Propietario($pdo))->todas();

iniciarLayout('mascotas', 'Mascotas · PetSalud');
?>

<h1 class="h3 mb-4">Mascotas</h1>

<div id="mensaje"></div>

<form id="form-mascota" class="row g-3 mb-4">
  <input type="hidden" id="mascota-id" name="id">

  <div class="col-md-4">
    <label for="nombre" class="form-label">Nombre</label>
    <input type="text" class="form-control" id="nombre" name="nombre" required>
  </div>
  <div class="col-md-4">
    <label for="especie" class="form-label">Especie</label>
    <select class="form-select" id="especie" name="especie" required>
      <option value="">-- Selecciona --</option>
      <option value="Perro">Perro</option>
      <option value="Gato">Gato</option>
      <option value="Ave">Ave</option>
      <option value="Reptil">Reptil</option>
      <option value="Otro">Otro</option>
    </select>
  </div>
  <div class="col-md-4">
    <label for="raza" class="form-label">Raza</label>
    <input type="text" class="form-control" id="raza" name="raza">
  </div>

  <div class="col-md-4">
    <label for="fecha_nacimiento" class="form-label">Fecha de nacimiento</label>
    <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento">
  </div>
  <div class="col-md-4">
    <label for="peso_kg" class="form-label">Peso (kg)</label>
    <input type="number" step="0.01" min="0" class="form-control" id="peso_kg" name="peso_kg">
  </div>
  <div class="col-md-4">
    <label for="propietario_id" class="form-label">Propietario</label>
    <select class="form-select" id="propietario_id" name="propietario_id" required>
      <option value="">-- Selecciona --</option>
      <?php foreach ($propietarios as $p): ?>
        <option value="<?= (int)$p['id'] ?>"><?= htmlspecialchars($p['nombre']) ?></option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="col-12">
    <button type="submit" class="btn btn-primary" id="btn-guardar">Guardar</button>
    <button type="button" class="btn btn-secondary" id="btn-limpiar">Limpiar</button>
  </div>
</form>

<div class="table-responsive">
  <table class="table table-striped table-hover align-middle">
    <thead>
      <tr>
        <th>Nombre</th>
        <th>Especie</th>
        <th>Raza</th>
        <th>Propietario</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody id="cuerpo-tabla"></tbody>
  </table>
</div>

<?php
finalizarLayout();
?>
<script src="/petsalud/js/mascotas.js"></script>
