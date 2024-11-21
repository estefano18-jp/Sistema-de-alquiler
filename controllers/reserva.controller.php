<?php

require_once '../models/Reserva.php';

class ReservaController
{
    private $reservaModel;

    public function __construct()
    {
        $this->reservaModel = new Reserva();
    }

    public function registrar()
    {
        // Obtener los datos del POST en formato JSON
        $data = json_decode(file_get_contents('php://input'), true);

        // Validar los datos necesarios
        $idpersona = $data['idpersona'] ?? null;
        $idcampo = $data['idcampo'] ?? null;
        $fechaInicio = $data['fechaInicio'] ?? null;
        $horaInicio = $data['horaInicio'] ?? null;
        $horaReservar = $data['horaReservar'] ?? null;
        $productos = $data['productos'] ?? [];
        $servicios = $data['servicios'] ?? [];

        if ($idpersona && $idcampo && $fechaInicio && $horaInicio && $horaReservar) {
            $reservaData = [
                'idpersona' => $idpersona,
                'idcampo' => $idcampo,
                'fechaInicio' => $fechaInicio,
                'horaInicio' => $horaInicio,
                'horaReservar' => $horaReservar,
                'productos' => $productos,
                'servicios' => $servicios,
            ];

            $result = $this->reservaModel->registrarReserva($reservaData);

            if (isset($result['error'])) {
                echo json_encode(['error' => $result['error']]);
            } else {
                echo json_encode(['mensaje' => 'Reserva registrada correctamente']);
            }
        } else {
            echo json_encode(['error' => 'Datos incompletos']);
        }
    }

    public function listar()
    {
        $result = $this->reservaModel->listarReservas();
        echo json_encode($result);
    }

    public function eliminar()
    {
        // Obtener el idreserva desde GET
        if (isset($_GET['idreserva'])) {
            $idreserva = intval($_GET['idreserva']);

            $result = $this->reservaModel->eliminarReserva($idreserva);

            if (isset($result['mensaje'])) {
                echo json_encode(['mensaje' => $result['mensaje']]);
            } else {
                echo json_encode(['error' => $result['error']]);
            }
        } else {
            echo json_encode(['error' => 'No se proporcionó el idreserva']);
        }
    }

    public function obtenerHorasOcupadas()
    {
        $idcampo = $_GET['idcampo'] ?? null;
        $fecha = $_GET['fecha'] ?? null;

        if ($idcampo && $fecha) {
            $result = $this->reservaModel->obtenerHorasOcupadas($idcampo, $fecha);
            echo json_encode($result);
        } else {
            echo json_encode(['error' => 'Datos incompletos']);
        }
    }
    public function listarPorPersona($idpersona)
    {
        $result = $this->reservaModel->listarReservasPorPersona($idpersona);
        echo json_encode($result);
    }
    public function detalleReserva($idreserva)
    {
        $result = $this->reservaModel->obtenerDetalleReserva($idreserva);
        echo json_encode($result);
    }

}

// Manejo de rutas
header('Content-Type: application/json');
$controller = new ReservaController();

// Determinar la acción
$action = $_GET['action'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'registrar_reserva') {
    $controller->registrar();
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && $action === 'listar_reserva') {
    $controller->listar();
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && $action === 'listar_reserva_por_persona') {
    $idpersona = $_GET['idpersona'] ?? null;
    if ($idpersona) {
        $controller->listarPorPersona($idpersona);
    } else {
        echo json_encode(['error' => 'ID de persona no proporcionado']);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && $action === 'detalle_reserva') {
    $idreserva = $_GET['idreserva'] ?? null;
    if ($idreserva) {
        $controller->detalleReserva($idreserva);
    } else {
        echo json_encode(['error' => 'ID de reserva no proporcionado']);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && $action === 'obtener_horas_ocupadas') {
    $controller->obtenerHorasOcupadas();
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE' && $action === 'eliminar_reserva') {
    $controller->eliminar();
} else {
    echo json_encode(['error' => 'Acción no válida']);
}