<?php
// campo.controller.php

require_once '../models/Campo.php';
require_once '../models/Complejo.php';

class CampoController
{
    private $campoModel;

    public function __construct()
    {
        $this->campoModel = new Campo();
    }

    // Registrar un nuevo campo deportivo
    public function registrar()
    {
        $tipoDeporte = $_POST['tipoDeporte'] ?? null;
        $nombre = $_POST['nombre'] ?? null; // 'nombre' del formulario
        $capacidad = $_POST['capacidad'] ?? null;
        $precioHora = $_POST['precioHora'] ?? null;
        $idcomplejo = $_POST['idcomplejo'] ?? null;

        if ($tipoDeporte && $nombre && $capacidad && $precioHora && $idcomplejo) {
            $imagenCampo = null;
            if (isset($_FILES['imagenCampo']) && $_FILES['imagenCampo']['error'] == UPLOAD_ERR_OK) {
                $imagenCampo = $this->subirImagen($_FILES['imagenCampo']);
            }

            $result = $this->campoModel->registrarCampo($idcomplejo, $tipoDeporte, $nombre, $capacidad, $precioHora, $imagenCampo);
            if ($result === true) {
                echo json_encode(['mensaje' => 'Campo registrado correctamente']);
            } else {
                echo json_encode(['error' => $result['error'] ?? 'Error al registrar el campo']);
            }
        } else {
            echo json_encode(['error' => 'Datos incompletos']);
        }
    }

    // Actualizar un campo deportivo existente
    public function actualizar()
    {
        $idCampo = $_POST['idcampo'] ?? null;
        $tipoDeporte = $_POST['tipoDeporte'] ?? null;
        $nombre = $_POST['nombre'] ?? null; // 'nombre' del formulario
        $capacidad = $_POST['capacidad'] ?? null;
        $precioHora = $_POST['precioHora'] ?? null;
        $idcomplejo = $_POST['idcomplejo'] ?? null;
        $estado = $_POST['estado'] ?? null;

        if ($idCampo && $tipoDeporte && $nombre && $capacidad && $precioHora && $idcomplejo && $estado) {
            $imagenCampo = null;
            $imagenAnterior = $this->campoModel->obtenerImagenCampo($idCampo);

            if (isset($_FILES['imagenCampo']) && $_FILES['imagenCampo']['error'] == UPLOAD_ERR_OK) {
                $imagenCampo = $this->subirImagen($_FILES['imagenCampo']);

                // Eliminar la imagen anterior si existe
                if ($imagenAnterior) {
                    $rutaCompleta = '../uploads/' . $imagenAnterior;
                    if (file_exists($rutaCompleta)) {
                        unlink($rutaCompleta);
                    }
                }
            } else {
                // Si no se subió una nueva imagen, mantener la anterior
                $imagenCampo = $imagenAnterior;
            }

            $result = $this->campoModel->actualizarCampo($idCampo, $idcomplejo, $tipoDeporte, $nombre, $capacidad, $precioHora, $imagenCampo, $estado);
            if ($result === true) {
                echo json_encode(['mensaje' => 'Campo actualizado correctamente']);
            } else {
                echo json_encode(['error' => $result['error'] ?? 'Error al actualizar el campo']);
            }
        } else {
            echo json_encode(['error' => 'Datos incompletos']);
        }
    }

    // Subir una imagen para el campo
    private function subirImagen($file)
    {
        $directorio = '../uploads/';
        // Asegurarse de que el directorio existe
        if (!is_dir($directorio)) {
            mkdir($directorio, 0755, true);
        }
        $nombreArchivo = uniqid() . '-' . basename($file['name']);
        $rutaDestino = $directorio . $nombreArchivo;

        if (move_uploaded_file($file['tmp_name'], $rutaDestino)) {
            return $nombreArchivo;
        }
        return null;
    }

