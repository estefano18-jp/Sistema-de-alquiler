<?php

require_once '../models/Producto.php';

class ProductoController
{
    private $productoModel;

    public function __construct()
    {
        $this->productoModel = new Producto();
    }

    public function registrar()
    {
        $nombre = $_POST['nombre'] ?? null;
        $precio = $_POST['precio'] ?? null;
        $cantidad = $_POST['cantidad'] ?? null;
        $imagenProducto = null;

        if ($nombre && $precio && $cantidad) {
            if (isset($_FILES['imagenProducto']) && $_FILES['imagenProducto']['error'] == UPLOAD_ERR_OK) {
                $imagenProducto = $this->subirImagen($_FILES['imagenProducto']);
            }

            $result = $this->productoModel->registrarProducto($nombre, $precio, $cantidad, $imagenProducto);
            if ($result) {
                echo json_encode(['mensaje' => 'Producto registrado correctamente']);
            } else {
                echo json_encode(['error' => 'Error al registrar el producto']);
            }
        } else {
            echo json_encode(['error' => 'Datos incompletos']);
        }
    }


    public function actualizar()
    {
        $idProducto = $_POST['idproducto'] ?? null;
        $nombre = $_POST['nombre'] ?? null;
        $precio = $_POST['precio'] ?? null;
        $cantidad = $_POST['cantidad'] ?? null;
        $estado = $_POST['estado'] ?? null;

        $imagenProducto = null;
        $imagenAnterior = null;

        if ($idProducto) {
            // Obtener la imagen anterior para eliminarla
            $imagenAnterior = $this->productoModel->obtenerImagenProducto($idProducto);
        }

        if (isset($_FILES['imagenProducto']) && $_FILES['imagenProducto']['error'] == UPLOAD_ERR_OK) {
            $imagenProducto = $this->subirImagen($_FILES['imagenProducto']);

            // Eliminar la imagen anterior si existe
            if ($imagenAnterior) {
                $rutaCompleta = '../uploads/' . $imagenAnterior;
                if (file_exists($rutaCompleta)) {
                    unlink($rutaCompleta);
                }
            }
        } else {
            // Si no se subió una nueva imagen, mantener la anterior
            $imagenProducto = $imagenAnterior;
        }

        if ($idProducto && $nombre && $precio && $cantidad && $estado) {
            $result = $this->productoModel->actualizarProducto($idProducto, $nombre, $precio, $cantidad, $imagenProducto, $estado);
            if ($result) {
                echo json_encode(['mensaje' => 'Producto actualizado correctamente']);
            } else {
                echo json_encode(['error' => 'Error al actualizar el producto']);
            }
        } else {
            echo json_encode(['error' => 'Datos incompletos']);
        }
    }

    private function subirImagen($file)
    {
        $directorio = '../uploads/';
        $nombreArchivo = uniqid() . '-' . basename($file['name']);
        $rutaDestino = $directorio . $nombreArchivo;

        if (move_uploaded_file($file['tmp_name'], $rutaDestino)) {
            return $nombreArchivo;
        }
        return null;
    }

    public function listar()
    {
        $result = $this->productoModel->listarProductos();
        echo json_encode($result);
    }

    public function eliminar()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $idProducto = $data['idproducto'] ?? null;

        if ($idProducto) {
            $imagenAnterior = $this->productoModel->obtenerImagenProducto($idProducto);
            $result = $this->productoModel->eliminarProducto($idProducto);

            // Eliminar la imagen del sistema de archivos
            if ($result && $imagenAnterior) {
                $rutaCompleta = '../uploads/' . $imagenAnterior;
                if (file_exists($rutaCompleta)) {
                    unlink($rutaCompleta);
                }
            }

            if ($result) {
                echo json_encode(['mensaje' => 'Producto eliminado correctamente']);
            } else {
                echo json_encode(['error' => 'Error al eliminar el producto']);
            }
        } else {
            echo json_encode(['error' => 'ID de producto no proporcionado']);
        }
    }

    public function obtenerProducto($idProducto)
    {
        $result = $this->productoModel->obtenerProductoPorId($idProducto);
        echo json_encode($result);
    }
    
    // Mostrar los nombres y cantidades de los productos activos
    public function mostrarNombresProductos()
    {
        // Llamamos al método del modelo que obtiene los productos
        $result = $this->productoModel->mostrarNombresProductos();
        // Devolvemos el resultado en formato JSON
        echo json_encode($result);
    }

    // Método para mostrar los detalles del producto
    public function mostrarDetallesProducto()
    {
        // Recibimos los parámetros desde la solicitud GET
        $nombreProducto = $_GET['nombre_producto'] ?? null;
        $cantidadDeseada = $_GET['cantidad_deseada'] ?? null;

        // Validamos que ambos parámetros estén presentes
        if ($nombreProducto && $cantidadDeseada) {
            // Llamamos al modelo para obtener los detalles del producto
            $producto = $this->productoModel->mostrarDetallesProductos($nombreProducto, $cantidadDeseada);

            // Verificar si el producto existe
            if (isset($producto['error'])) {
                // Si hubo un error en la base de datos o no se encontró el producto
                echo json_encode(['error' => $producto['error']]);
                return;
            }

            // Verificar si el producto existe y si hay suficiente stock
            if (!$producto) {
                echo json_encode(['error' => 'Producto no encontrado o no disponible']);
                return;
            }

            // Verificar si hay suficiente cantidad en stock
            if ($producto['cantidad'] < $cantidadDeseada) {
                echo json_encode(['error' => 'Cantidad solicitada excede el stock disponible']);
                return;
            }

            // Calcular el total
            $total = $producto['precio'] * $cantidadDeseada;

            // Retornar los detalles del producto con el total calculado
            echo json_encode([
                'nombre' => $nombreProducto,
                'cantidad' => $cantidadDeseada,
                'precio' => $producto['precio'],
                'total' => $total
            ]);
        } else {
            // En caso de parámetros faltantes, retornamos un error específico
            echo json_encode(['error' => 'Parametros incompletos']);
        }
    }
}

// Manejo de rutas
header('Content-Type: application/json');
$controller = new ProductoController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'actualizar') {
        $controller->actualizar();
    } else {
        $controller->registrar();
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['action'])) {
        if ($_GET['action'] === 'mostrarDetallesProducto') {
            $controller->mostrarDetallesProducto();
        } elseif ($_GET['action'] === 'mostrarNombresProductos') {
            $controller->mostrarNombresProductos();
        }
    } else if (isset($_GET['idproducto'])) {
        $controller->obtenerProducto($_GET['idproducto']);
    } else {
        $controller->listar();
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $controller->eliminar();
} else {
    echo json_encode(['error' => 'Método no permitido']);
}
