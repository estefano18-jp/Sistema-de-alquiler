<?php require_once '../include/header.administrador.php'; ?>

<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Gestión de Reservas</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Reservas</li>
    </ol>

    <!-- Botón para crear nueva reserva -->
    <div class="d-flex justify-content-between mb-3">
        <button class="btn btn-success btn-lg" id="crear-nueva-reserva" data-bs-toggle="modal" data-bs-target="#modalNuevaReserva">
            + Agregar Nueva Reserva
        </button>
    </div>

    <!-- Tabla de reservas -->
    <div class="card mb-4 shadow-lg">
        <div class="card-header bg-light text-dark">
            Lista de Reservas
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered text-center">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre Completo</th>
                        <th>DNI</th>
                        <th>Complejo</th>
                        <th>Deporte</th>
                        <th>Campo</th>
                        <th>Fecha de Inicio</th>
                        <th>Hora de Inicio</th>
                        <th>Fecha y Hora Fin</th>
                        <th>Monto Total</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="listaReservas">
                    <!-- Aquí se llenarán las reservas dinámicamente -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal para crear nueva reserva -->
<div class="modal fade" id="modalNuevaReserva" tabindex="-1" aria-labelledby="modalNuevaReservaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width: 73%; margin: 0 auto; transform: translateY(3%);">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="modalNuevaReservaLabel">
                    <i class="fa-solid fa-calendar-plus me-2"></i>Registrar Nueva Reserva
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formNuevaReserva">
                    <div class="row">
                        <!-- Información del Cliente -->
                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-header bg-light">
                                    <i class="fa-solid fa-user me-2"></i>Información del Cliente
                                </div>
                                <div class="card-body">
                                    <!-- DNI y Nombre -->
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="dniPersona" class="form-label">DNI</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="dniPersona" name="dniPersona" maxlength="8" minlength="8" pattern="[0-9]+" title="Solo números" required>
                                                <button class="btn btn-outline-secondary" type="button" id="buscar-dni">
                                                    <i class="fa-solid fa-search"></i>
                                                </button>
                                            </div>
                                            <input type="hidden" id="idpersona" name="idpersona">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="nombrePersona" class="form-label">Nombre</label>
                                            <input type="text" class="form-control" id="nombrePersona" name="nombrePersona" required disabled>
                                        </div>
                                    </div>
                                    <!-- Apellido y Teléfono -->
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="apellidoPersona" class="form-label">Apellido</label>
                                            <input type="text" class="form-control" id="apellidoPersona" name="apellidoPersona" required disabled>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="telefonoPersona" class="form-label">Teléfono</label>
                                            <input type="text" class="form-control" id="telefonoPersona" name="telefonoPersona" required disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Línea vertical -->
                        <div class="col-auto text-center">
                            <div class="vertical-line" style="border-left: 1px solid #ccc; height: 100%; margin: 0 15px;"></div>
                        </div>
                        <!-- Información del Campo -->
                        <div class="col-md-5">
                            <div class="card mb-3">
                                <div class="card-header bg-light">
                                    <i class="fa-solid fa-futbol me-2"></i>Información del Campo
                                </div>
                                <div class="card-body">
                                    <!-- Complejo Deportivo, Tipo de Deporte y Nombre del Campo -->
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="complejoDeportivo" class="form-label">Complejo Deportivo</label>
                                            <select class="form-select" id="complejoDeportivo" name="complejoDeportivo" required>
                                                <option value="">Selecciona un complejo</option>
                                                <!-- Opciones cargadas dinámicamente -->
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="tipoDeporte" class="form-label">Tipo de Deporte</label>
                                            <select class="form-select" id="tipoDeporte" name="tipoDeporte" required>
                                                <option value="">Selecciona un deporte</option>
                                                <!-- Opciones cargadas dinámicamente -->
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="nombreCampo" class="form-label">Nombre del Campo</label>
                                            <select class="form-select" id="nombreCampo" name="nombreCampo" required>
                                                <option value="">Selecciona un campo</option>
                                            </select>
                                            <input type="hidden" id="idcampo" name="idcampo">
                                        </div>
                                    </div>
                                    <!-- Tarifa y Ubicación -->
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="tarifaCampo" class="form-label">Tarifa por Hora</label>
                                            <input type="text" class="form-control" id="tarifaCampo" name="tarifaCampo" readonly>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="ubicacionCampo" class="form-label">Ubicación</label>
                                            <input type="text" class="form-control" id="ubicacionCampo" name="ubicacionCampo" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Línea horizontal -->
                    <hr>
                    <!-- Detalles de la Reserva -->
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <i class="fa-solid fa-clock me-2"></i>Detalles de la Reserva
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="fechaInicio" class="form-label">Fecha de Inicio</label>
                                    <input type="date" class="form-control" id="fechaInicio" name="fechaInicio" required>
                                </div>
                                <div class="col-md-2">
                                    <label for="horaReserva" class="form-label">Horas a Reservar</label>
                                    <input type="number" class="form-control" id="horaReserva" name="horaReserva" required min="1" max="24">
                                </div>
                                <div class="col-md-3">
                                    <label for="horaInicio" class="form-label">Hora de Inicio</label>
                                    <!-- Botón con texto "Añadir Hora" al lado del ícono del reloj -->
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="horaInicio" name="horaInicio" readonly required>
                                        <button type="button" class="btn btn-secondary" id="btnSeleccionarHora">
                                            <i class="fa-solid fa-clock me-2"></i>Añadir Hora
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="fechaFin" class="form-label">Fecha y Hora de Fin</label>
                                    <input type="datetime-local" class="form-control" id="fechaFin" name="fechaFin" readonly>
                                </div>
                                <div class="col-md-1">
                                    <label for="precioReserva" class="form-label">Precio</label>
                                    <input type="text" class="form-control" id="precioReserva" name="precioReserva" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Sección para seleccionar productos y servicios -->
                    <div class="row mb-3">
                        <!-- Productos -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <i class="fa-solid fa-shopping-cart me-2"></i>Productos Adicionales
                                </div>
                                <div class="card-body">
                                    <!-- Botón para abrir modal de productos -->
                                    <button type="button" class="btn btn-secondary mb-2" id="btnAgregarProducto">
                                        <i class="fa-solid fa-plus"></i> Agregar Producto
                                    </button>
                                    <div class="border rounded" style="max-height: 200px; overflow-y: auto;">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Eliminar</th>
                                                    <th>Nombre</th>
                                                    <th>Cantidad</th>
                                                    <th>Precio</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody id="listaProductos">
                                                <!-- Aquí se añadirán los productos seleccionados dinámicamente -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Servicios -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <i class="fa-solid fa-concierge-bell me-2"></i>Servicios Adicionales
                                </div>
                                <div class="card-body">
                                    <!-- Botón para abrir modal de servicios -->
                                    <button type="button" class="btn btn-secondary mb-2" id="btnAgregarServicio">
                                        <i class="fa-solid fa-plus"></i> Agregar Servicio
                                    </button>
                                    <div class="border rounded" style="max-height: 200px; overflow-y: auto;">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Eliminar</th>
                                                    <th>Nombre</th>
                                                    <th>Precio</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody id="listaServicios">
                                                <!-- Aquí se añadirán los servicios seleccionados dinámicamente -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Monto Total -->
                    <div class="row">
                        <div class="col-12">
                            <h4 class="text-end">Monto Total: S/<span id="montoTotal">0.00</span></h4>
                        </div>
                    </div>
                    <!-- Botones de Acción -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fa-solid fa-times me-2"></i>Cerrar
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-save me-2"></i>Guardar Reserva
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para seleccionar horas disponibles -->
<div class="modal fade" id="modalHorasDisponibles" tabindex="-1" aria-labelledby="modalHorasDisponiblesLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Horas Disponibles</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Contenido para mostrar las horas disponibles -->
                <div id="listaHorasDisponibles" class="d-flex flex-wrap">
                    <!-- Las horas disponibles se mostrarán aquí como botones -->
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once '../include/footer.php'; ?>

