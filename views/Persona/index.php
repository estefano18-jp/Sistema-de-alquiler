<?php require_once '../include/header.administrador.php'; ?>


<div class="container-fluid px-4">
  <h1 class="mt-4 text-center">Gestión de Personas</h1>
  <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Listado de Personas</li>
  </ol>

  <div class="d-flex justify-content-between mb-3">
    <button class="btn btn-success btn-lg" id="crear-nueva-persona" data-bs-toggle="modal" data-bs-target="#modalNuevaPersona">
      + Agregar Nueva Persona
    </button>

    <div class="input-group" style="max-width: 400px;">
      <input type="text" class="form-control" placeholder="Buscar persona..." id="buscar-persona">
      <button class="btn btn-primary" type="button" id="buscar-btn">Buscar</button>
    </div>
  </div>

  <div class="card mb-4 shadow-lg">
    <div class="card-header bg-light text-dark">
      Lista de Personas
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-striped table-bordered text-center" id="tablaPersonas">
          <thead class="table-dark">
            <tr>
              <th>ID</th>
              <th>Nombre</th>
              <th>Apellido</th>
              <th>Teléfono</th>
              <th>NroDocumento</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody id="tbodyPersonas">
            <!-- Aquí se llenarán las personas dinámicamente -->
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>


<!-- Modal para agregar nueva persona -->
<div class="modal fade" id="modalNuevaPersona" tabindex="-1" aria-labelledby="modalNuevaPersonaLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-info text-white">
        <h5 class="modal-title" id="modalNuevaPersonaLabel">Registrar Nueva Persona</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="formNuevaPersona" method="post">
          <div class="mb-3">
            <label for="nombrePersona" class="form-label">Nombre</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-person"></i></span>
              <input type="text" class="form-control" id="nombrePersona" required>
            </div>
          </div>
          <div class="mb-3">
            <label for="apellidoPersona" class="form-label">Apellido</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
              <input type="text" class="form-control" id="apellidoPersona" required>
            </div>
          </div>
          <div class="mb-3">
            <label for="telefonoPersona" class="form-label">Teléfono</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
              <input type="text" class="form-control" id="telefonoPersona" required
                pattern="9\d{8}" maxlength="9" title="El teléfono debe tener 9 dígitos y empezar con 9">
            </div>
          </div>
          <div class="mb-3">
            <label for="documentoPersona" class="form-label">NroDocumento</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-card-text"></i></span>
              <input type="text" class="form-control" id="documentoPersona" required
                pattern="\d{8}" maxlength="8" title="El NroDocumento debe tener exactamente 8 dígitos">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="guardarPersonaBtn">Guardar Persona</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal para editar persona -->
<div class="modal fade" id="modalEditarPersona" tabindex="-1" aria-labelledby="modalEditarPersonaLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-info text-white">
        <h5 class="modal-title" id="modalEditarPersonaLabel">Editar Persona</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="formEditarPersona">
          <input type="hidden" id="idPersonaEditar">
          <div class="mb-3">
            <label for="nombrePersonaEditar" class="form-label">Nombre</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-person"></i></span>
              <input type="text" class="form-control" id="nombrePersonaEditar" required>
            </div>
          </div>
          <div class="mb-3">
            <label for="apellidoPersonaEditar" class="form-label">Apellido</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
              <input type="text" class="form-control" id="apellidoPersonaEditar" required>
            </div>
          </div>
          <div class="mb-3">
            <label for="telefonoPersonaEditar" class="form-label">Teléfono</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
              <input type="text" class="form-control" id="telefonoPersonaEditar" required
                pattern="9\d{8}" maxlength="9" title="El teléfono debe tener 9 dígitos y empezar con 9">
            </div>
          </div>
          <div class="mb-3">
            <label for="documentoPersonaEditar" class="form-label">Documento</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-card-text"></i></span>
              <input type="text" class="form-control" id="documentoPersonaEditar" required
                pattern="\d{8}" maxlength="8" title="El NroDocumento debe tener exactamente 8 dígitos">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="actualizarPersonaBtn">Actualizar Persona</button>
      </div>
    </div>
  </div>
</div>

<?php require_once '../include/footer.php'; ?>

