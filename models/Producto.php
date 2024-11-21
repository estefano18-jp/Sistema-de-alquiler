<?php

require_once 'conexion.php';

class Producto
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = (new Conexion())->getConexion();
    }

    public function registrarProducto($nombre, $precio, $cantidad, $imagenProducto)
    {
        try {
            $stmt = $this->conexion->prepare("CALL registrar_Producto(:nombre, :precio, :cantidad, :imagenProducto)");
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':precio', $precio);
            $stmt->bindParam(':cantidad', $cantidad);
            if ($imagenProducto) {
                $stmt->bindParam(':imagenProducto', $imagenProducto);
            } else {
                $imagenProducto = null;
                $stmt->bindParam(':imagenProducto', $imagenProducto, PDO::PARAM_NULL);
            }
            return $stmt->execute();
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function actualizarProducto($idproducto, $nombre, $precio, $cantidad, $imagenProducto, $estado)
    {
        try {
            $stmt = $this->conexion->prepare("CALL actualizar_Producto(:idproducto, :nombre, :precio, :cantidad, :imagenProducto, :estado)");
            $stmt->bindParam(':idproducto', $idproducto);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':precio', $precio);
            $stmt->bindParam(':cantidad', $cantidad);
            if ($imagenProducto) {
                $stmt->bindParam(':imagenProducto', $imagenProducto);
            } else {
                $imagenProducto = null;
                $stmt->bindParam(':imagenProducto', $imagenProducto, PDO::PARAM_NULL);
            }
            $stmt->bindParam(':estado', $estado);
            return $stmt->execute();
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function listarProductos()
    {
        try {
            $stmt = $this->conexion->prepare("CALL listar_Producto()");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function eliminarProducto($idProducto)
    {
        try {
            // Llamar al procedimiento almacenado
            $stmt = $this->conexion->prepare("CALL eliminar_Producto(:idproducto)");
            $stmt->bindParam(':idproducto', $idProducto);
            $stmt->execute();

            return true;
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function obtenerImagenProducto($idProducto)
    {
        try {
            $stmt = $this->conexion->prepare("SELECT imagenProducto FROM productos WHERE idproducto = :idproducto");
            $stmt->bindParam(':idproducto', $idProducto);
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (Exception $e) {
            return null;
        }
    }

    public function obtenerProductoPorId($idProducto)
    {
        try {
            $stmt = $this->conexion->prepare("SELECT * FROM productos WHERE idproducto = :idproducto");
            $stmt->bindParam(':idproducto', $idProducto);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
    // Procedimiento para mostrar los nombres y cantidades de los productos activos
    public function mostrarNombresProductos()
    {
        try {
            // Llamamos al procedimiento almacenado
            $stmt = $this->conexion->prepare("CALL mostrar_nombres_y_stock_productos()");
            $stmt->execute();
            // Retornamos todos los resultados en un formato asociativo
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
    // Método para obtener los detalles del producto desde la base de datos
    public function mostrarDetallesProductos($nombreProducto, $cantidadDeseada)
    {
        try {
            // Llamar al procedimiento almacenado
            $stmt = $this->conexion->prepare("CALL mostrar_detalles_productos(:nombre_producto, :cantidad_deseada)");
            $stmt->bindParam(':nombre_producto', $nombreProducto);
            $stmt->bindParam(':cantidad_deseada', $cantidadDeseada);
            $stmt->execute();

            // Obtener el resultado de la consulta
            return $stmt->fetch(PDO::FETCH_ASSOC); // Retorna solo los datos del producto
        } catch (Exception $e) {
            // Manejar excepciones y errores en la base de datos
            return ['error' => 'Error en la base de datos: ' . $e->getMessage()];
        }
    }
}
