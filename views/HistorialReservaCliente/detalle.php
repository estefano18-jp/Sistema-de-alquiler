<?php
session_start();

// Verificar si el cliente ha iniciado sesión
if (!isset($_SESSION['login']) || $_SESSION['login']['rol'] !== 'cliente') {
    header('Location: ../../index.php');
    exit();
}

// Obtener ID de la reserva desde la URL
$idReserva = $_GET['idreserva'] ?? null;

if (!$idReserva) {
    echo "No se ha proporcionado un ID de reserva válido.";
    exit();
}

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

// Obtener detalles de la reserva
$urlDetalle = "http://localhost/AlquilerCampoDeportivo/controllers/reserva.controller.php?action=detalle_reserva&idreserva={$idReserva}";
$datosDetalleJson = httpGet($urlDetalle);
$datosDetalle = json_decode($datosDetalleJson, true);

// Manejar posibles errores al obtener detalles de la reserva
if (isset($datosDetalle['error'])) {
    echo "Error al obtener detalles de la reserva: " . $datosDetalle['error'];
    exit();
}

// Incluir el header del cliente (Dashboard)
require_once '../include/header.cliente.php';
?>

<!-- Contenido del Detalle de Reserva -->
<div class="container-fluid px-4" style="margin-top: -20px;">
    <h2 class="mt-2 text-center" style="font-weight: bold; color: #333;">Detalle de la Reserva #<?= htmlspecialchars($idReserva) ?></h2>

    <!-- Botón para volver al historial -->
    <div class="mb-3">
        <a href="index.php" class="btn btn-outline-secondary">
            <i class="fa-solid fa-arrow-left me-2"></i>Volver al Historial
        </a>
    </div>

    <!-- Información de la Reserva -->
    <div class="card mb-4" style="background-color: rgba(255, 255, 255, 0.95); border: none; box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);">
        <div class="card-body">
            <h4>Información General</h4>
            <p><strong>ID Reserva:</strong> <?= htmlspecialchars($datosDetalle['idreserva']) ?></p>
            <p><strong>Complejo Deportivo:</strong> <?= htmlspecialchars($datosDetalle['nombre_complejo']) ?></p>
            <p><strong>Campo:</strong> <?= htmlspecialchars($datosDetalle['nombre_campo']) ?></p>
            <p><strong>Tipo de Deporte:</strong> <?= htmlspecialchars($datosDetalle['tipoDeporte']) ?></p>
            <p><strong>Fecha de Inicio:</strong> <?= htmlspecialchars($datosDetalle['fechaInicio']) ?></p>
            <p><strong>Hora de Inicio:</strong> <?= htmlspecialchars($datosDetalle['horaInicio']) ?></p>
            <p><strong>Fecha y Hora de Fin:</strong> <?= htmlspecialchars($datosDetalle['fechaFin']) ?></p>
            <p><strong>Monto Total:</strong> S/ <?= htmlspecialchars(number_format($datosDetalle['montototal'], 2)) ?></p>
            <p><strong>Estado:</strong> 
                <?php
                    $estado = htmlspecialchars($datosDetalle['estado']);
                    $badgeClass = 'badge-secondary';
                    if ($estado === 'confirmada') {
                        $badgeClass = 'badge-success';
                    } elseif ($estado === 'cancelada') {
                        $badgeClass = 'badge-danger';
                    } elseif ($estado === 'pendiente') {
                        $badgeClass = 'badge-warning';
                    }
                ?>
                <span class="badge <?= $badgeClass ?>" style="<?= $estado === 'pendiente' ? 'color: #000; background-color: #ffc107; font-weight: bold;' : '' ?>">
                    <?= ucfirst($estado) ?>
                </span>
            </p>

            <hr>

            <h4>Productos Adicionales</h4>
            <?php if (empty($datosDetalle['productos'])): ?>
                <p>No se han agregado productos adicionales a esta reserva.</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Nombre</th>
                                <th>Cantidad</th>
                                <th>Precio Unitario (S/)</th>
                                <th>Total (S/)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($datosDetalle['productos'] as $producto): ?>
                                <tr>
                                    <td><?= htmlspecialchars($producto['nombre']) ?></td>
                                    <td><?= htmlspecialchars($producto['cantidad']) ?></td>
                                    <td><?= htmlspecialchars(number_format($producto['precio'], 2)) ?></td>
                                    <td><?= htmlspecialchars(number_format($producto['total'], 2)) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>

            <hr>

            <h4>Servicios Adicionales</h4>
            <?php if (empty($datosDetalle['servicios'])): ?>
                <p>No se han agregado servicios adicionales a esta reserva.</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Nombre</th>
                                <th>Precio (S/)</th>
                                <th>Total (S/)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($datosDetalle['servicios'] as $servicio): ?>
                                <tr>
                                    <td><?= htmlspecialchars($servicio['nombre']) ?></td>
                                    <td><?= htmlspecialchars(number_format($servicio['precio'], 2)) ?></td>
                                    <td><?= htmlspecialchars(number_format($servicio['total'], 2)) ?></td>
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
// Incluir el footer del cliente (Dashboard)
require_once '../include/footer.php';
?>
