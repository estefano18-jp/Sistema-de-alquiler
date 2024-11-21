<?php require_once '../../header.administrador.php'; ?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Reportes de Uso de Campos Deportivos</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Reportes</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="m-0">Generar Reportes</h5>
        </div>
        <div class="card-body">
            <form id="form-reportes" method="POST" action="../../controllers/reportes.controller.php">
                <div class="row g-2">
                    <div class="col-md mb-2">
                        <div class="form-floating">
                            <select name="tipo_reporte" id="tipo_reporte" class="form-select" required>
                                <option value="">Seleccione un Tipo de Reporte</option>
                                <option value="uso_campo">Uso de Campos</option>
                                <option value="reservas">Reservas Realizadas</option>
                                <option value="usuarios">Usuarios Registrados</option>
                            </select>
                            <label for="tipo_reporte">Tipo de Reporte</label>
                        </div>
                    </div>

                    <div class="col-md mb-2">
                        <div class="form-floating">
                            <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
                            <label for="fecha_inicio">Fecha de Inicio</label>
                        </div>
                    </div>

                    <div class="col-md mb-2">
                        <div class="form-floating">
                            <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" required>
                            <label for="fecha_fin">Fecha de Fin</label>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Generar Reporte</button>
                    <a href="index.php" class="btn btn-secondary">Volver</a>
                </div>
            </form>
        </div>
    </div>

    <div class="mt-4">
        <h5>Reportes Generados</h5>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tipo de Reporte</th>
                    <th>Fecha Generación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Aquí se llenarán los reportes generados -->
            </tbody>
        </table>
    </div>
</div>

<?php require_once '../../footer.php'; ?>