<script>
    // Variables globales
    let horasOcupadas = [];

    // Función para cargar los complejos deportivos
    async function cargarComplejosDeportivos() {
        try {
            const response = await fetch('../../controllers/complejo.controller.php?action=seleccionar');
            const complejos = await response.json();

            const complejoSelect = document.getElementById('complejoDeportivo');
            complejoSelect.innerHTML = '<option value="">Selecciona un complejo</option>';

            complejos.forEach(complejo => {
                const option = document.createElement('option');
                option.value = complejo.idcomplejo;
                option.textContent = complejo.nombreComplejo;
                complejoSelect.appendChild(option);
            });
        } catch (error) {
            console.error('Error al cargar los complejos deportivos:', error);
        }
    }

    // Evento para manejar el cambio de complejo deportivo
    document.getElementById('complejoDeportivo').addEventListener('change', function() {
        const idcomplejo = this.value;
        if (idcomplejo) {
            // Reset tipoDeporte and other fields
            document.getElementById('tipoDeporte').innerHTML = '<option value="">Selecciona un deporte</option>';
            document.getElementById('nombreCampo').innerHTML = '<option value="">Selecciona un campo</option>';
            document.getElementById('tarifaCampo').value = '';
            document.getElementById('ubicacionCampo').value = '';

            cargarTiposDeDeporte(idcomplejo);
        } else {
            document.getElementById('tipoDeporte').innerHTML = '<option value="">Selecciona un deporte</option>';
            document.getElementById('nombreCampo').innerHTML = '<option value="">Selecciona un campo</option>';
            document.getElementById('tarifaCampo').value = '';
            document.getElementById('ubicacionCampo').value = '';
        }
    });

    // Función para cargar los tipos de deportes disponibles en un complejo
    async function cargarTiposDeDeporte(idcomplejo) {
        try {
            const response = await fetch(`../../controllers/campo.controller.php?action=seleccionar_tipos_deporte&idcomplejo=${idcomplejo}`);
            const tiposDeDeporte = await response.json();

            const tipoDeporteSelect = document.getElementById('tipoDeporte');
            tipoDeporteSelect.innerHTML = '<option value="">Selecciona un deporte</option>';

            tiposDeDeporte.forEach(tipo => {
                const option = document.createElement('option');
                option.value = tipo.tipoDeporte;
                option.textContent = tipo.tipoDeporte;
                tipoDeporteSelect.appendChild(option);
            });
        } catch (error) {
            console.error('Error al cargar los tipos de deporte:', error);
        }
    }

    // Evento para manejar el cambio de tipo de deporte
    document.getElementById('tipoDeporte').addEventListener('change', function() {
        const idcomplejo = document.getElementById('complejoDeportivo').value;
        const tipoDeporte = this.value;
        if (idcomplejo && tipoDeporte) {
            document.getElementById('nombreCampo').innerHTML = '<option value="">Selecciona un campo</option>';
            document.getElementById('tarifaCampo').value = '';
            document.getElementById('ubicacionCampo').value = '';

            cargarCampos(idcomplejo, tipoDeporte);
        } else {
            document.getElementById('nombreCampo').innerHTML = '<option value="">Selecciona un campo</option>';
            document.getElementById('tarifaCampo').value = '';
            document.getElementById('ubicacionCampo').value = '';
        }
    });

    // Función para cargar los campos disponibles según el complejo y tipo de deporte seleccionado
    async function cargarCampos(idcomplejo, tipoDeporte) {
        try {
            const response = await fetch(`../../controllers/campo.controller.php?action=seleccionar_campos&idcomplejo=${idcomplejo}&tipoDeporte=${tipoDeporte}`);
            const campos = await response.json();

            const nombreCampoSelect = document.getElementById('nombreCampo');
            nombreCampoSelect.innerHTML = '<option value="">Selecciona un campo</option>';

            campos.forEach(campo => {
                const option = document.createElement('option');
                option.value = campo.idcampo;
                option.textContent = campo.nombreCampo;
                nombreCampoSelect.appendChild(option);
            });
        } catch (error) {
            console.error('Error al cargar los campos:', error);
        }
    }

    // Evento para manejar el cambio de nombre de campo
    document.getElementById('nombreCampo').addEventListener('change', function() {
        const idcampo = this.value;
        if (idcampo) {
            cargarDatosCampo(idcampo);
        }
    });

    // Función para cargar la tarifa y ubicación cuando se selecciona un campo específico
    async function cargarDatosCampo(idcampo) {
        try {
            const response = await fetch(`../../controllers/campo.controller.php?action=obtener_datos_campo&idcampo=${idcampo}`);
            const datosCampo = await response.json();

            if (datosCampo) {
                document.getElementById('tarifaCampo').value = datosCampo.precioHora;
                document.getElementById('ubicacionCampo').value = datosCampo.direccion; // Asumiendo que 'direccion' viene en los datos
                document.getElementById('idcampo').value = datosCampo.idcampo;
            } else {
                alert('No se encontraron datos para este campo.');
            }
        } catch (error) {
            console.error('Error al cargar los datos del campo:', error);
        }
    }

    // Cargar los complejos deportivos al cargar la página
    document.addEventListener('DOMContentLoaded', function() {
        cargarReservas();
        cargarComplejosDeportivos();
        cargarProductos();
        cargarServicios();
    });

    // Función para realizar la búsqueda por DNI
    async function buscarPorDni(dni) {
        document.getElementById('nombrePersona').value = '';
        document.getElementById('apellidoPersona').value = '';
        document.getElementById('telefonoPersona').value = '';

        try {
            const response = await fetch(`../../controllers/persona.controller.php?operation=searchByDoc&nrodocumento=${dni}`);
            const persona = await response.json();

            if (persona.length > 0) {
                const datosPersona = persona[0];
                document.getElementById('nombrePersona').value = datosPersona.nombre;
                document.getElementById('apellidoPersona').value = datosPersona.apellido;
                document.getElementById('telefonoPersona').value = datosPersona.telefono;
                document.getElementById('idpersona').value = datosPersona.idpersona;

                document.getElementById('nombrePersona').disabled = true;
                document.getElementById('apellidoPersona').disabled = true;
                document.getElementById('telefonoPersona').disabled = true;
            } else {
                alert('Persona no encontrada con ese DNI.');
            }
        } catch (error) {
            console.error('Error al buscar persona por DNI:', error);
        }
    }

    // Evento para buscar cuando se hace clic en el botón
    document.getElementById('buscar-dni').addEventListener('click', function() {
        const dni = document.getElementById('dniPersona').value.trim();
        if (dni.length === 8 && /^[0-9]+$/.test(dni)) {
            buscarPorDni(dni);
        } else {
            alert('Por favor ingresa un DNI válido.');
        }
    });

    // Función para cargar las reservas
    function cargarReservas() {
        fetch('../../controllers/reserva.controller.php?action=listar_reserva')
            .then(response => response.json())
            .then(data => {
                const tbody = document.getElementById('listaReservas');
                tbody.innerHTML = '';

                if (data.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="12">No hay reservas disponibles.</td></tr>';
                    return;
                }

                data.forEach(reserva => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${reserva.idreserva}</td>
                        <td>${reserva.nombre_completo}</td>
                        <td>${reserva.nroDocumento}</td>
                        <td>${reserva.nombre_complejo}</td>
                        <td>${reserva.tipoDeporte}</td>
                        <td>${reserva.nombre_campo}</td>
                        <td>${reserva.fechaInicio}</td>
                        <td>${reserva.horaInicio}</td>
                        <td>${reserva.fechaFin}</td>
                        <td>S/ ${parseFloat(reserva.montototal).toFixed(2)}</td>
                        <td><button class="btn btn-secondary btn-sm">${reserva.estado}</button></td>
                        <td>
                            <button class="btn btn-info btn-sm" onclick="generarPDF(${reserva.idreserva})">PDF</button>
                            <button class="btn btn-warning btn-sm" onclick="editarReserva(${reserva.idreserva})">Editar</button>
                            <button class="btn btn-danger btn-sm" onclick="eliminarReserva(${reserva.idreserva})">Eliminar</button>
                        </td>
                    `;
                    tbody.appendChild(row);
                });
            })
            .catch(error => console.error('Error al cargar las reservas:', error));
    }
    // Llamar a la función cargarReservas al cargar la página
    document.addEventListener('DOMContentLoaded', function() {
        cargarReservas();
        cargarComplejosDeportivos();
        cargarProductos();
        cargarServicios();
    });

    // Funciones para las acciones
    function generarPDF(id) {
        console.log("Generar PDF para reserva " + id);
        // Lógica para generar el PDF
    }

    function editarReserva(id) {
        console.log("Editar reserva " + id);
        // Lógica para editar la reserva
    }

    // Función para eliminar reserva
    function eliminarReserva(id) {
        if (!confirm('¿Estás seguro de que deseas eliminar esta reserva?')) {
            return;
        }

        fetch(`../../controllers/reserva.controller.php?action=eliminar_reserva&idreserva=${id}`, {
                method: 'DELETE'
            })
            .then(response => response.json())
            .then(data => {
                if (data.mensaje) {
                    alert(data.mensaje);
                    cargarReservas();
                } else if (data.error) {
                    alert('Error: ' + data.error);
                }
            })
            .catch(error => {
                console.error('Error al eliminar la reserva:', error);
                alert('Ocurrió un error al eliminar la reserva.');
            });
    }

    // Función para calcular fechaFin y precioReserva
    function calcularFechaFinYPrecio() {
        const fechaInicio = document.getElementById('fechaInicio').value;
        const horaInicio = document.getElementById('horaInicio').value;
        const horaReservaInput = document.getElementById('horaReserva');
        const horaReserva = parseInt(horaReservaInput.value);
        const tarifaCampo = parseFloat(document.getElementById('tarifaCampo').value);

        if (horaReserva <= 0 || isNaN(horaReserva)) {
            horaReservaInput.value = '';
            document.getElementById('fechaFin').value = '';
            document.getElementById('precioReserva').value = '';
            calcularMontoTotal();
            return;
        }

        if (fechaInicio && horaInicio && horaReserva && tarifaCampo) {
            const [year, month, day] = fechaInicio.split('-').map(Number);
            const [hour, minute] = horaInicio.split(':').map(Number);

            const fechaHoraInicio = new Date(year, month - 1, day, hour, minute);
            const fechaHoraFin = new Date(fechaHoraInicio.getTime() + horaReserva * 60 * 60 * 1000);

            const yearFin = fechaHoraFin.getFullYear();
            const monthFin = ('0' + (fechaHoraFin.getMonth() + 1)).slice(-2);
            const dayFin = ('0' + fechaHoraFin.getDate()).slice(-2);
            const hourFin = ('0' + fechaHoraFin.getHours()).slice(-2);
            const minuteFin = ('0' + fechaHoraFin.getMinutes()).slice(-2);
            const fechaFin = `${yearFin}-${monthFin}-${dayFin}T${hourFin}:${minuteFin}`;

            document.getElementById('fechaFin').value = fechaFin;

            const precioReserva = tarifaCampo * horaReserva;
            document.getElementById('precioReserva').value = precioReserva.toFixed(2);

            calcularMontoTotal();
        } else {
            document.getElementById('fechaFin').value = '';
            document.getElementById('precioReserva').value = '';
            calcularMontoTotal();
        }
    }

    // Eventos para recalcular fechaFin y precioReserva
    document.getElementById('fechaInicio').addEventListener('change', calcularFechaFinYPrecio);
    document.getElementById('horaInicio').addEventListener('change', calcularFechaFinYPrecio);
    document.getElementById('horaReserva').addEventListener('change', calcularFechaFinYPrecio);
    document.getElementById('horaReserva').addEventListener('input', function() {
        if (this.value < 1) {
            this.value = '';
        }
    });

    // Función para calcular montoTotal
    function calcularMontoTotal() {
        const precioReserva = parseFloat(document.getElementById('precioReserva').value) || 0;

        let totalProductos = 0;
        const productos = document.querySelectorAll('#listaProductos tr');
        productos.forEach(fila => {
            const total = parseFloat(fila.querySelector('.total').textContent) || 0;
            totalProductos += total;
        });

        let totalServicios = 0;
        const servicios = document.querySelectorAll('#listaServicios tr');
        servicios.forEach(fila => {
            const total = parseFloat(fila.querySelector('.total').textContent) || 0;
            totalServicios += total;
        });

        const montoTotal = precioReserva + totalProductos + totalServicios;
        document.getElementById('montoTotal').textContent = montoTotal.toFixed(2);
    }

    // Cargar productos y manejar su selección
    async function cargarProductos() {
        try {
            const response = await fetch('../../controllers/producto.controller.php?action=mostrarNombresProductos');
            const productos = await response.json();
            window.productosDisponibles = productos; // Guardamos los productos para usarlos más adelante
        } catch (error) {
            console.error('Error al cargar los productos:', error);
        }
    }

    // Cargar servicios y manejar su selección
    async function cargarServicios() {
        try {
            const response = await fetch('../../controllers/servicio.controller.php?action=mostrarServicios');
            const servicios = await response.json();
            window.serviciosDisponibles = servicios; // Guardamos los servicios para usarlos más adelante
        } catch (error) {
            console.error('Error al cargar los servicios:', error);
        }
    }

    // Evento para agregar producto
    document.getElementById('btnAgregarProducto').addEventListener('click', function() {
        // Crear el contenido del modal de productos dinámicamente
        const modalContent = `
            <div class="modal fade" id="modalAgregarProducto" tabindex="-1" aria-labelledby="modalAgregarProductoLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Seleccionar Producto</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <select class="form-select" id="productoSeleccionar">
                                <option value="">Selecciona un producto</option>
                                ${window.productosDisponibles.map(producto => `<option value="${producto.nombre}">${producto.nombre} (${producto.cantidad})</option>`).join('')}
                            </select>
                            <div class="mt-3">
                                <label for="cantidadProducto" class="form-label">Cantidad:</label>
                                <input type="number" class="form-control" id="cantidadProducto" value="1" min="1">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="confirmarAgregarProducto">Agregar Producto</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // Agregar el modal al body
        document.body.insertAdjacentHTML('beforeend', modalContent);

        // Mostrar el modal
        const modalAgregarProducto = new bootstrap.Modal(document.getElementById('modalAgregarProducto'));
        modalAgregarProducto.show();

        // Evento para confirmar agregar producto desde el modal
        document.getElementById('confirmarAgregarProducto').addEventListener('click', async () => {
            const productoSeleccionado = document.getElementById('productoSeleccionar').value;
            const cantidadProducto = parseInt(document.getElementById('cantidadProducto').value);

            if (!productoSeleccionado) {
                alert("Por favor, selecciona un producto.");
                return;
            }

            if (cantidadProducto <= 0 || isNaN(cantidadProducto)) {
                alert("La cantidad debe ser al menos 1.");
                return;
            }

            const productosEnLista = document.querySelectorAll('#listaProductos tr');
            for (const fila of productosEnLista) {
                const nombreProductoEnLista = fila.cells[1].textContent;
                if (nombreProductoEnLista === productoSeleccionado) {
                    alert("Este producto ya ha sido añadido.");
                    return;
                }
            }

            try {
                const response = await fetch(`../../controllers/producto.controller.php?action=mostrarDetallesProducto&nombre_producto=${encodeURIComponent(productoSeleccionado)}&cantidad_deseada=${cantidadProducto}`);
                const productoDetalles = await response.json();

                if (productoDetalles.error) {
                    alert(productoDetalles.error);
                } else {
                    const fila = document.createElement('tr');
                    fila.innerHTML = `
                        <td><button type="button" class="btn btn-danger btn-sm eliminarProducto">Eliminar</button></td>
                        <td>${productoDetalles.nombre}</td>
                        <td><input type="number" class="form-control form-control-sm cantidad" value="${cantidadProducto}" min="1"></td>
                        <td>${productoDetalles.precio}</td>
                        <td class="total">${(productoDetalles.precio * cantidadProducto).toFixed(2)}</td>
                    `;
                    document.getElementById('listaProductos').appendChild(fila);

                    const cantidadInput = fila.querySelector('.cantidad');
                    cantidadInput.addEventListener('change', async (event) => {
                        const nuevaCantidad = event.target.value;
                        if (nuevaCantidad > 0) {
                            const response = await fetch(`../../controllers/producto.controller.php?action=mostrarDetallesProducto&nombre_producto=${encodeURIComponent(productoDetalles.nombre)}&cantidad_deseada=${nuevaCantidad}`);
                            const productoDetallesActualizados = await response.json();

                            if (productoDetallesActualizados.error) {
                                alert(productoDetallesActualizados.error);
                                cantidadInput.value = cantidadProducto;
                                fila.querySelector('.total').textContent = (productoDetalles.precio * cantidadProducto).toFixed(2);
                            } else {
                                const total = (productoDetalles.precio * nuevaCantidad).toFixed(2);
                                fila.querySelector('.total').textContent = total;
                            }

                            calcularMontoTotal();
                        } else {
                            cantidadInput.value = cantidadProducto;
                            alert("La cantidad debe ser al menos 1.");
                        }
                    });

                    fila.querySelector('.eliminarProducto').addEventListener('click', function() {
                        eliminarProducto(this);
                    });

                    calcularMontoTotal();

                    // Cerrar y eliminar el modal
                    modalAgregarProducto.hide();
                    document.getElementById('modalAgregarProducto').remove();
                }
            } catch (error) {
                console.error('Error al agregar el producto:', error);
            }
        });
    });

    // Función para eliminar producto de la lista
    function eliminarProducto(btn) {
        const fila = btn.closest('tr');
        fila.remove();
        calcularMontoTotal();
    }

    // Evento para agregar servicio
    document.getElementById('btnAgregarServicio').addEventListener('click', function() {
        // Crear el contenido del modal de servicios dinámicamente
        const modalContent = `
            <div class="modal fade" id="modalAgregarServicio" tabindex="-1" aria-labelledby="modalAgregarServicioLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Seleccionar Servicio</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <select class="form-select" id="servicioSeleccionar">
                                <option value="">Selecciona un servicio</option>
                                ${window.serviciosDisponibles.map(servicio => `<option value="${servicio.nombre}">${servicio.nombre}</option>`).join('')}
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="confirmarAgregarServicio">Agregar Servicio</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // Agregar el modal al body
        document.body.insertAdjacentHTML('beforeend', modalContent);

        // Mostrar el modal
        const modalAgregarServicio = new bootstrap.Modal(document.getElementById('modalAgregarServicio'));
        modalAgregarServicio.show();

        // Evento para confirmar agregar servicio desde el modal
        document.getElementById('confirmarAgregarServicio').addEventListener('click', async () => {
            const servicioSeleccionado = document.getElementById('servicioSeleccionar').value;

            if (!servicioSeleccionado) {
                alert("Por favor, selecciona un servicio.");
                return;
            }

            const serviciosEnLista = document.querySelectorAll('#listaServicios tr');
            for (const fila of serviciosEnLista) {
                const nombreServicioEnLista = fila.cells[1].textContent;
                if (nombreServicioEnLista === servicioSeleccionado) {
                    alert("Este servicio ya ha sido añadido.");
                    return;
                }
            }

            try {
                const response = await fetch(`../../controllers/servicio.controller.php?action=mostrarDetallesServicio&nombre_servicio=${encodeURIComponent(servicioSeleccionado)}`);
                const servicioDetalles = await response.json();

                if (servicioDetalles.error) {
                    alert(servicioDetalles.error);
                    return;
                }

                if (Array.isArray(servicioDetalles) && servicioDetalles.length > 0) {
                    const servicio = servicioDetalles[0];
                    const costoServicio = parseFloat(servicio.costo);
                    const totalServicio = costoServicio;

                    if (isNaN(costoServicio) || !servicio.nombre) {
                        alert('Detalles del servicio incompletos o inválidos.');
                        return;
                    }

                    const fila = document.createElement('tr');
                    fila.innerHTML = `
                        <td><button type="button" class="btn btn-danger btn-sm eliminarServicio">Eliminar</button></td>
                        <td>${servicio.nombre}</td>
                        <td>${costoServicio.toFixed(2)}</td>
                        <td class="total">${totalServicio.toFixed(2)}</td>
                    `;
                    document.getElementById('listaServicios').appendChild(fila);

                    fila.querySelector('.eliminarServicio').addEventListener('click', function() {
                        eliminarServicio(this);
                    });

                    calcularMontoTotal();

                    // Cerrar y eliminar el modal
                    modalAgregarServicio.hide();
                    document.getElementById('modalAgregarServicio').remove();
                } else {
                    alert('Servicio no encontrado.');
                }

            } catch (error) {
                console.error('Error al obtener los detalles del servicio:', error);
                alert('Ocurrió un error al obtener los detalles del servicio.');
            }
        });
    });

    // Función para eliminar servicio de la lista
    function eliminarServicio(btn) {
        const fila = btn.closest('tr');
        fila.remove();
        calcularMontoTotal();
    }

    // Evento al hacer clic en el botón para seleccionar hora
    document.getElementById('btnSeleccionarHora').addEventListener('click', async function() {
        const fechaInicio = document.getElementById('fechaInicio').value;
        const horasReservar = parseInt(document.getElementById('horaReserva').value);
        const idCampo = document.getElementById('idcampo').value;

        if (!fechaInicio) {
            alert('Por favor, selecciona una fecha de inicio.');
            return;
        }

        if (!horasReservar || horasReservar <= 0) {
            alert('Por favor, ingresa las horas a reservar.');
            return;
        }

        if (!idCampo) {
            alert('Por favor, selecciona un campo.');
            return;
        }

        // Obtener las horas ocupadas
        await obtenerHorasOcupadas(fechaInicio, idCampo);

        // Generar las horas disponibles
        generarHorasDisponibles(horasReservar);

        // Mostrar el modal
        const modalHoras = new bootstrap.Modal(document.getElementById('modalHorasDisponibles'));
        modalHoras.show();
    });

    // Función para obtener las horas ocupadas de una fecha
    async function obtenerHorasOcupadas(fecha, idCampo) {
        try {
            const response = await fetch(`../../controllers/reserva.controller.php?action=obtener_horas_ocupadas&idcampo=${idCampo}&fecha=${fecha}`);
            const data = await response.json();
            if (data.error) {
                console.error(data.error);
            } else {
                horasOcupadas = data;
            }
        } catch (error) {
            console.error('Error al obtener las horas ocupadas:', error);
            alert('Ocurrió un error al obtener las horas ocupadas. Por favor, inténtalo de nuevo más tarde.');
        }
    }

    function generarHorasDisponibles(horasReservar) {
        const listaHoras = document.getElementById('listaHorasDisponibles');
        listaHoras.innerHTML = '';

        const horaApertura = 0;
        const horaCierre = 23;

        const horasTotales = [];
        for (let i = horaApertura; i <= horaCierre; i++) {
            horasTotales.push(i);
        }

        const horasNoDisponibles = [];

        horasOcupadas.forEach(reserva => {
            const horaInicioReserva = parseInt(reserva.horaInicio.split(':')[0]);
            const horasDuracion = parseInt(reserva.horaReservar);

            for (let i = 0; i < horasDuracion; i++) {
                let hora = (horaInicioReserva + i) % 24;
                horasNoDisponibles.push(hora);
            }
        });

        const horasDisponibles = horasTotales.filter(hora => !horasNoDisponibles.includes(hora));

        const franjasDisponibles = [];

        for (let i = 0; i < horasDisponibles.length; i++) {
            let franja = [];
            for (let j = 0; j < horasReservar; j++) {
                let hora = (horasDisponibles[i + j]) % 24;
                if (horasDisponibles.includes(hora)) {
                    franja.push(hora);
                } else {
                    break;
                }
            }
            if (franja.length === horasReservar && ((franja[franja.length - 1] - franja[0] + 24) % 24 === horasReservar - 1 || franja[franja.length - 1] - franja[0] === horasReservar - 1)) {
                franjasDisponibles.push(franja);
            }
        }

        franjasDisponibles.forEach(franja => {
            const horaInicio = franja[0];
            const horaFin = (franja[franja.length - 1] + 1) % 24;

            const textoHoraInicio = convertirHoraFormato12(horaInicio);
            const textoHoraFin = convertirHoraFormato12(horaFin);

            const boton = document.createElement('button');
            boton.classList.add('btn', 'btn-outline-primary', 'm-2');
            boton.textContent = `${textoHoraInicio} - ${textoHoraFin}`;
            boton.addEventListener('click', function() {
                seleccionarHora(franja[0]);
            });

            listaHoras.appendChild(boton);
        });

        if (franjasDisponibles.length === 0) {
            listaHoras.innerHTML = '<p>No hay horas disponibles para esta fecha y duración.</p>';
        }
    }

    // Función para convertir hora en formato 24 horas a 12 horas con a.m./p.m.
    function convertirHoraFormato12(hora24) {
        const periodo = hora24 >= 12 ? 'p.m.' : 'a.m.';
        let hora12 = hora24 % 12;
        hora12 = hora12 ? hora12 : 12;
        return `${hora12}:00 ${periodo}`;
    }

    function seleccionarHora(hora) {
        const horaInicio = ('0' + hora).slice(-2) + ':00';
        document.getElementById('horaInicio').value = horaInicio;

        // Recalcular fecha de fin y precio
        calcularFechaFinYPrecio();

        // Cerrar el modal
        const modalHoras = bootstrap.Modal.getInstance(document.getElementById('modalHorasDisponibles'));
        modalHoras.hide();
    }

    // Añadir un evento para resetear el formulario cuando se cierra el modal
    document.getElementById('modalNuevaReserva').addEventListener('hidden.bs.modal', function() {
        // Resetear el formulario
        document.getElementById('formNuevaReserva').reset();

        // Limpiar campos ocultos
        document.getElementById('idpersona').value = '';
        document.getElementById('idcampo').value = '';

        // Limpiar campos de persona
        document.getElementById('nombrePersona').value = '';
        document.getElementById('apellidoPersona').value = '';
        document.getElementById('telefonoPersona').value = '';
        document.getElementById('nombrePersona').disabled = true;
        document.getElementById('apellidoPersona').disabled = true;
        document.getElementById('telefonoPersona').disabled = true;

        // Limpiar campos de campo
        document.getElementById('tarifaCampo').value = '';
        document.getElementById('ubicacionCampo').value = '';

        // Limpiar selects
        document.getElementById('tipoDeporte').selectedIndex = 0;
        document.getElementById('nombreCampo').innerHTML = '<option value="">Selecciona un campo</option>';

        // Limpiar lista de productos y servicios
        document.getElementById('listaProductos').innerHTML = '';
        document.getElementById('listaServicios').innerHTML = '';

        // Resetear monto total
        document.getElementById('montoTotal').textContent = '0.00';
    });

    // Manejo del envío del formulario
    document.getElementById('formNuevaReserva').addEventListener('submit', function(event) {
        event.preventDefault();

        const horaReservaInput = document.getElementById('horaReserva');
        const horaReserva = parseInt(horaReservaInput.value);

        if (horaReserva <= 0 || isNaN(horaReserva)) {
            alert('Las horas a reservar deben ser un número positivo.');
            return;
        }

        const data = {
            idpersona: document.getElementById('idpersona').value,
            idcampo: document.getElementById('idcampo').value,
            fechaInicio: document.getElementById('fechaInicio').value,
            horaInicio: document.getElementById('horaInicio').value,
            horaReservar: horaReservaInput.value,
            productos: [],
            servicios: [],
        };

        const productosRows = document.querySelectorAll('#listaProductos tr');
        productosRows.forEach(row => {
            const nombre = row.cells[1].textContent;
            const cantidad = row.cells[2].querySelector('input').value;
            const precio = parseFloat(row.cells[3].textContent);
            const total = parseFloat(row.cells[4].textContent);

            data.productos.push({
                nombre,
                cantidad,
                precio,
                total
            });
        });

        const serviciosRows = document.querySelectorAll('#listaServicios tr');
        serviciosRows.forEach(row => {
            const nombre = row.cells[1].textContent;
            const precio = parseFloat(row.cells[2].textContent);
            const total = parseFloat(row.cells[3].textContent);

            data.servicios.push({
                nombre,
                precio,
                total
            });
        });

        fetch('../../controllers/reserva.controller.php?action=registrar_reserva', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(result => {
                if (result.error) {
                    alert('Error: ' + result.error);
                } else {
                    alert('Reserva registrada correctamente');
                    const modalNuevaReserva = bootstrap.Modal.getInstance(document.getElementById('modalNuevaReserva'));
                    modalNuevaReserva.hide();
                    cargarReservas();

                    // Resetear el formulario
                    document.getElementById('formNuevaReserva').reset();

                    // Limpiar campos ocultos
                    document.getElementById('idpersona').value = '';
                    document.getElementById('idcampo').value = '';

                    // Limpiar campos de persona
                    document.getElementById('nombrePersona').value = '';
                    document.getElementById('apellidoPersona').value = '';
                    document.getElementById('telefonoPersona').value = '';
                    document.getElementById('nombrePersona').disabled = true;
                    document.getElementById('apellidoPersona').disabled = true;
                    document.getElementById('telefonoPersona').disabled = true;

                    // Limpiar campos de campo
                    document.getElementById('tarifaCampo').value = '';
                    document.getElementById('ubicacionCampo').value = '';

                    // Limpiar selects
                    document.getElementById('tipoDeporte').selectedIndex = 0;
                    document.getElementById('nombreCampo').innerHTML = '<option value="">Selecciona un campo</option>';

                    // Limpiar lista de productos y servicios
                    document.getElementById('listaProductos').innerHTML = '';
                    document.getElementById('listaServicios').innerHTML = '';

                    // Resetear monto total
                    document.getElementById('montoTotal').textContent = '0.00';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Ocurrió un error al registrar la reserva.');
            });
    });
</script>