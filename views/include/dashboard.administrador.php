<?php  
require_once 'header.administrador.php';
require_once '../../models/Conexion.php';

// Asegurarse de que la sesión del cliente está activa
if (!isset($_SESSION['login']) || !$_SESSION['login']['permitido']) {
    header('Location: /AlquilerCampoDeportivo/index.php'); // Redirigir al inicio de sesión
    exit();
}

// Obtener los datos del cliente desde la sesión
$usuarioNombre = $_SESSION['login']['nombre'] ?? 'Cliente';
$usuarioApellido = $_SESSION['login']['apellido'] ?? '';


// Concatenar nombre y apellido para mostrar el saludo completo
$nombreCompleto = $usuarioNombre . ' ' . $usuarioApellido;

// Conectar a la base de datos
$conexion = new Conexion();
$pdo = $conexion->getConexion();

// Consulta para contar la cantidad de cada tipo de campo
$sqlCantidadCampos = "
    SELECT tipoDeporte, COUNT(*) AS cantidad 
    FROM campos 
    GROUP BY tipoDeporte
";
$stmtCantidadCampos = $pdo->query($sqlCantidadCampos);
$cantidadCampos = $stmtCantidadCampos->fetchAll(PDO::FETCH_ASSOC);

// Mapeo para obtener la cantidad de cada tipo
$mapaCantidadCampos = array_column($cantidadCampos, 'cantidad', 'tipoDeporte');

// Obtener datos para los gráficos y alquileres recientes
$sqlUsoInstalaciones = "
    SELECT tipoDeporte, SUM(horaReservar) AS horas_uso 
    FROM reservas r 
    JOIN campos c ON r.idcampo = c.idcampo 
    WHERE r.fechaInicio >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK) AND r.estado = 'confirmada' 
    GROUP BY c.tipoDeporte
";
$stmtUsoInstalaciones = $pdo->query($sqlUsoInstalaciones);
$usoInstalaciones = $stmtUsoInstalaciones->fetchAll(PDO::FETCH_ASSOC);

$sqlInstalacionesAlquiladas = "
    SELECT tipoDeporte, COUNT(*) AS cantidad 
    FROM reservas r 
    JOIN campos c ON r.idcampo = c.idcampo 
    WHERE r.estado = 'confirmada' 
    GROUP BY c.tipoDeporte
";
$stmtInstalacionesAlquiladas = $pdo->query($sqlInstalacionesAlquiladas);
$instalacionesAlquiladas = $stmtInstalacionesAlquiladas->fetchAll(PDO::FETCH_ASSOC);

$sqlAlquileresRecientes = "
    SELECT r.idreserva, CONCAT(p.nombre, ' ', p.apellido) AS cliente, c.tipoDeporte AS instalacion, 
           r.fechaInicio AS fecha, DATE_FORMAT(r.horaInicio, '%H:%i') AS hora, r.estado 
    FROM reservas r 
    JOIN personas p ON r.idpersona = p.idpersona 
    JOIN campos c ON r.idcampo = c.idcampo 
    ORDER BY r.fechaInicio DESC, r.horaInicio DESC 
    LIMIT 5
";
$stmtAlquileresRecientes = $pdo->query($sqlAlquileresRecientes);
$alquileresRecientes = $stmtAlquileresRecientes->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Panel de Alquiler de Instalaciones Deportivas</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active"></li>
    </ol>

    <!-- Bienvenida al usuario -->
    <div class="alert alert-info text-center" role="alert">
        ¡Bienvenido, <?= htmlspecialchars($nombreCompleto) ?>! Disfruta administrando las instalaciones deportivas.
    </div>

    <!-- Sección de categorías de instalaciones -->
    <div class="row mb-4">
        <!-- Campo de Fútbol -->
        <div class="col-lg-3">
            <div class="card text-white mb-4" style="background-image: url('../../img/Futbol.jpg'); background-size: cover; background-position: center; height: 300px;">
                <div class="card-body text-center d-flex flex-column justify-content-center">
                    <i class="fas fa-futbol fa-2x mb-2"></i>
                    <h5>Campos de Fútbol</h5>
                    <p class="display-6"><?= $mapaCantidadCampos['Fútbol'] ?? 0 ?></p>
                </div>
            </div>
        </div>

        <!-- Campo de Vóley -->
        <div class="col-lg-3">
            <div class="card text-white mb-4" style="background-image: url('../../img/boley.jpg'); background-size: cover; background-position: center; height: 300px;">
                <div class="card-body text-center d-flex flex-column justify-content-center">
                    <i class="fas fa-volleyball-ball fa-2x mb-2"></i>
                    <h5>Campos de Vóley</h5>
                    <p class="display-6"><?= $mapaCantidadCampos['Voleibol'] ?? 0 ?></p>
                </div>
            </div>
        </div>

        <!-- Campo de Baloncesto -->
        <div class="col-lg-3">
            <div class="card text-white mb-4" style="background-image: url('../../img/baloncesto.jpg'); background-size: cover; background-position: center; height: 300px;">
                <div class="card-body text-center d-flex flex-column justify-content-center">
                    <i class="fas fa-basketball-ball fa-2x mb-2"></i>
                    <h5>Campos de Baloncesto</h5>
                    <p class="display-6"><?= $mapaCantidadCampos['Baloncesto'] ?? 0 ?></p>
                </div>
            </div>
        </div>

        <!-- Piscinas -->
        <div class="col-lg-3">
            <div class="card text-white mb-4" style="background-image: url('../../img/natacion.jpg'); background-size: cover; background-position: center; height: 300px;">
                <div class="card-body text-center d-flex flex-column justify-content-center">
                    <i class="fas fa-swimmer fa-2x mb-2"></i>
                    <h5>Piscinas</h5>
                    <p class="display-6"><?= $mapaCantidadCampos['Piscina'] ?? 0 ?></p>
                </div>
            </div>
        </div>
    </div>

    <?php require_once 'footer.php'; ?>
</div>