    // Listar campos de un complejo
    public function listar()
    {
        $idcomplejo = $_GET['idcomplejo'] ?? null;
        if ($idcomplejo) {
            $result = $this->campoModel->listarCamposPorComplejo($idcomplejo);
        } else {
            $result = $this->campoModel->listarCampos();
        }
        echo json_encode($result);
    }

    // Eliminar un campo deportivo
    public function eliminar()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $idCampo = $data['idcampo'] ?? null;

        if ($idCampo) {
            $imagenAnterior = $this->campoModel->obtenerImagenCampo($idCampo);
            $result = $this->campoModel->eliminarCampo($idCampo);

            // Eliminar la imagen del sistema de archivos
            if ($result === true && $imagenAnterior) {
                $rutaCompleta = '../uploads/' . $imagenAnterior;
                if (file_exists($rutaCompleta)) {
                    unlink($rutaCompleta);
                }
            }

            if ($result === true) {
                echo json_encode(['mensaje' => 'Campo eliminado correctamente']);
            } else {
                echo json_encode(['error' => $result['error'] ?? 'Error al eliminar el campo']);
            }
        } else {
            echo json_encode(['error' => 'ID de campo no proporcionado']);
        }
    }

    // Obtener un campo deportivo por su ID
    public function obtenerCampo($idCampo)
    {
        $result = $this->campoModel->obtenerCampoPorId($idCampo);
        if ($result && !isset($result['error'])) {
            echo json_encode($result);
        } else {
            echo json_encode(['error' => 'Campo no encontrado']);
        }
    }

    // Seleccionar tipos de deporte por complejo
    public function seleccionarTiposDeDeporte()
    {
        $idcomplejo = $_GET['idcomplejo'] ?? null;

        if ($idcomplejo) {
            $result = $this->campoModel->getTiposDeDeportePorComplejo($idcomplejo);
            echo json_encode($result);
        } else {
            echo json_encode(['error' => 'ID de complejo no proporcionado']);
        }
    }

    // Seleccionar campos por complejo y tipo de deporte
    public function seleccionarCampos()
    {
        $idcomplejo = $_GET['idcomplejo'] ?? null;
        $tipoDeporte = $_GET['tipoDeporte'] ?? null;

        if ($idcomplejo && $tipoDeporte) {
            $result = $this->campoModel->getCamposPorComplejoYDeporte($idcomplejo, $tipoDeporte);
            echo json_encode($result);
        } else {
            echo json_encode(['error' => 'Datos incompletos']);
        }
    }

    // Obtener datos de un campo específico
    public function obtenerDatosCampo()
    {
        $idcampo = $_GET['idcampo'] ?? null;

        if ($idcampo) {
            $result = $this->campoModel->obtenerCampoPorId($idcampo);
            if ($result && !isset($result['error'])) {
                // Obtener la dirección del complejo
                $complejoModel = new Complejo();
                $complejo = $complejoModel->obtenerComplejoPorId($result['idcomplejo']);
                $result['direccion'] = $complejo['direccion'] ?? '';
                echo json_encode($result);
            } else {
                echo json_encode(['error' => 'Campo no encontrado']);
            }
        } else {
            echo json_encode(['error' => 'ID de campo no proporcionado']);
        }
    }
}

// Manejo de rutas
header('Content-Type: application/json');
$controller = new CampoController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'actualizar') {
        $controller->actualizar();
    } else {
        $controller->registrar();
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['action'])) {
        if ($_GET['action'] === 'seleccionar_tipos_deporte') {
            $controller->seleccionarTiposDeDeporte();
        } elseif ($_GET['action'] === 'seleccionar_campos') {
            $controller->seleccionarCampos();
        } elseif ($_GET['action'] === 'obtener_datos_campo') {
            $controller->obtenerDatosCampo();
        } else {
            echo json_encode(['error' => 'Acción no válida']);
        }
    } elseif (isset($_GET['idcampo'])) {
        $controller->obtenerCampo($_GET['idcampo']);
    } else {
        $controller->listar();
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $controller->eliminar();
} else {
    echo json_encode(['error' => 'Método no permitido']);
}
?>
