<?php require_once '../../header.administrador.php'; ?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Configuración del Sistema</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Configuración</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="m-0">Opciones de Configuración</h5>
        </div>
        <div class="card-body">
            <form id="form-configuracion" method="POST" action="../../controllers/configuracion.controller.php">
                <div class="mb-3">
                    <label for="max_reservas" class="form-label">Número Máximo de Reservas por Usuario</label>
                    <input type="number" class="form-control" id="max_reservas" name="max_reservas" required>
                </div>

                <div class="mb-3">
                    <label for="horarios_disponibles" class="form-label">Horarios Disponibles</label>
                    <textarea class="form-control" id="horarios_disponibles" name="horarios_disponibles" rows="3" required></textarea>
                    <small class="form-text">Ejemplo: 8AM - 10PM, 10PM - 12AM</small>
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-success">Guardar Configuración</button>
                    <a href="index.php" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once '../../footer.php'; ?>
