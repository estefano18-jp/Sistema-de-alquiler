<?php
session_start();

// Verificar si el cliente ha iniciado sesión
if (!isset($_SESSION['login']) || $_SESSION['login']['rol'] !== 'cliente') {
    header('Location: ../../index.php');
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

// Obtener IDpersona del usuario
$urlPersona = "http://localhost/AlquilerCampoDeportivo/controllers/usuario.controller.php?operation=obtener_datos_usuario&idusuario={$idUsuario}";
$datosUsuarioJson = httpGet($urlPersona);
$datosUsuario = json_decode($datosUsuarioJson, true);

// Manejar posibles errores al obtener datos del usuario
if (isset($datosUsuario['error'])) {
    echo "Error al obtener datos del usuario: " . $datosUsuario['error'];
    exit();
}

$idpersona = $datosUsuario['idpersona'];

// Obtener reservas del cliente
$urlReservas = "http://localhost/AlquilerCampoDeportivo/controllers/reserva.controller.php?action=listar_reserva_por_persona&idpersona={$idpersona}";
$datosReservasJson = httpGet($urlReservas);
$datosReservas = json_decode($datosReservasJson, true);

// Manejar posibles errores al obtener reservas
if (isset($datosReservas['error'])) {
    echo "Error al obtener las reservas: " . $datosReservas['error'];
    exit();
}

// Incluir el header del cliente (Dashboard)
require_once '../include/header.cliente.php';
?>

<!-- Contenido del Historial de Reservas -->
<div class="container-fluid px-4" style="margin-top: -20px;">
    <h2 class="mt-2 text-center" style="font-weight: bold; color: #333;">Historial de Reservas</h2>

    <!-- Botón para volver al Dashboard -->
    <div class="mb-3">
        <a href="../../views/ClienteReserva/seleccionReserva.php" class="btn btn-outline-secondary">
            <i class="fa-solid fa-arrow-left me-2"></i>Volver al Dashboard
        </a>
    </div>

    <!-- Tabla de Reservas -->
    <div class="card mb-4" style="background-color: rgba(255, 255, 255, 0.95); border: none; box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);">
        <div class="card-body">
            <?php if (empty($datosReservas)): ?>
                <p class="text-center">No tienes reservas registradas.</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>ID Reserva</th>
                                <th>Complejo Deportivo</th>
                                <th>Campo</th>
                                <th>Tipo de Deporte</th>
                                <th>Fecha de Inicio</th>
                                <th>Hora de Inicio</th>
                                <th>Fecha y Hora de Fin</th>
                                <th>Monto Total (S/)</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($datosReservas as $reserva): ?>
                                <tr>
                                    <td><?= htmlspecialchars($reserva['idreserva']) ?></td>
                                    <td><?= htmlspecialchars($reserva['nombre_complejo']) ?></td>
                                    <td><?= htmlspecialchars($reserva['nombre_campo']) ?></td>
                                    <td><?= htmlspecialchars($reserva['tipoDeporte']) ?></td>
                                    <td><?= htmlspecialchars($reserva['fechaInicio']) ?></td>
                                    <td><?= htmlspecialchars($reserva['horaInicio']) ?></td>
                                    <td><?= htmlspecialchars($reserva['fechaFin']) ?></td>
                                    <td><?= htmlspecialchars(number_format($reserva['montototal'], 2)) ?></td>
                                    <td>
                                        <?php
                                        $estado = htmlspecialchars($reserva['estado']);
                                        // Definir la clase del badge según el estado
                                        switch (strtolower($estado)) {
                                            case 'confirmada':
                                                $badgeClass = 'badge-success';
                                                break;
                                            case 'cancelada':
                                                $badgeClass = 'badge-danger';
                                                break;
                                            case 'pendiente':
                                                $badgeClass = 'badge-warning'; // Clase para amarillo
                                                break;
                                            default:
                                                $badgeClass = 'badge-secondary';
                                                break;
                                        }
                                        ?>
                                        <span class="badge <?= $badgeClass ?>"><?= ucfirst($estado) ?></span>
                                    </td>
                                    <td>
                                        <a href="detalle.php?idreserva=<?= htmlspecialchars($reserva['idreserva']) ?>" class="btn btn-sm btn-primary">
                                            <i class="fa-solid fa-eye me-1"></i>Ver Detalle
                                        </a>
                                        <?php if ($reserva['estado'] !== 'cancelada'): ?>
                                            <button class="btn btn-sm btn-danger btn-eliminar-reserva" data-id="<?= htmlspecialchars($reserva['idreserva']) ?>">
                                                <i class="fa-solid fa-trash me-1"></i>Cancelar
                                            </button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
require_once '../include/footer.php';
?>

<!-- Scripts para manejar la eliminación de reservas -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const botonesEliminar = document.querySelectorAll('.btn-eliminar-reserva');

        botonesEliminar.forEach(function(boton) {
            boton.addEventListener('click', function() {
                const idReserva = this.getAttribute('data-id');
                if (confirm('¿Estás seguro de que deseas cancelar esta reserva?')) {
                    eliminarReserva(idReserva);
                }
            });
        });

        async function eliminarReserva(idReserva) {
            try {
                const response = await fetch(`../../controllers/reserva.controller.php?action=eliminar_reserva&idreserva=${idReserva}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                });

                const resultado = await response.json();

                if (resultado.mensaje) {
                    alert(resultado.mensaje);
                    // Recargar la página para actualizar la lista de reservas
                    location.reload();
                } else if (resultado.error) {
                    alert('Error: ' + resultado.error);
                }
            } catch (error) {
                console.error('Error al eliminar la reserva:', error);
                alert('Ocurrió un error al eliminar la reserva. Por favor, inténtalo de nuevo más tarde.');
            }
        }
    });
</script>

<!-- Estilos adicionales para personalizar el color del badge "pendiente" si es necesario -->
<style>
    .badge-warning {
        background-color: #ffc107;
        color: #212529;
    }
</style>