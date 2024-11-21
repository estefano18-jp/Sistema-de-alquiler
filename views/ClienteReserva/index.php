<?php
session_start();
// Verificar si el cliente ha iniciado sesión
if (!isset($_SESSION['login']) || $_SESSION['login']['rol'] !== 'cliente') {
    header('Location: ../../index.php');
    exit();
}

// Obtener ID del campo seleccionado desde la URL
$idCampo = $_GET['idcampo'] ?? null;

if (!$idCampo) {
    echo "No se ha seleccionado ningún campo.";
    exit();
}

// Obtener ID del usuario desde la sesión
$idUsuario = $_SESSION['login']['idusuario'];

// Función para realizar solicitudes GET internas
function httpGet($url)
{
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $output = curl_exec($ch);

    curl_close($ch);
    return $output;
}

// Obtener datos del cliente
$urlCliente = "http://localhost/AlquilerCampoDeportivo/controllers/usuario.controller.php?operation=obtener_datos_usuario&idusuario={$idUsuario}";
$datosClienteJson = httpGet($urlCliente);
$datosCliente = json_decode($datosClienteJson, true);

// Manejar posibles errores al obtener datos del cliente
if (isset($datosCliente['error'])) {
    echo "Error al obtener datos del cliente: " . $datosCliente['error'];
    exit();
}

// Obtener datos del campo
$urlCampo = "http://localhost/AlquilerCampoDeportivo/controllers/campo.controller.php?operation=obtenerDatosCampo&idcampo={$idCampo}";
$datosCampoJson = httpGet($urlCampo);
$datosCampo = json_decode($datosCampoJson, true);

// Manejar posibles errores al obtener datos del campo
if (isset($datosCampo['error'])) {
    echo "Error al obtener datos del campo: " . $datosCampo['error'];
    exit();
}

// Obtener datos del complejo deportivo asociado al campo
$idComplejo = $datosCampo['idcomplejo'] ?? null;

if (!$idComplejo) {
    echo "No se pudo obtener el complejo deportivo asociado al campo.";
    exit();
}

$urlComplejo = "http://localhost/AlquilerCampoDeportivo/controllers/complejo.controller.php?idcomplejo={$idComplejo}";
$datosComplejoJson = httpGet($urlComplejo);
$datosComplejo = json_decode($datosComplejoJson, true);

// Manejar posibles errores al obtener datos del complejo
if (isset($datosComplejo['error'])) {
    echo "Error al obtener datos del complejo deportivo: " . $datosComplejo['error'];
    exit();
}

// Incluir el header del cliente (Dashboard)
require_once '../include/header.cliente.php';
?>

