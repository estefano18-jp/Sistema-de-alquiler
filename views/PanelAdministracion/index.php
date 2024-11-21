<?php require_once '../../header.administrador.php'; ?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Panel de Administración - Alquiler de Campos Deportivos</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Inicio</li>
    </ol>
    
    <div class="row">
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card shadow border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="m-0">Resumen de Campos</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">Visualiza todos los campos deportivos disponibles y su estado actual.</p>
                    <a href="ver_campos.php" class="btn btn-primary">Ver Campos</a>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card shadow border-0">
                <div class="card-header bg-success text-white">
                    <h5 class="m-0">Gestionar Reservas</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">Administra las reservas de campos y visualiza los detalles de cada una.</p>
                    <a href="listar_reservas.php" class="btn btn-success">Ver Reservas</a>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card shadow border-0">
                <div class="card-header bg-warning text-white">
                    <h5 class="m-0">Agregar Campo</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">Incluir nuevos campos deportivos al sistema.</p>
                    <a href="agregar_campo.php" class="btn btn-warning">Agregar Campo</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card shadow border-0">
                <div class="card-header bg-info text-white">
                    <h5 class="m-0">Reportes</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">Genera reportes sobre el uso de los campos y las reservas realizadas.</p>
                    <a href="reportes.php" class="btn btn-info">Ver Reportes</a>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card shadow border-0">
                <div class="card-header bg-secondary text-white">
                    <h5 class="m-0">Configuración</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">Configura las opciones del sistema según sea necesario.</p>
                    <a href="configuracion.php" class="btn btn-secondary">Configuración</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once '../../footer.php'; ?>
