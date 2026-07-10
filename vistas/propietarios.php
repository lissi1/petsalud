<?php
require_once __DIR__ . '/../config/auth.php';
requerirLoginPagina();
require_once __DIR__ . '/layout.php';

iniciarLayout('propietarios', 'Propietarios · PetSalud');
?>

<h1 class="h3 mb-4">Propietarios</h1>

<div id="mensaje"></div>

<form id="form-propietario" class="row g-3 mb-4">
  <input type="hidden" id="propietario-id" name="id">

  <div class="col-md-6">
    <label for="nombre" class="form-label">Nombre</label>
    <input type="text" class="form-control" id="nombre" name="nombre" required>
  </div>
  <div class="col-md-6">
    <label for="telefono" class="form-label">Teléfono</label>
    <input type="text" class="form-control" id="telefono" name="telefono" required>
  </div>
  <div class="col-md-6">
    <label for="email" class="form-label">Email</label>
    <input type="email" class="form-control" id="email" name="email" required>
  </div>
  <div class="col-md-6">
    <label for="direccion" class="form-label">Dirección</label>
    <input type="text" class="form-control" id="direccion" name="direccion">
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
        <th>Teléfono</th>
        <th>Email</th>
        <th>Dirección</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody id="cuerpo-tabla"></tbody>
  </table>
</div>

<?php
finalizarLayout();
?>
<script src="/petsalud/js/propietarios.js"></script>
