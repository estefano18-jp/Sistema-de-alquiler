<?php require_once '../../header.administrador.php'; ?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Listado de Reservas de Campos Deportivos</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Ver Reservas</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="m-0">Reservas Actuales</h5>
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered" id="tabla-reservas">
                <thead>
                    <tr>
                        <th>ID Reserva</th>
                        <th>ID Usuario</th>
                        <th>Nombre del Usuario</th>
                        <th>Campo Reservado</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Simulando la obtención de datos de una base de datos
                    // Aquí debes implementar la conexión y la consulta a tu base de datos
                    $reservas = [
                        ['id_reserva' => 1, 'id_usuario' => 101, 'nombre' => 'Juan Pérez', 'campo' => 'Campo de Fútbol 1', 'fecha' => '2024-10-14', 'hora' => '10:00 AM', 'estado' => 'Confirmada'],
                        ['id_reserva' => 2, 'id_usuario' => 102, 'nombre' => 'María Gómez', 'campo' => 'Campo de Baloncesto 1', 'fecha' => '2024-10-14', 'hora' => '11:00 AM', 'estado' => 'Cancelada'],
                        ['id_reserva' => 3, 'id_usuario' => 103, 'nombre' => 'Carlos Ruiz', 'campo' => 'Campo de Voleibol 1', 'fecha' => '2024-10-14', 'hora' => '12:00 PM', 'estado' => 'Pendiente'],
                        ['id_reserva' => 4, 'id_usuario' => 104, 'nombre' => 'Ana Torres', 'campo' => 'Campo de Fútbol 2', 'fecha' => '2024-10-15', 'hora' => '09:00 AM', 'estado' => 'Confirmada'],
                    ];

                    foreach ($reservas as $reserva) {
                        echo "<tr>
                            <td>{$reserva['id_reserva']}</td>
                            <td>{$reserva['id_usuario']}</td>
                            <td>{$reserva['nombre']}</td>
                            <td>{$reserva['campo']}</td>
                            <td>{$reserva['fecha']}</td>
                            <td>{$reserva['hora']}</td>
                            <td>{$reserva['estado']}</td>
                            <td>
                                <a href='editar_reserva.php?id_reserva={$reserva['id_reserva']}' class='btn btn-warning btn-sm'>Editar</a>
                                <a href='eliminar_reserva.php?id_reserva={$reserva['id_reserva']}' class='btn btn-danger btn-sm'>Eliminar</a>
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
