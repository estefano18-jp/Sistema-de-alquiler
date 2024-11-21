<?php

require_once '../models/Servicio.php';

class ServicioController {
    private $servicioModel;

    public function __construct() {
        $this->servicioModel = new Servicio();
    }

    public function registrar() {
        // Asumiendo que el contenido del POST se envía en JSON
        $data = json_decode(file_get_contents('php://input'), true);
    
        $nombre = $data['nombre'] ?? null;
        $costo = $data['costo'] ?? null;
    
        if ($nombre && $costo) {
            $result = $this->servicioModel->registrarServicio($nombre, $costo);
            if ($result) {
                echo json_encode(['mensaje' => 'Servicio registrado correctamente']);
            } else {
                echo json_encode(['error' => 'Error al registrar el servicio']);
            }
        } else {
            echo json_encode(['error' => 'Datos incompletos']);
        }
    }    

    public function listar() {
        $result = $this->servicioModel->listarServicios();
        echo json_encode($result);
    }

    public function eliminar() {
        $data = json_decode(file_get_contents('php://input'), true);
        $idservicio = $data['idservicio'] ?? null;
    
        if ($idservicio) {
            $result = $this->servicioModel->eliminarServicio($idservicio);
            if ($result) {
                echo json_encode(['mensaje' => 'Servicio eliminado correctamente']);
            } else {
                echo json_encode(['error' => 'Error al eliminar el servicio']);
            }
        } else {
            echo json_encode(['error' => 'ID de servicio no proporcionado']);
        }
    }
    public function actualizar() {
        $data = json_decode(file_get_contents('php://input'), true);
        
        $idservicio = $data['idservicio'] ?? null;
        $nombre = $data['nombre'] ?? null;
        $costo = $data['costo'] ?? null;
        $estado = $data['estado'] ?? null;
    
        if ($idservicio && $nombre && $costo && $estado) {
            $result = $this->servicioModel->actualizarServicio($idservicio, $nombre, $costo, $estado);
            if ($result) {
                echo json_encode(['mensaje' => 'Servicio actualizado correctamente']);
            } else {
                echo json_encode(['error' => 'Error al actualizar el servicio']);
            }
        } else {
            echo json_encode(['error' => 'Datos incompletos']);
        }
    }
    // Método para mostrar los servicios activos
    public function mostrarServicios() {
        $result = $this->servicioModel->mostrarServiciosActivos();
        echo json_encode($result);
    }
    // Método para mostrar los detalles de un servicio específico
    public function mostrarDetallesServicio() {
        // Obtener el nombre del servicio desde la URL
        if (isset($_GET['nombre_servicio'])) {
            $nombre_servicio = $_GET['nombre_servicio'];
            $result = $this->servicioModel->mostrarDetallesServicio($nombre_servicio);
            echo json_encode($result);
        } else {
            echo json_encode(['error' => 'Nombre del servicio no proporcionado']);
        }
    }
}

// Manejo de rutas
header('Content-Type: application/json');
$controller = new ServicioController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->registrar();
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['action']) && $_GET['action'] === 'mostrarDetallesServicio') {
        $controller->mostrarDetallesServicio();
    } elseif (isset($_GET['action']) && $_GET['action'] === 'mostrarServicios') {
        $controller->mostrarServicios();
    } else {
        $controller->listar();
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $controller->actualizar();
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $controller->eliminar();
} else {
    echo json_encode(['error' => 'Método no permitido']);
}
?>
