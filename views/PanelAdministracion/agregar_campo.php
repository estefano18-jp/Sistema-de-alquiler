<?php require_once '../../header.administrador.php'; ?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Agregar Nuevo Campo Deportivo</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Agregar Campo</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="m-0">Completa la Información del Campo</h5>
        </div>
        <div class="card-body">
            <form id="form-agregar-campo" method="POST" action="../../controllers/campo.controller.php">
                <div class="row g-2">
                    <div class="col-md mb-2">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                            <label for="nombre">Nombre del Campo</label>
                        </div>
                    </div>

                    <div class="col-md mb-2">
                        <div class="form-floating">
                            <select name="tipo" id="tipo" class="form-select" required>
                                <option value="">Seleccione un Tipo</option>
                                <option value="Fútbol">Fútbol</option>
                                <option value="Baloncesto">Baloncesto</option>
                                <option value="Voleibol">Voleibol</option>
                                <option value="Tenis">Tenis</option>
                                <!-- Agrega más tipos según sea necesario -->
                            </select>
                            <label for="tipo">Tipo de Campo</label>
                        </div>
                    </div>

                    <div class="col-md mb-2">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="ubicacion" name="ubicacion" required>
                            <label for="ubicacion">Ubicación</label>
                        </div>
                    </div>
                </div>

                <div class="row g-2">
                    <div class="col-md mb-2">
                        <div class="form-floating">
                            <input type="number" class="form-control" id="capacidad" name="capacidad" min="1" required>
                            <label for="capacidad">Capacidad (Número de Jugadores)</label>
                        </div>
                    </div>

                    <div class="col-md mb-2">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="disponibilidad" name="disponibilidad" required>
                            <label for="disponibilidad">Disponibilidad (ej. 8AM - 10PM)</label>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-success">Agregar Campo</button>
                    <a href="listar_campos.php" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once '../../footer.php'; ?>
