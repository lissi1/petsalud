const API = '/petsalud/controladores/PropietarioController.php';

function mostrarMensaje(tipo, texto) {
  const msg = document.getElementById('mensaje');
  msg.innerHTML = `<div class="alert alert-${tipo}">${texto}</div>`;
}

function renderTabla(propietarios) {
  const tbody = document.getElementById('cuerpo-tabla');
  tbody.innerHTML = propietarios.map(p => `
    <tr>
      <td>${p.nombre}</td>
      <td>${p.telefono}</td>
      <td>${p.email}</td>
      <td>${p.direccion ?? ''}</td>
      <td>
        <button class="btn btn-warning btn-sm btn-editar" data-id="${p.id}">Editar</button>
        <button class="btn btn-danger btn-sm btn-borrar" data-id="${p.id}">Borrar</button>
      </td>
    </tr>
  `).join('');
}

async function cargarPropietarios() {
  try {
    const resp = await fetch(`${API}?action=listar`);
    const propietarios = await resp.json();
    renderTabla(propietarios);
    return propietarios;
  } catch (error) {
    console.error('Error cargando propietarios:', error);
    mostrarMensaje('danger', 'No se pudieron cargar los propietarios.');
    return [];
  }
}

function modoAlta() {
  const form = document.getElementById('form-propietario');
  form.reset();
  document.getElementById('propietario-id').value = '';
  document.getElementById('btn-guardar').textContent = 'Guardar';
}

document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('form-propietario');

  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    const datos = new FormData(form);

    try {
      const resp = await fetch(`${API}?action=guardar`, {
        method: 'POST',
        body: datos
      });
      const json = await resp.json();

      if (json.ok) {
        mostrarMensaje('success', json.mensaje);
        modoAlta();
        await cargarPropietarios();
      } else {
        mostrarMensaje('danger', json.error);
      }
    } catch (error) {
      console.error('Error guardando propietario:', error);
      mostrarMensaje('danger', 'Error de red al guardar el propietario.');
    }
  });

  document.getElementById('btn-limpiar').addEventListener('click', modoAlta);

  document.getElementById('cuerpo-tabla').addEventListener('click', async (e) => {
    const id = e.target.dataset.id;
    if (!id) return;

    if (e.target.classList.contains('btn-editar')) {
      try {
        const propietarios = await cargarPropietarios();
        const p = propietarios.find(x => String(x.id) === id);
        if (!p) return;

        document.getElementById('propietario-id').value = p.id;
        document.getElementById('nombre').value = p.nombre;
        document.getElementById('telefono').value = p.telefono;
        document.getElementById('email').value = p.email;
        document.getElementById('direccion').value = p.direccion ?? '';
        document.getElementById('btn-guardar').textContent = 'Actualizar';
      } catch (error) {
        console.error('Error cargando propietario para editar:', error);
        mostrarMensaje('danger', 'No se pudo cargar el propietario.');
      }
    }

    if (e.target.classList.contains('btn-borrar')) {
      if (!confirm('¿Seguro que quieres eliminar este propietario? También se eliminarán sus mascotas.')) return;

      try {
        const datos = new FormData();
        datos.append('id', id);

        const resp = await fetch(`${API}?action=eliminar`, {
          method: 'POST',
          body: datos
        });
        const json = await resp.json();

        if (json.ok) {
          mostrarMensaje('success', json.mensaje);
          await cargarPropietarios();
        } else {
          mostrarMensaje('danger', json.error);
        }
      } catch (error) {
        console.error('Error eliminando propietario:', error);
        mostrarMensaje('danger', 'Error de red al eliminar el propietario.');
      }
    }
  });

  cargarPropietarios();
});
