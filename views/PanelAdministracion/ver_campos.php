<?php require_once '../../header.administrador.php'; ?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Listado de Campos Deportivos</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Ver Campos</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="m-0">Campos Disponibles</h5>
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered" id="tabla-campos">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre del Campo</th>
                        <th>Tipo de Campo</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Simulando la obtención de datos de una base de datos
                    // Aquí debes implementar la conexión y la consulta a tu base de datos
                    $campos = [
                        ['id' => 1, 'nombre' => 'Campo de Fútbol 1', 'tipo' => 'Fútbol', 'estado' => 'Disponible'],
                        ['id' => 2, 'nombre' => 'Campo de Baloncesto 1', 'tipo' => 'Baloncesto', 'estado' => 'Reservado'],
                        ['id' => 3, 'nombre' => 'Campo de Voleibol 1', 'tipo' => 'Voleibol', 'estado' => 'Disponible'],
                        ['id' => 4, 'nombre' => 'Campo de Fútbol 2', 'tipo' => 'Fútbol', 'estado' => 'Mantenimiento'],
                    ];

                    foreach ($campos as $campo) {
                        echo "<tr>
                            <td>{$campo['id']}</td>
                            <td>{$campo['nombre']}</td>
                            <td>{$campo['tipo']}</td>
                            <td>{$campo['estado']}</td>
                            <td>
                                <a href='editar_campo.php?id={$campo['id']}' class='btn btn-warning btn-sm'>Editar</a>
                                <a href='eliminar_campo.php?id={$campo['id']}' class='btn btn-danger btn-sm'>Eliminar</a>
                            </td>
                        </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once '../../footer.php'; ?>
