<?php require_once '../include/header.administrador.php'; ?>

<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Lista de Servicios</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Gestión de Servicios</li>
    </ol>

    <div class="d-flex justify-content-between mb-3">
        <button class="btn btn-success btn-lg" id="crear-nuevo-servicio" data-bs-toggle="modal" data-bs-target="#modalNuevoServicio">
            + Agregar Nuevo Servicio
        </button>

        <div class="input-group" style="max-width: 400px;">
            <input type="text" class="form-control" placeholder="Buscar servicio..." id="buscar-servicio">
            <button class="btn btn-primary" type="button" id="buscar-btn">Buscar</button>
        </div>
    </div>

    <div class="card mb-4 shadow-lg">
        <div class="card-header bg-light text-dark">
            Lista de Servicios
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered text-center" id="tablaServicios">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Costo</th>
                            <th>Estado</th>
                            <th>Fecha de Inserción</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tbodyServicios">
                        <!-- Aquí se llenarán los servicios dinámicamente -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <style>
        .table-responsive {
            max-height: 400px;
            /* Ajusta la altura según tus necesidades */
            overflow-y: auto;
            /* Permite el desplazamiento vertical */
            overflow-x: auto;
            /* Permite el desplazamiento horizontal */
            border: 1px solid #dee2e6;
            /* Opcional: agrega un borde alrededor de la tabla */
        }
    </style>

    <!-- Modal para crear nuevo servicio -->
    <div class="modal fade" id="modalNuevoServicio" tabindex="-1" aria-labelledby="modalNuevoServicioLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="modalNuevoServicioLabel">Registrar Nuevo Servicio</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formNuevoServicio">
                        <div class="mb-3">
                            <label for="nombreServicio" class="form-label">Nombre del Servicio</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-star"></i></span> <!-- Icono para el servicio -->
                                <input type="text" class="form-control" id="nombreServicio" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="costoServicio" class="form-label">Costo</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-cash-stack"></i></span> <!-- Icono para el costo -->
                                <input type="number" class="form-control" id="costoServicio" required step="0.01">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="guardarServicioBtn">Guardar Servicio</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal para actualizar servicio -->
    <div class="modal fade" id="modalActualizarServicio" tabindex="-1" aria-labelledby="modalActualizarServicioLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="modalActualizarServicioLabel">Actualizar Servicio</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formActualizarServicio">
                        <input type="hidden" id="idServicioActualizar">
                        <div class="mb-3">
                            <label for="nombreServicioActualizar" class="form-label">Nombre del Servicio</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-star"></i></span> <!-- Icono para el servicio -->
                                <input type="text" class="form-control" id="nombreServicioActualizar" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="costoServicioActualizar" class="form-label">Costo</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-cash-stack"></i></span> <!-- Icono para el costo -->
                                <input type="number" class="form-control" id="costoServicioActualizar" required step="0.01">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="estadoServicioActualizar" class="form-label">Estado</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-check-circle-fill"></i></span> <!-- Icono para el estado -->
                                <select class="form-select" id="estadoServicioActualizar" required>
                                    <option value="activo">Activo</option>
                                    <option value="inactivo">Inactivo</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="actualizarServicioBtn">Actualizar Servicio</button>
                </div>
            </div>
        </div>
    </div>

    <?php require_once '../include/footer.php'; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function cargarServicios() {
                fetch('../../controllers/servicio.controller.php')
                    .then(response => response.json())
                    .then(data => {
                        const tbody = document.getElementById('tbodyServicios');
                        tbody.innerHTML = ''; // Limpiar tabla
                        data.forEach(servicio => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                        <td>${servicio.idservicio}</td>
                        <td>${servicio.nombre}</td>
                        <td>S/ ${parseFloat(servicio.costo).toFixed(2)}</td>
                        <td>${servicio.estado}</td>
                        <td>${servicio.create_at}</td>
                        <td>
                            <button class="btn btn-warning btn-sm editar-btn" data-id="${servicio.idservicio}" data-nombre="${servicio.nombre}" data-costo="${servicio.costo}" data-estado="${servicio.estado}">Editar</button>
                            <button class="btn btn-danger btn-sm eliminar-btn" data-id="${servicio.idservicio}">Eliminar</button>
                        </td>
                    `;
                            tbody.appendChild(row);
                        });

                        // Añadir evento a los botones de editar
                        const editarBtns = document.querySelectorAll('.editar-btn');
                        editarBtns.forEach(btn => {
                            btn.addEventListener('click', function() {
                                const idservicio = this.getAttribute('data-id');
                                const nombre = this.getAttribute('data-nombre');
                                const costo = this.getAttribute('data-costo');
                                const estado = this.getAttribute('data-estado');

                                // Llenar el modal de actualización
                                document.getElementById('idServicioActualizar').value = idservicio;
                                document.getElementById('nombreServicioActualizar').value = nombre;
                                document.getElementById('costoServicioActualizar').value = costo;
                                document.getElementById('estadoServicioActualizar').value = estado;

                                // Mostrar modal
                                var modalActualizar = new bootstrap.Modal(document.getElementById('modalActualizarServicio'));
                                modalActualizar.show();
                            });
                        });

                        // Añadir evento a los botones de eliminar
                        const eliminarBtns = document.querySelectorAll('.eliminar-btn');
                        eliminarBtns.forEach(btn => {
                            btn.addEventListener('click', function() {
                                const idservicio = this.getAttribute('data-id');
                                if (confirm('¿Estás seguro de que deseas eliminar este servicio?')) {
                                    fetch('../../controllers/servicio.controller.php', {
                                            method: 'DELETE',
                                            headers: {
                                                'Content-Type': 'application/json'
                                            },
                                            body: JSON.stringify({
                                                idservicio
                                            })
                                        })
                                        .then(response => response.json())
                                        .then(data => {
                                            alert(data.mensaje || data.error);
                                            if (data.mensaje) {
                                                cargarServicios(); // Recargar servicios después de eliminar
                                            }
                                        })
                                        .catch(error => console.error('Error al eliminar servicio:', error));
                                }
                            });
                        });
                    })
                    .catch(error => console.error('Error al cargar servicios:', error));
            }

            cargarServicios();

            // Función para ir al siguiente campo al presionar "Enter"
            function manejarEnter(event) {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    const form = event.target.closest('form');
                    const inputs = Array.from(form.querySelectorAll('input, select'));
                    const index = inputs.indexOf(event.target);
                    if (index > -1 && index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                }
            }

            // Añadir eventos "Enter" a los campos del formulario de nuevo servicio
            const formNuevoServicio = document.getElementById('formNuevoServicio');
            formNuevoServicio.addEventListener('keydown', manejarEnter);

            // Añadir eventos "Enter" a los campos del formulario de actualización
            const formActualizarServicio = document.getElementById('formActualizarServicio');
            formActualizarServicio.addEventListener('keydown', manejarEnter);

            // Guardar nuevo servicio
            document.getElementById('guardarServicioBtn').addEventListener('click', function() {
                const nombre = document.getElementById('nombreServicio').value;
                const costo = document.getElementById('costoServicio').value;

                if (nombre && costo) {
                    fetch('../../controllers/servicio.controller.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                nombre,
                                costo
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            alert(data.mensaje || data.error);
                            if (data.mensaje) {
                                cargarServicios(); // Recargar servicios después de registrar
                                document.getElementById('formNuevoServicio').reset(); // Reiniciar formulario
                                var modalEl = document.getElementById('modalNuevoServicio');
                                var modal = bootstrap.Modal.getInstance(modalEl);
                                modal.hide(); // Cerrar el modal
                            }
                        })
                        .catch(error => console.error('Error al registrar servicio:', error));
                } else {
                    alert('Por favor, completa todos los campos.');
                }
            });

            // Actualizar servicio
            document.getElementById('actualizarServicioBtn').addEventListener('click', function() {
                const idservicio = document.getElementById('idServicioActualizar').value;
                const nombre = document.getElementById('nombreServicioActualizar').value;
                const costo = document.getElementById('costoServicioActualizar').value;
                const estado = document.getElementById('estadoServicioActualizar').value;

                if (idservicio && nombre && costo && estado) {
                    fetch('../../controllers/servicio.controller.php', {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                idservicio,
                                nombre,
                                costo,
                                estado
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            alert(data.mensaje || data.error);
                            if (data.mensaje) {
                                cargarServicios(); // Recargar servicios después de actualizar
                                var modalActualizar = bootstrap.Modal.getInstance(document.getElementById('modalActualizarServicio'));
                                modalActualizar.hide(); // Cerrar el modal
                            }
                        })
                        .catch(error => console.error('Error al actualizar servicio:', error));
                } else {
                    alert('Por favor, completa todos los campos.');
                }
            });
        });
    </script>