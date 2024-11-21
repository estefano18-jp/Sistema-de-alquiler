<?php require_once '../include/header.administrador.php'; ?>

<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Lista de Complejos Deportivos</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Gestión de Complejos Deportivos</li>
    </ol>

    <div class="d-flex justify-content-between mb-3">
        <button class="btn btn-success btn-lg" id="crear-nuevo-complejo" data-bs-toggle="modal" data-bs-target="#modalNuevoComplejo">
            + Agregar Nuevo Complejo
        </button>
        <div class="input-group" style="max-width: 400px;">
            <input type="text" class="form-control" placeholder="Buscar complejo..." id="buscar-complejo">
            <button class="btn btn-primary" type="button" id="buscar-btn">Buscar</button>
        </div>
    </div>

    <div class="card mb-4 shadow-lg">
        <div class="card-header bg-light text-dark">
            Lista de Complejos Deportivos
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered text-center" id="tablaComplejos">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nombre del Complejo</th>
                            <th>Dirección</th>
                            <th>Descripción</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tbodyComplejos">
                        <!-- Aquí se llenarán los complejos dinámicamente -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- Modal para crear nuevo complejo -->
    <div class="modal fade" id="modalNuevoComplejo" tabindex="-1" aria-labelledby="modalNuevoComplejoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="modalNuevoComplejoLabel">Registrar Nuevo Complejo Deportivo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formNuevoComplejo">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nombreComplejo" class="form-label">Nombre del Complejo</label>
                            <input type="text" class="form-control" id="nombreComplejo" name="nombreComplejo" required>
                        </div>
                        <div class="mb-3">
                            <label for="direccionComplejo" class="form-label">Dirección</label>
                            <input type="text" class="form-control" id="direccionComplejo" name="direccion" required>
                        </div>
                        <div class="mb-3">
                            <label for="descripcionComplejo" class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcionComplejo" name="descripcion" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar Complejo</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal para actualizar complejo -->
    <div class="modal fade" id="modalActualizarComplejo" tabindex="-1" aria-labelledby="modalActualizarComplejoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="modalActualizarComplejoLabel">Actualizar Complejo Deportivo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formActualizarComplejo">
                    <div class="modal-body">
                        <input type="hidden" id="idComplejoActualizar" name="idcomplejo">
                        <div class="mb-3">
                            <label for="nombreComplejoActualizar" class="form-label">Nombre del Complejo</label>
                            <input type="text" class="form-control" id="nombreComplejoActualizar" name="nombreComplejo" required>
                        </div>
                        <div class="mb-3">
                            <label for="direccionComplejoActualizar" class="form-label">Dirección</label>
                            <input type="text" class="form-control" id="direccionComplejoActualizar" name="direccion" required>
                        </div>
                        <div class="mb-3">
                            <label for="descripcionComplejoActualizar" class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcionComplejoActualizar" name="descripcion" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Actualizar Complejo</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal para gestionar campos del complejo -->
    <div class="modal fade" id="modalCamposComplejo" tabindex="-1" aria-labelledby="modalCamposComplejoLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="modalCamposComplejoLabel">Campos del Complejo Deportivo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5 id="nombreComplejoCampos" class="text-center mb-4"></h5>
                    <div class="d-flex justify-content-between mb-3">
                        <button class="btn btn-success" id="agregarCampoBtn">
                            + Agregar Campo
                        </button>
                        <div class="input-group" style="max-width: 400px;">
                            <input type="text" class="form-control" placeholder="Buscar campo..." id="buscar-campo">
                            <button class="btn btn-primary" type="button" id="buscar-btn-campo">Buscar</button>
                        </div>
                    </div>

                    <!-- Tabla de campos -->
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered text-center" id="tablaCamposComplejo">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Tipo de Deporte</th>
                                    <th>Nombre</th>
                                    <th>Capacidad</th>
                                    <th>Precio por Hora</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyCamposComplejo">
                                <!-- Campos del complejo se llenarán dinámicamente -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para agregar un nuevo campo al complejo -->
    <div class="modal fade" id="modalNuevoCampoComplejo" tabindex="-1" aria-labelledby="modalNuevoCampoComplejoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="modalNuevoCampoComplejoLabel">Agregar Nuevo Campo al Complejo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formNuevoCampoComplejo" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" id="idComplejoCampo" name="idcomplejo">
                        <div class="mb-3">
                            <label for="tipoDeporteCampo" class="form-label">Tipo de Deporte</label>
                            <select class="form-select" id="tipoDeporteCampo" name="tipoDeporte" required onchange="handleDeporteChange()">
                                <option value="" selected disabled>Selecciona un deporte</option>
                                <option value="Fútbol">Fútbol</option>
                                <option value="Voleibol">Voleibol</option>
                                <option value="Baloncesto">Baloncesto</option>
                                <option value="Piscina">Piscina</option>
                                <option value="Otro">Otro</option>
                            </select>
                            <input type="text" class="form-control mt-2 d-none" id="otroDeporteCampo" name="otroDeporte" placeholder="Escribe el tipo de deporte">
                        </div>
                        <div class="mb-3">
                            <label for="nombreCampo" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombreCampo" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="capacidadCampo" class="form-label">Capacidad</label>
                            <input type="number" class="form-control" id="capacidadCampo" name="capacidad" required>
                        </div>
                        <div class="mb-3">
                            <label for="precioHoraCampo" class="form-label">Precio por Hora</label>
                            <input type="number" class="form-control" id="precioHoraCampo" name="precioHora" required step="0.01" min="0">
                        </div>
                        <div class="mb-3">
                            <label for="imagenCampo" class="form-label">Imagen del Campo (Opcional)</label>
                            <input type="file" class="form-control" id="imagenCampo" name="imagenCampo" accept="image/*">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar Campo</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Modal para ver un campo -->
    <div class="modal fade" id="modalVerCampoComplejo" tabindex="-1" aria-labelledby="modalVerCampoComplejoLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="modalVerCampoComplejoLabel">Detalle del Campo Deportivo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Aquí se mostrarán los detalles del campo -->
                    <div class="text-center mb-3">
                        <img id="imagenCampoVer" src="" alt="Imagen del Campo" class="img-fluid">
                    </div>
                    <h4 id="nombreCampoVer" class="text-center mb-3"></h4>
                    <p><strong>Tipo de Deporte:</strong> <span id="tipoDeporteVer"></span></p>
                    <p><strong>Capacidad:</strong> <span id="capacidadVer"></span></p>
                    <p><strong>Precio por Hora:</strong> <span id="precioHoraVer"></span></p>
                    <p><strong>Estado:</strong> <span id="estadoVer"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para editar un campo -->
    <div class="modal fade" id="modalEditarCampoComplejo" tabindex="-1" aria-labelledby="modalEditarCampoComplejoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="modalEditarCampoComplejoLabel">Editar Campo Deportivo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formEditarCampoComplejo" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" id="idCampoEditar" name="idcampo">
                        <input type="hidden" id="idComplejoCampoEditar" name="idcomplejo">
                        <div class="mb-3">
                            <label for="tipoDeporteCampoEditar" class="form-label">Tipo de Deporte</label>
                            <select class="form-select" id="tipoDeporteCampoEditar" name="tipoDeporte" required onchange="handleDeporteChangeEditar()">
                                <option value="" selected disabled>Selecciona un deporte</option>
                                <option value="Fútbol">Fútbol</option>
                                <option value="Voleibol">Voleibol</option>
                                <option value="Baloncesto">Baloncesto</option>
                                <option value="Piscina">Piscina</option>
                                <option value="Otro">Otro</option>
                            </select>
                            <input type="text" class="form-control mt-2 d-none" id="otroDeporteCampoEditar" name="otroDeporte" placeholder="Escribe el tipo de deporte">
                        </div>
                        <div class="mb-3">
                            <label for="nombreCampoEditar" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombreCampoEditar" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="capacidadCampoEditar" class="form-label">Capacidad</label>
                            <input type="number" class="form-control" id="capacidadCampoEditar" name="capacidad" required>
                        </div>
                        <div class="mb-3">
                            <label for="precioHoraCampoEditar" class="form-label">Precio por Hora</label>
                            <input type="number" class="form-control" id="precioHoraCampoEditar" name="precioHora" required step="0.01" min="0">
                        </div>
                        <div class="mb-3">
                            <label for="estadoCampoEditar" class="form-label">Estado</label>
                            <select class="form-select" id="estadoCampoEditar" name="estado" required>
                                <option value="" selected disabled>Selecciona el estado</option>
                                <option value="activo">Activo</option>
                                <option value="inactivo">Inactivo</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="imagenCampoEditar" class="form-label">Imagen del Campo (Opcional)</label>
                            <input type="file" class="form-control" id="imagenCampoEditar" name="imagenCampo" accept="image/*">
                        </div>
                        <!-- Mostrar imagen actual -->
                        <div class="mb-3 text-center">
                            <img id="imagenCampoActual" src="" alt="Imagen Actual del Campo" class="img-fluid" style="max-width: 200px;">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Actualizar Campo</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <?php require_once '../include/footer.php'; ?>


    <style>
        /* Estilos para diferenciar campos inactivos */
        .table-secondary {
            background-color: #f2f2f2;
        }
    </style>

    <script>
        // Función para cargar los complejos deportivos
        function cargarComplejos() {
            fetch('../../controllers/complejo.controller.php')
                .then(response => response.json())
                .then(data => {
                    const tbody = document.getElementById('tbodyComplejos');
                    tbody.innerHTML = '';
                    data.forEach(complejo => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${complejo.idcomplejo}</td>
                            <td>${complejo.nombreComplejo}</td>
                            <td>${complejo.direccion}</td>
                            <td>${complejo.descripcion}</td>
                            <td>
                                <button class="btn btn-success btn-sm" onclick="gestionarCampos(${complejo.idcomplejo}, '${complejo.nombreComplejo}')">Añadir Campo</button>
                                <button class="btn btn-warning btn-sm" onclick="editarComplejo(${complejo.idcomplejo})">Editar</button>
                                <button class="btn btn-danger btn-sm" onclick="eliminarComplejo(${complejo.idcomplejo})">Eliminar</button>
                            </td>
                        `;
                        tbody.appendChild(row);
                    });
                })
                .catch(error => console.error('Error al cargar complejos:', error));
        }

        // Evento para registrar un nuevo complejo deportivo
        document.getElementById('formNuevoComplejo').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);

            fetch('../../controllers/complejo.controller.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.mensaje || data.error);
                    if (data.mensaje) {
                        cargarComplejos();
                        this.reset();
                        var modalEl = document.getElementById('modalNuevoComplejo');
                        var modal = bootstrap.Modal.getInstance(modalEl);
                        modal.hide();
                    }
                })
                .catch(error => console.error('Error al registrar complejo:', error));
        });

        // Función para editar un complejo deportivo
        function editarComplejo(idComplejo) {
            fetch(`../../controllers/complejo.controller.php?idcomplejo=${idComplejo}`)
                .then(response => response.json())
                .then(data => {
                    if (data && !data.error) {
                        const complejo = data;
                        document.getElementById('idComplejoActualizar').value = complejo.idcomplejo;
                        document.getElementById('nombreComplejoActualizar').value = complejo.nombreComplejo;
                        document.getElementById('direccionComplejoActualizar').value = complejo.direccion;
                        document.getElementById('descripcionComplejoActualizar').value = complejo.descripcion;

                        var modalActualizarEl = document.getElementById('modalActualizarComplejo');
                        var modalActualizar = new bootstrap.Modal(modalActualizarEl);
                        modalActualizar.show();
                    } else {
                        alert('No se encontró el complejo deportivo.');
                    }
                })
                .catch(error => console.error('Error al cargar complejo para editar:', error));
        }

        // Evento para actualizar el complejo deportivo
        document.getElementById('formActualizarComplejo').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            formData.append('action', 'actualizar');

            fetch('../../controllers/complejo.controller.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.mensaje || data.error);
                    if (data.mensaje) {
                        cargarComplejos();
                        var modalActualizarEl = document.getElementById('modalActualizarComplejo');
                        var modalActualizar = bootstrap.Modal.getInstance(modalActualizarEl);
                        modalActualizar.hide();
                    }
                })
                .catch(error => console.error('Error al actualizar complejo:', error));
        });

        // Función para eliminar un complejo deportivo
        function eliminarComplejo(idComplejo) {
            if (confirm('¿Estás seguro de que deseas eliminar este complejo deportivo?')) {
                fetch('../../controllers/complejo.controller.php', {
                        method: 'DELETE',
                        body: JSON.stringify({
                            idcomplejo: idComplejo
                        }),
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        alert(data.mensaje || data.error);
                        if (data.mensaje) {
                            cargarComplejos();
                        }
                    })
                    .catch(error => console.error('Error al eliminar complejo:', error));
            }
        }

        // Función para gestionar campos de un complejo
        function gestionarCampos(idComplejo, nombreComplejo) {
            document.getElementById('nombreComplejoCampos').textContent = `Complejo: ${nombreComplejo}`;
            document.getElementById('idComplejoCampo').value = idComplejo;
            cargarCamposComplejo(idComplejo);

            var modalCamposEl = document.getElementById('modalCamposComplejo');
            var modalCampos = new bootstrap.Modal(modalCamposEl);
            modalCampos.show();
        }

        // Función para cargar campos de un complejo
        function cargarCamposComplejo(idComplejo) {
            fetch(`../../controllers/campo.controller.php?idcomplejo=${idComplejo}`)
                .then(response => response.json())
                .then(data => {
                    const tbody = document.getElementById('tbodyCamposComplejo');
                    tbody.innerHTML = '';
                    data.forEach(campo => {
                        const row = document.createElement('tr');
                        
                        // Si el campo está inactivo, agregamos una clase para estilizarlo
                        const rowClass = campo.estado === 'inactivo' ? 'table-secondary' : '';
                        
                        row.className = rowClass;
                        
                        row.innerHTML = `
                            <td>${campo.idcampo}</td>
                            <td>${campo.tipoDeporte}</td>
                            <td>${campo.nombreCampo}</td>
                            <td>${campo.capacidad}</td>
                            <td>${campo.precioHora}</td>
                            <td>${campo.estado.charAt(0).toUpperCase() + campo.estado.slice(1)}</td>
                            <td>
                                <button class="btn btn-info btn-sm" onclick="verCampo(${campo.idcampo})">Ver</button>
                                <button class="btn btn-warning btn-sm" onclick="editarCampo(${campo.idcampo})">Editar</button>
                                <button class="btn btn-danger btn-sm" onclick="eliminarCampo(${campo.idcampo}, ${idComplejo})">Eliminar</button>
                            </td>
                        `;
                        tbody.appendChild(row);
                    });
                })
                .catch(error => console.error('Error al cargar campos del complejo:', error));
        }

        // Evento para agregar un nuevo campo al complejo
        document.getElementById('agregarCampoBtn').addEventListener('click', function() {
            document.getElementById('formNuevoCampoComplejo').reset();
            handleDeporteChange();
            var modalNuevoCampoEl = document.getElementById('modalNuevoCampoComplejo');
            var modalNuevoCampo = new bootstrap.Modal(modalNuevoCampoEl);
            modalNuevoCampo.show();
        });

        // Función para manejar el cambio del tipo de deporte
        function handleDeporteChange() {
            const tipoDeporteCampo = document.getElementById('tipoDeporteCampo');
            const otroDeporteCampo = document.getElementById('otroDeporteCampo');
            if (tipoDeporteCampo.value === 'Otro') {
                otroDeporteCampo.classList.remove('d-none');
                otroDeporteCampo.required = true;
            } else {
                otroDeporteCampo.classList.add('d-none');
                otroDeporteCampo.value = '';
                otroDeporteCampo.required = false;
            }
        }

        // Evento para registrar un nuevo campo al complejo
        document.getElementById('formNuevoCampoComplejo').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const tipoDeporteCampo = document.getElementById('tipoDeporteCampo');
            const otroDeporteCampo = document.getElementById('otroDeporteCampo');

            if (tipoDeporteCampo.value === 'Otro') {
                formData.set('tipoDeporte', otroDeporteCampo.value);
            }

            fetch('../../controllers/campo.controller.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.mensaje || data.error);
                    if (data.mensaje) {
                        const idComplejo = document.getElementById('idComplejoCampo').value;
                        cargarCamposComplejo(idComplejo);
                        this.reset();
                        handleDeporteChange();
                        var modalNuevoCampoEl = document.getElementById('modalNuevoCampoComplejo');
                        var modalNuevoCampo = bootstrap.Modal.getInstance(modalNuevoCampoEl);
                        modalNuevoCampo.hide();
                    }
                })
                .catch(error => console.error('Error al registrar campo:', error));
        });

        // Función para ver detalles de un campo
        function verCampo(idCampo) {
            fetch(`../../controllers/campo.controller.php?idcampo=${idCampo}`)
                .then(response => response.json())
                .then(data => {
                    if (data && !data.error) {
                        document.getElementById('nombreCampoVer').textContent = data.nombreCampo;
                        document.getElementById('tipoDeporteVer').textContent = data.tipoDeporte;
                        document.getElementById('capacidadVer').textContent = data.capacidad;
                        document.getElementById('precioHoraVer').textContent = data.precioHora;
                        document.getElementById('estadoVer').textContent = data.estado.charAt(0).toUpperCase() + data.estado.slice(1);
                        if (data.imagenCampo) {
                            document.getElementById('imagenCampoVer').src = `../../uploads/${data.imagenCampo}`;
                        } else {
                            document.getElementById('imagenCampoVer').src = '../../img/imagen.png';
                        }
                        var modalVerCampoEl = document.getElementById('modalVerCampoComplejo');
                        var modalVerCampo = new bootstrap.Modal(modalVerCampoEl);
                        modalVerCampo.show();
                    } else {
                        alert(data.error || 'Error al obtener los detalles del campo');
                    }
                })
                .catch(error => console.error('Error al obtener detalles del campo:', error));
        }

        // Función para editar un campo
        function editarCampo(idCampo) {
            fetch(`../../controllers/campo.controller.php?idcampo=${idCampo}`)
                .then(response => response.json())
                .then(data => {
                    if (data && !data.error) {
                        document.getElementById('idCampoEditar').value = data.idcampo;
                        document.getElementById('idComplejoCampoEditar').value = data.idcomplejo;
                        document.getElementById('tipoDeporteCampoEditar').value = data.tipoDeporte;
                        document.getElementById('nombreCampoEditar').value = data.nombreCampo;
                        document.getElementById('capacidadCampoEditar').value = data.capacidad;
                        document.getElementById('precioHoraCampoEditar').value = data.precioHora;
                        document.getElementById('estadoCampoEditar').value = data.estado;

                        // Mostrar imagen actual
                        if (data.imagenCampo) {
                            document.getElementById('imagenCampoActual').src = `../../uploads/${data.imagenCampo}`;
                        } else {
                            document.getElementById('imagenCampoActual').src = '../../img/imagen.png';
                        }

                        handleDeporteChangeEditar();

                        var modalEditarCampoEl = document.getElementById('modalEditarCampoComplejo');
                        var modalEditarCampo = new bootstrap.Modal(modalEditarCampoEl);
                        modalEditarCampo.show();
                    } else {
                        alert(data.error || 'Error al obtener los detalles del campo');
                    }
                })
                .catch(error => console.error('Error al obtener detalles del campo:', error));
        }

        // Evento para actualizar un campo
        document.getElementById('formEditarCampoComplejo').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            formData.append('action', 'actualizar');

            const tipoDeporteCampo = document.getElementById('tipoDeporteCampoEditar');
            const otroDeporteCampo = document.getElementById('otroDeporteCampoEditar');

            if (tipoDeporteCampo.value === 'Otro') {
                formData.set('tipoDeporte', otroDeporteCampo.value);
            }

            fetch('../../controllers/campo.controller.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                alert(data.mensaje || data.error);
                if (data.mensaje) {
                    const idComplejo = document.getElementById('idComplejoCampoEditar').value;
                    cargarCamposComplejo(idComplejo);
                    this.reset();
                    handleDeporteChangeEditar();
                    var modalEditarCampoEl = document.getElementById('modalEditarCampoComplejo');
                    var modalEditarCampo = bootstrap.Modal.getInstance(modalEditarCampoEl);
                    modalEditarCampo.hide();
                }
            })
            .catch(error => console.error('Error al actualizar campo:', error));
        });

        // Función para manejar el cambio del tipo de deporte en editar campo
        function handleDeporteChangeEditar() {
            const tipoDeporteCampo = document.getElementById('tipoDeporteCampoEditar');
            const otroDeporteCampo = document.getElementById('otroDeporteCampoEditar');
            if (tipoDeporteCampo.value === 'Otro') {
                otroDeporteCampo.classList.remove('d-none');
                otroDeporteCampo.required = true;
            } else {
                otroDeporteCampo.classList.add('d-none');
                otroDeporteCampo.value = '';
                otroDeporteCampo.required = false;
            }
        }

        // Función para eliminar un campo
        function eliminarCampo(idCampo, idComplejo) {
            if (confirm('¿Estás seguro de que deseas eliminar este campo?')) {
                fetch('../../controllers/campo.controller.php', {
                    method: 'DELETE',
                    body: JSON.stringify({ idcampo: idCampo }),
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.mensaje || data.error);
                    if (data.mensaje) {
                        cargarCamposComplejo(idComplejo);
                    }
                })
                .catch(error => console.error('Error al eliminar campo:', error));
            }
        }

        // Inicializar la carga de complejos al cargar la página
        document.addEventListener('DOMContentLoaded', cargarComplejos);
    </script>
</div>