<!-- Contenido del Dashboard -->
<div class="container-fluid px-4" style="margin-top: -20px;">
    <h2 class="mt-2 text-center" style="font-weight: bold; color: #333;">Formulario de Reserva</h2>

    <!-- Botón para volver -->
    <div class="mb-3">
        <a href="./seleccionReserva.php" class="btn btn-outline-secondary">
            <i class="fa-solid fa-arrow-left me-2"></i>Volver
        </a>
    </div>

    <!-- Envolver el formulario en una tarjeta -->
    <div class="card mb-4" style="background-color: rgba(255, 255, 255, 0.95); border: none; box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);">
        <div class="card-body">
            <!-- Formulario de Reserva -->
            <form id="formReserva">
                <!-- Información del Cliente y del Campo -->
                <div class="row">
                    <!-- Información del Cliente -->
                    <div class="col-md-6">
                        <div class="card mb-3" style="background-color: rgba(245, 245, 245, 0.8);">
                            <div class="card-header" style="background-color: rgba(0, 123, 255, 0.1); font-weight: bold;">
                                <i class="fa-solid fa-user me-2"></i>Información del Cliente
                            </div>
                            <div class="card-body">
                                <!-- DNI y Nombre -->
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="dniPersona" class="form-label">DNI</label>
                                        <input type="text" class="form-control" id="dniPersona" value="<?= htmlspecialchars($datosCliente['nrodocumento']) ?>" disabled>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="nombrePersona" class="form-label">Nombre</label>
                                        <input type="text" class="form-control" id="nombrePersona" value="<?= htmlspecialchars($datosCliente['nombre']) ?>" disabled>
                                    </div>
                                </div>
                                <!-- Apellido y Teléfono -->
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="apellidoPersona" class="form-label">Apellido</label>
                                        <input type="text" class="form-control" id="apellidoPersona" value="<?= htmlspecialchars($datosCliente['apellido']) ?>" disabled>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="telefonoPersona" class="form-label">Teléfono</label>
                                        <input type="text" class="form-control" id="telefonoPersona" value="<?= htmlspecialchars($datosCliente['telefono']) ?>" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Información del Campo -->
                    <div class="col-md-6">
                        <div class="card mb-3" style="background-color: rgba(245, 245, 245, 0.8);">
                            <div class="card-header" style="background-color: rgba(0, 123, 255, 0.1); font-weight: bold;">
                                <i class="fa-solid fa-futbol me-2"></i>Información del Campo
                            </div>
                            <div class="card-body">
                                <!-- Primera Fila: Complejo Deportivo - Tipo de Deporte - Nombre del Campo -->
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="nombreComplejo" class="form-label">Complejo Deportivo</label>
                                        <input type="text" class="form-control" id="nombreComplejo" value="<?= htmlspecialchars($datosComplejo['nombreComplejo']) ?>" disabled>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="tipoDeporte" class="form-label">Tipo de Deporte</label>
                                        <input type="text" class="form-control" id="tipoDeporte" value="<?= htmlspecialchars($datosCampo['tipoDeporte']) ?>" disabled>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="nombreCampo" class="form-label">Nombre del Campo</label>
                                        <input type="text" class="form-control" id="nombreCampo" value="<?= htmlspecialchars($datosCampo['nombreCampo']) ?>" disabled>
                                    </div>
                                </div>
                                <!-- Segunda Fila: Tarifa por Hora - Ubicación del Complejo Deportivo -->
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="tarifaCampo" class="form-label">Tarifa por Hora</label>
                                        <input type="text" class="form-control" id="tarifaCampo" value="<?= htmlspecialchars($datosCampo['precioHora']) ?>" disabled>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="ubicacionComplejo" class="form-label">Ubicación del Complejo Deportivo</label>
                                        <input type="text" class="form-control" id="ubicacionComplejo" value="<?= htmlspecialchars($datosComplejo['direccion']) ?>" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detalles de la Reserva -->
                <div class="card mb-3" style="background-color: rgba(245, 245, 245, 0.8);">
                    <div class="card-header" style="background-color: rgba(0, 123, 255, 0.1); font-weight: bold;">
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
                                <div class="input-group">
                                    <input type="text" class="form-control" id="horaInicio" name="horaInicio" readonly required>
                                    <button type="button" class="btn btn-outline-secondary" id="btnSeleccionarHora">
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
                        <div class="card" style="background-color: rgba(245, 245, 245, 0.8);">
                            <div class="card-header" style="background-color: rgba(0, 123, 255, 0.1); font-weight: bold;">
                                <i class="fa-solid fa-shopping-cart me-2"></i>Productos Adicionales
                            </div>
                            <div class="card-body">
                                <!-- Botón para abrir modal de productos -->
                                <button type="button" class="btn btn-outline-secondary mb-2" id="btnAgregarProducto" data-bs-toggle="modal" data-bs-target="#modalProductos">
                                    <i class="fa-solid fa-plus"></i> Agregar Producto
                                </button>
                                <div class="border rounded" style="max-height: 200px; overflow-y: auto;">
                                    <table class="table table-hover">
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
                        <div class="card" style="background-color: rgba(245, 245, 245, 0.8);">
                            <div class="card-header" style="background-color: rgba(0, 123, 255, 0.1); font-weight: bold;">
                                <i class="fa-solid fa-concierge-bell me-2"></i>Servicios Adicionales
                            </div>
                            <div class="card-body">
                                <!-- Botón para abrir modal de servicios -->
                                <button type="button" class="btn btn-outline-secondary mb-2" id="btnAgregarServicio" data-bs-toggle="modal" data-bs-target="#modalServicios">
                                    <i class="fa-solid fa-plus"></i> Agregar Servicio
                                </button>
                                <div class="border rounded" style="max-height: 200px; overflow-y: auto;">
                                    <table class="table table-hover">
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
                        <h4 class="text-end" style="font-weight: bold; color: #333;">Monto Total: S/<span id="montoTotal">0.00</span></h4>
                    </div>
                </div>

                <!-- Botones para Guardar Reserva y Resetear -->
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="button" class="btn btn-outline-secondary me-md-2" id="btnResetearFormulario">
                        <i class="fa-solid fa-undo me-2"></i>Resetear
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-save me-2"></i>Guardar Reserva
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para seleccionar productos -->
<div class="modal fade" id="modalProductos" tabindex="-1" aria-labelledby="modalProductosLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Seleccionar Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <select class="form-select" id="productoSeleccionar">
                    <!-- Opciones cargadas dinámicamente -->
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

