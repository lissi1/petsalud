const API = '/petsalud/controladores/MascotaController.php';

function mostrarMensaje(tipo, texto) {
  const msg = document.getElementById('mensaje');
  msg.innerHTML = `<div class="alert alert-${tipo}">${texto}</div>`;
}

function renderTabla(mascotas) {
  const tbody = document.getElementById('cuerpo-tabla');
  tbody.innerHTML = mascotas.map(m => `
    <tr>
      <td>${m.nombre}</td>
      <td>${m.especie}</td>
      <td>${m.raza ?? ''}</td>
      <td>${m.propietario_nombre}</td>
      <td>
        <button class="btn btn-warning btn-sm btn-editar" data-id="${m.id}">Editar</button>
        <button class="btn btn-danger btn-sm btn-borrar" data-id="${m.id}">Borrar</button>
      </td>
    </tr>
  `).join('');
}

async function cargarMascotas() {
  try {
    const resp = await fetch(`${API}?action=listar`);
    const mascotas = await resp.json();
    renderTabla(mascotas);
    return mascotas;
  } catch (error) {
    console.error('Error cargando mascotas:', error);
    mostrarMensaje('danger', 'No se pudieron cargar las mascotas.');
    return [];
  }
}

function modoAlta() {
  const form = document.getElementById('form-mascota');
  form.reset();
  document.getElementById('mascota-id').value = '';
  document.getElementById('btn-guardar').textContent = 'Guardar';
}

document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('form-mascota');

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
        await cargarMascotas();
      } else {
        mostrarMensaje('danger', json.error);
      }
    } catch (error) {
      console.error('Error guardando mascota:', error);
      mostrarMensaje('danger', 'Error de red al guardar la mascota.');
    }
  });

  document.getElementById('btn-limpiar').addEventListener('click', modoAlta);

  document.getElementById('cuerpo-tabla').addEventListener('click', async (e) => {
    const id = e.target.dataset.id;
    if (!id) return;

    if (e.target.classList.contains('btn-editar')) {
      try {
        const mascotas = await cargarMascotas();
        const m = mascotas.find(x => String(x.id) === id);
        if (!m) return;

        document.getElementById('mascota-id').value = m.id;
        document.getElementById('nombre').value = m.nombre;
        document.getElementById('especie').value = m.especie;
        document.getElementById('raza').value = m.raza ?? '';
        document.getElementById('fecha_nacimiento').value = m.fecha_nacimiento ?? '';
        document.getElementById('peso_kg').value = m.peso_kg ?? '';
        document.getElementById('propietario_id').value = m.propietario_id;
        document.getElementById('btn-guardar').textContent = 'Actualizar';
      } catch (error) {
        console.error('Error cargando mascota para editar:', error);
        mostrarMensaje('danger', 'No se pudo cargar la mascota.');
      }
    }

    if (e.target.classList.contains('btn-borrar')) {
      if (!confirm('¿Seguro que quieres eliminar esta mascota?')) return;

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
          await cargarMascotas();
        } else {
          mostrarMensaje('danger', json.error);
        }
      } catch (error) {
        console.error('Error eliminando mascota:', error);
        mostrarMensaje('danger', 'Error de red al eliminar la mascota.');
      }
    }
  });

  cargarMascotas();
});