<!-- JavaScript para manejar las operaciones CRUD -->
<script>
  document.addEventListener('DOMContentLoaded', function() {

    function cargarPersonas() {
      fetch('../../controllers/persona.controller.php?operation=list')
        .then(response => response.json())
        .then(data => {
          const tbody = document.getElementById('tbodyPersonas');
          tbody.innerHTML = ''; // Limpiar la tabla
          data.forEach(persona => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
            <td>${persona.idpersona}</td>
            <td>${persona.nombre}</td>
            <td>${persona.apellido}</td>
            <td>${persona.telefono}</td>
            <td>${persona.nrodocumento}</td>
            <td>
              <button class="btn btn-warning btn-sm editar-btn"
                data-id="${persona.idpersona}"
                data-nombre="${persona.nombre}"
                data-apellido="${persona.apellido}"
                data-telefono="${persona.telefono}"
                data-documento="${persona.nrodocumento}">
                Editar
              </button>
              <button class="btn btn-danger btn-sm eliminar-btn"
                data-id="${persona.idpersona}">
                Eliminar
              </button>
            </td>
          `;
            tbody.appendChild(tr);
          });

          // Añadir eventos a los botones de editar
          const editarBtns = document.querySelectorAll('.editar-btn');
          editarBtns.forEach(btn => {
            btn.addEventListener('click', function() {
              const idpersona = this.getAttribute('data-id');
              const nombre = this.getAttribute('data-nombre');
              const apellido = this.getAttribute('data-apellido');
              const telefono = this.getAttribute('data-telefono');
              const documento = this.getAttribute('data-documento');

              // Llenar el modal de actualización
              document.getElementById('idPersonaEditar').value = idpersona;
              document.getElementById('nombrePersonaEditar').value = nombre;
              document.getElementById('apellidoPersonaEditar').value = apellido;
              document.getElementById('telefonoPersonaEditar').value = telefono;
              document.getElementById('documentoPersonaEditar').value = documento;

              // Mostrar modal
              var modalActualizar = new bootstrap.Modal(document.getElementById('modalEditarPersona'));
              modalActualizar.show();
            });
          });

          // Añadir eventos a los botones de eliminar
          const eliminarBtns = document.querySelectorAll('.eliminar-btn');
          eliminarBtns.forEach(btn => {
            btn.addEventListener('click', function() {
              const idpersona = this.getAttribute('data-id');
              if (confirm('¿Estás seguro de que deseas eliminar esta persona?')) {
                eliminarPersona(idpersona);
              }
            });
          });

        })
        .catch(error => console.error('Error cargando las personas:', error));
    }

    function eliminarPersona(idPersona) {
      fetch('../../controllers/persona.controller.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            operation: 'delete',
            idpersona: idPersona
          })
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            alert('Persona eliminada correctamente');
            cargarPersonas();
          } else {
            alert('Error al eliminar la persona');
          }
        })
        .catch(error => {
          console.error('Error eliminando persona:', error);
          alert('Hubo un problema al eliminar la persona.');
        });
    }

    document.getElementById('guardarPersonaBtn').addEventListener('click', function() {
      const nombre = document.getElementById('nombrePersona').value.trim();
      const apellido = document.getElementById('apellidoPersona').value.trim();
      const telefono = document.getElementById('telefonoPersona').value.trim();
      const documento = document.getElementById('documentoPersona').value.trim();

      // Verificar que los campos no estén vacíos
      if (!nombre || !apellido || !telefono || !documento) {
        alert("Por favor, complete todos los campos.");
        return;
      }

      // Validar el teléfono (debe comenzar con 9 y tener 9 dígitos)
      const telefonoPattern = /^9\d{8}$/;
      if (!telefonoPattern.test(telefono)) {
        alert("El teléfono debe tener 9 dígitos y empezar con 9.");
        return;
      }

      // Validar el NroDocumento (debe tener exactamente 8 dígitos)
      const documentoPattern = /^\d{8}$/;
      if (!documentoPattern.test(documento)) {
        alert("El NroDocumento debe tener exactamente 8 dígitos.");
        return;
      }

      // Enviar los datos al backend usando fetch
      fetch('../../controllers/persona.controller.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            operation: 'add',
            nombre: nombre,
            apellido: apellido,
            telefono: telefono,
            nrodocumento: documento
          })
        })
        .then(response => response.json())
        .then(data => {
          if (data.idpersona > 0) {
            alert('Persona registrada correctamente');
            // Limpiar el formulario
            document.getElementById('formNuevaPersona').reset();
            var modalNuevaPersona = bootstrap.Modal.getInstance(document.getElementById('modalNuevaPersona'));
            modalNuevaPersona.hide();
            cargarPersonas(); // Recargar la lista de personas
          } else {
            alert('Hubo un problema al registrar la persona.');
          }
        })
        .catch(error => {
          console.error('Error al guardar la persona:', error);
          alert('Hubo un problema al registrar la persona.');
        });
    });


    document.getElementById('actualizarPersonaBtn').addEventListener('click', function() {
      const idPersona = document.getElementById('idPersonaEditar').value;
      const nombre = document.getElementById('nombrePersonaEditar').value.trim();
      const apellido = document.getElementById('apellidoPersonaEditar').value.trim();
      const telefono = document.getElementById('telefonoPersonaEditar').value.trim();
      const documento = document.getElementById('documentoPersonaEditar').value.trim();

      // Verificar que los campos no estén vacíos
      if (!nombre || !apellido || !telefono || !documento) {
        alert("Por favor, complete todos los campos.");
        return;
      }

      // Validar el teléfono (debe comenzar con 9 y tener 9 dígitos)
      const telefonoPattern = /^9\d{8}$/;
      if (!telefonoPattern.test(telefono)) {
        alert("El teléfono debe tener 9 dígitos y empezar con 9.");
        return;
      }

      // Validar el NroDocumento (debe tener exactamente 8 dígitos)
      const documentoPattern = /^\d{8}$/;
      if (!documentoPattern.test(documento)) {
        alert("El NroDocumento debe tener exactamente 8 dígitos.");
        return;
      }

      // Enviar los datos al backend usando fetch
      fetch('../../controllers/persona.controller.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            operation: 'update',
            idpersona: idPersona,
            nombre: nombre,
            apellido: apellido,
            telefono: telefono,
            nrodocumento: documento
          })
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            alert('Persona actualizada correctamente');
            var modalEditarPersona = bootstrap.Modal.getInstance(document.getElementById('modalEditarPersona'));
            modalEditarPersona.hide();
            cargarPersonas();
          } else {
            alert('Error al actualizar la persona');
          }
        })
        .catch(error => {
          console.error('Error al actualizar la persona:', error);
          alert('Hubo un problema al actualizar la persona.');
        });
    });


    cargarPersonas();
  });
</script>