<!-- Modal para seleccionar servicios -->
<div class="modal fade" id="modalServicios" tabindex="-1" aria-labelledby="modalServiciosLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Seleccionar Servicio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <select class="form-select" id="servicioSeleccionar">
                    <!-- Opciones cargadas dinámicamente -->
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="confirmarAgregarServicio">Agregar Servicio</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
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

<?php
// Incluir el footer del cliente (Dashboard)
require_once '../include/footer.php';
?>

<!-- Scripts personalizados para el formulario de reserva -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const idUsuario = <?= json_encode($idUsuario) ?>;
        const idCampo = <?= json_encode($idCampo) ?>;
        const tarifaHora = parseFloat(document.getElementById('tarifaCampo').value) || 0;

        // Variables para almacenar horas ocupadas
        let horasOcupadas = [];

        // Función para obtener las horas ocupadas de una fecha
        async function obtenerHorasOcupadas(fecha) {
            try {
                const response = await fetch(`../../controllers/reserva.controller.php?action=obtener_horas_ocupadas&idcampo=${idCampo}&fecha=${fecha}`);
                if (!response.ok) {
                    throw new Error('Error en la respuesta de la red al obtener horas ocupadas');
                }
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

        // Evento al cambiar la fecha o las horas a reservar
        document.getElementById('fechaInicio').addEventListener('change', actualizarHorasDisponibles);
        document.getElementById('horaReserva').addEventListener('change', actualizarHorasDisponibles);

        async function actualizarHorasDisponibles() {
            const fechaInicio = document.getElementById('fechaInicio').value;
            const horasReservar = parseInt(document.getElementById('horaReserva').value);

            if (fechaInicio && horasReservar > 0) {
                await obtenerHorasOcupadas(fechaInicio);
            }
        }

        // Evento al hacer clic en el botón para seleccionar hora
        document.getElementById('btnSeleccionarHora').addEventListener('click', async function() {
            const fechaInicio = document.getElementById('fechaInicio').value;
            const horasReservar = parseInt(document.getElementById('horaReserva').value);

            if (!fechaInicio) {
                alert('Por favor, selecciona una fecha de inicio.');
                return;
            }

            if (!horasReservar || horasReservar <= 0) {
                alert('Por favor, ingresa las horas a reservar.');
                return;
            }

            // Obtener las horas ocupadas nuevamente
            await obtenerHorasOcupadas(fechaInicio);

            // Generar las horas disponibles
            generarHorasDisponibles(horasReservar);

            // Mostrar el modal
            const modalHoras = new bootstrap.Modal(document.getElementById('modalHorasDisponibles'));
            modalHoras.show();
        });

        function generarHorasDisponibles(horasReservar) {
            const listaHoras = document.getElementById('listaHorasDisponibles');
            listaHoras.innerHTML = '';

            // Ahora el campo está disponible las 24 horas
            const horaApertura = 0;
            const horaCierre = 23;

            // Crear un array con todas las horas en el rango
            const horasTotales = [];
            for (let i = horaApertura; i <= horaCierre; i++) {
                horasTotales.push(i);
            }

            // Filtrar las horas que no están disponibles
            const horasNoDisponibles = [];

            horasOcupadas.forEach(reserva => {
                const horaInicioReserva = parseInt(reserva.horaInicio.split(':')[0]);
                const horasDuracion = parseInt(reserva.horaReservar);

                for (let i = 0; i < horasDuracion; i++) {
                    let hora = (horaInicioReserva + i) % 24; // Asegurar que la hora esté en el rango 0-23
                    horasNoDisponibles.push(hora);
                }
            });

            // Generar los bloques de tiempo disponibles
            const horasDisponibles = horasTotales.filter(hora => !horasNoDisponibles.includes(hora));

            // Generar las franjas horarias disponibles según las horas a reservar
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

            // Mostrar las franjas disponibles como botones con formato de 12 horas
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
            hora12 = hora12 ? hora12 : 12; // La hora 0 es 12 a.m.
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

        // Cargar productos y manejar su selección
        cargarProductos();

        async function cargarProductos() {
            try {
                const response = await fetch('../../controllers/producto.controller.php?action=mostrarNombresProductos');
                if (!response.ok) {
                    throw new Error('Error en la respuesta de la red al cargar productos');
                }
                const productos = await response.json();
                const productoSelect = document.getElementById('productoSeleccionar');
                productoSelect.innerHTML = '<option value="">Selecciona un producto</option>';

                productos.forEach(producto => {
                    const option = document.createElement('option');
                    option.value = producto.nombre;
                    option.textContent = `${producto.nombre} (${producto.cantidad})`;
                    productoSelect.appendChild(option);
                });
            } catch (error) {
                console.error('Error al cargar los productos:', error);
                alert('Ocurrió un error al cargar los productos. Por favor, inténtalo de nuevo más tarde.');
            }
        }

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
                if (!response.ok) {
                    throw new Error('Error en la respuesta de la red al obtener detalles del producto');
                }
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
                            try {
                                const response = await fetch(`../../controllers/producto.controller.php?action=mostrarDetallesProducto&nombre_producto=${encodeURIComponent(productoDetalles.nombre)}&cantidad_deseada=${nuevaCantidad}`);
                                if (!response.ok) {
                                    throw new Error('Error en la respuesta de la red al actualizar cantidad del producto');
                                }
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
                            } catch (error) {
                                console.error('Error al actualizar el producto:', error);
                                alert('Ocurrió un error al actualizar el producto. Por favor, inténtalo de nuevo más tarde.');
                            }
                        } else {
                            cantidadInput.value = cantidadProducto;
                            alert("La cantidad debe ser al menos 1.");
                        }
                    });

                    // Añadir evento al botón eliminar
                    fila.querySelector('.eliminarProducto').addEventListener('click', function() {
                        eliminarProducto(this);
                    });

                    calcularMontoTotal();

                    // Cerrar el modal
                    const modalProductos = bootstrap.Modal.getInstance(document.getElementById('modalProductos'));
                    modalProductos.hide();
                }
            } catch (error) {
                console.error('Error al agregar el producto:', error);
                alert('Ocurrió un error al agregar el producto. Por favor, inténtalo de nuevo más tarde.');
            }
        });

        // Función para eliminar producto de la lista
        function eliminarProducto(btn) {
            const fila = btn.closest('tr');
            fila.remove();
            calcularMontoTotal();
        }

        // Cargar servicios y manejar su selección
        cargarServicios();

        async function cargarServicios() {
            try {
                const response = await fetch('../../controllers/servicio.controller.php?action=mostrarServicios');
                if (!response.ok) {
                    throw new Error('Error en la respuesta de la red al cargar servicios');
                }
                const servicios = await response.json();
                const servicioSelect = document.getElementById('servicioSeleccionar');
                servicioSelect.innerHTML = '<option value="">Selecciona un servicio</option>';

                servicios.forEach(servicio => {
                    const option = document.createElement('option');
                    option.value = servicio.nombre;
                    option.textContent = servicio.nombre;
                    servicioSelect.appendChild(option);
                });
            } catch (error) {
                console.error('Error al cargar los servicios:', error);
                alert('Ocurrió un error al cargar los servicios. Por favor, inténtalo de nuevo más tarde.');
            }
        }

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
                if (!response.ok) {
                    throw new Error('Error en la respuesta de la red al obtener detalles del servicio');
                }
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

                    // Añadir evento al botón eliminar
                    fila.querySelector('.eliminarServicio').addEventListener('click', function() {
                        eliminarServicio(this);
                    });

                    calcularMontoTotal();

                    // Cerrar el modal
                    const modalServicios = bootstrap.Modal.getInstance(document.getElementById('modalServicios'));
                    modalServicios.hide();
                } else {
                    alert('Servicio no encontrado.');
                }

            } catch (error) {
                console.error('Error al obtener los detalles del servicio:', error);
                alert('Ocurrió un error al obtener los detalles del servicio. Por favor, inténtalo de nuevo más tarde.');
            }
        });

        // Función para eliminar servicio de la lista
        function eliminarServicio(btn) {
            const fila = btn.closest('tr');
            fila.remove();
            calcularMontoTotal();
        }

        // Función para calcular montoTotal
        function calcularMontoTotal() {
            const tarifaHora = parseFloat(document.getElementById('tarifaCampo').value) || 0;
            const horaReserva = parseInt(document.getElementById('horaReserva').value) || 0;
            const precioReserva = tarifaHora * horaReserva;
            document.getElementById('precioReserva').value = precioReserva.toFixed(2);

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

        // Eventos para recalcular fechaFin y precioReserva
        document.getElementById('fechaInicio').addEventListener('change', calcularFechaFinYPrecio);
        document.getElementById('horaInicio').addEventListener('change', calcularFechaFinYPrecio);
        document.getElementById('horaReserva').addEventListener('change', calcularFechaFinYPrecio);
        document.getElementById('horaReserva').addEventListener('input', function() {
            if (this.value < 1) {
                this.value = '';
            }
        });

        // Manejar el envío del formulario de reserva
        document.getElementById('formReserva').addEventListener('submit', async function(event) {
            event.preventDefault();

            const fechaInicio = document.getElementById('fechaInicio').value;
            const horaInicio = document.getElementById('horaInicio').value;
            const horaReservaInput = document.getElementById('horaReserva');
            const horaReservar = parseInt(horaReservaInput.value);
            const montoTotal = parseFloat(document.getElementById('montoTotal').textContent);

            if (!fechaInicio || !horaInicio || !horaReservar || horaReservar <= 0) {
                alert('Por favor, completa correctamente los detalles de la reserva.');
                return;
            }

            // Obtener productos agregados
            const productos = [];
            document.querySelectorAll('#listaProductos tr').forEach(row => {
                const nombre = row.cells[1].textContent;
                const cantidad = row.cells[2].querySelector('input').value;
                const precio = parseFloat(row.cells[3].textContent);
                const total = parseFloat(row.cells[4].textContent);

                productos.push({
                    nombre,
                    cantidad,
                    precio,
                    total
                });
            });

            // Obtener servicios agregados
            const servicios = [];
            document.querySelectorAll('#listaServicios tr').forEach(row => {
                const nombre = row.cells[1].textContent;
                const precio = parseFloat(row.cells[2].textContent);
                const total = parseFloat(row.cells[3].textContent);

                servicios.push({
                    nombre,
                    precio,
                    total
                });
            });

            // Preparar datos para enviar al backend
            const data = {
                idpersona: <?= json_encode($datosCliente['idpersona']) ?>,
                idcampo: <?= json_encode($idCampo) ?>,
                fechaInicio: fechaInicio,
                horaInicio: horaInicio,
                horaReservar: horaReservar,
                productos: productos,
                servicios: servicios
            };

            try {
                const response = await fetch('../../controllers/reserva.controller.php?action=registrar_reserva', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                });
                if (!response.ok) {
                    throw new Error('Error en la respuesta de la red al registrar la reserva');
                }
                const result = await response.json();

                if (result.mensaje) {
                    alert(result.mensaje);
                    // Resetear el formulario después de registrar la reserva
                    resetearFormulario();
                } else if (result.error) {
                    alert('Error: ' + result.error);
                }
            } catch (error) {
                console.error('Error al registrar la reserva:', error);
                alert('Ocurrió un error al registrar la reserva. Por favor, inténtalo de nuevo más tarde.');
            }
        });

        // Función para resetear el formulario
        function resetearFormulario() {
            // Resetear los campos del formulario
            document.getElementById('formReserva').reset();

            // Limpiar listas de productos y servicios
            document.getElementById('listaProductos').innerHTML = '';
            document.getElementById('listaServicios').innerHTML = '';

            // Resetear monto total
            document.getElementById('montoTotal').textContent = '0.00';

            // Resetear fecha y hora de fin
            document.getElementById('fechaFin').value = '';
            document.getElementById('precioReserva').value = '';
        }

        // Evento para el botón de resetear formulario
        document.getElementById('btnResetearFormulario').addEventListener('click', function() {
            if (confirm('¿Estás seguro de que deseas resetear el formulario?')) {
                resetearFormulario();
            }
        });

        // Manejador global de errores no capturados en promesas
        window.addEventListener('unhandledrejection', function(event) {
            console.error('Unhandled rejection (promise):', event.promise, 'reason:', event.reason);
        });
    });
</script>
