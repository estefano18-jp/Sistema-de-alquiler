<?php
// complejo.controller.php

require_once '../models/Complejo.php';

class ComplejoController
{
    private $complejoModel;

    public function __construct()
    {
        $this->complejoModel = new Complejo();
    }

    // Registrar un nuevo complejo deportivo
    public function registrar()
    {
        $nombreComplejo = $_POST['nombreComplejo'] ?? null;
        $direccion = $_POST['direccion'] ?? null;
        $descripcion = isset($_POST['descripcion']) && trim($_POST['descripcion']) !== '' ? trim($_POST['descripcion']) : '';

        if ($nombreComplejo && $direccion) {
            $result = $this->complejoModel->registrarComplejo($nombreComplejo, $direccion, $descripcion);
            if ($result === true) {
                echo json_encode(['mensaje' => 'Complejo registrado correctamente']);
            } else {
                echo json_encode(['error' => $result['error'] ?? 'Error al registrar el complejo']);
            }
        } else {
            echo json_encode(['error' => 'Datos incompletos']);
        }
    }

    // Actualizar un complejo deportivo existente
    public function actualizar()
    {
        $idcomplejo = $_POST['idcomplejo'] ?? null;
        $nombreComplejo = $_POST['nombreComplejo'] ?? null;
        $direccion = $_POST['direccion'] ?? null;
        $descripcion = isset($_POST['descripcion']) && trim($_POST['descripcion']) !== '' ? trim($_POST['descripcion']) : '';

        if ($idcomplejo && $nombreComplejo && $direccion) {
            $result = $this->complejoModel->actualizarComplejo($idcomplejo, $nombreComplejo, $direccion, $descripcion);
            if ($result === true) {
                echo json_encode(['mensaje' => 'Complejo actualizado correctamente']);
            } else {
                echo json_encode(['error' => $result['error'] ?? 'Error al actualizar el complejo']);
            }
        } else {
            echo json_encode(['error' => 'Datos incompletos']);
        }
    }

    // Eliminar un complejo deportivo
    public function eliminar()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $idcomplejo = $data['idcomplejo'] ?? null;

        if ($idcomplejo) {
            $result = $this->complejoModel->eliminarComplejo($idcomplejo);
            if ($result === true) {
                echo json_encode(['mensaje' => 'Complejo eliminado correctamente']);
            } else {
                echo json_encode(['error' => $result['error'] ?? 'Error al eliminar el complejo']);
            }
        } else {
            echo json_encode(['error' => 'ID de complejo no proporcionado']);
        }
    }

    // Listar todos los complejos deportivos
    public function listar()
    {
        $result = $this->complejoModel->listarComplejos();
        echo json_encode($result);
    }

    // Obtener un complejo deportivo por su ID
    public function obtenerComplejo($idcomplejo)
    {
        $result = $this->complejoModel->obtenerComplejoPorId($idcomplejo);
        if ($result && !isset($result['error'])) {
            // Asegurar que la descripción no sea null
            if ($result['descripcion'] === null) {
                $result['descripcion'] = '';
            }
            echo json_encode($result);
        } else {
            echo json_encode(['error' => 'Complejo no encontrado']);
        }
    }

    // Seleccionar complejos (simplemente listarlos)
    public function seleccionar()
    {
        $this->listar();
    }
}

// Manejo de rutas
header('Content-Type: application/json');
$controller = new ComplejoController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'actualizar') {
        $controller->actualizar();
    } else {
        $controller->registrar();
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['action']) && $_GET['action'] === 'seleccionar') {
        $controller->seleccionar();
    } elseif (isset($_GET['idcomplejo'])) {
        $controller->obtenerComplejo($_GET['idcomplejo']);
    } else {
        $controller->listar();
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $controller->eliminar();
} else {
    echo json_encode(['error' => 'Método no permitido']);
}
?>
