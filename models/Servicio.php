<?php

require_once 'conexion.php';

class Servicio {
    private $conexion;

    public function __construct() {
        $this->conexion = (new Conexion())->getConexion();
    }

    public function registrarServicio($nombre, $costo) {
        try {
            $stmt = $this->conexion->prepare("CALL registrar_servicio(:nombre, :costo)");
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':costo', $costo);
            return $stmt->execute();
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function listarServicios() {
        try {
            $stmt = $this->conexion->prepare("CALL listar_servicios()");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
    public function eliminarServicio($idservicio) {
        try {
            $stmt = $this->conexion->prepare("CALL eliminar_servicio(:idservicio)");
            $stmt->bindParam(':idservicio', $idservicio);
            return $stmt->execute();
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function actualizarServicio($idservicio, $nombre, $costo, $estado) {
        try {
            $stmt = $this->conexion->prepare("CALL actualizar_servicio(:idservicio, :nombre, :costo, :estado)");
            $stmt->bindParam(':idservicio', $idservicio);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':costo', $costo);
            $stmt->bindParam(':estado', $estado);
            return $stmt->execute();
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
    // Método para ejecutar el procedimiento "mostrar_servicios"
    public function mostrarServiciosActivos() {
        try {
            $stmt = $this->conexion->prepare("CALL mostrar_servicios()");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
    // Nuevo método para ejecutar el procedimiento "mostrar_detalles_servicios"
    public function mostrarDetallesServicio($nombre_servicio) {
        try {
            $stmt = $this->conexion->prepare("CALL mostrar_detalles_servicios(:nombre_servicio)");
            $stmt->bindParam(':nombre_servicio', $nombre_servicio);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
?>
