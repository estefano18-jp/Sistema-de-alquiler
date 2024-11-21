<?php
// models/Complejo.php

require_once 'conexion.php';

class Complejo
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = (new Conexion())->getConexion();
    }

    // Registrar un nuevo complejo deportivo
    public function registrarComplejo($nombreComplejo, $direccion, $descripcion)
    {
        try {
            $stmt = $this->conexion->prepare("CALL registrar_Complejo(:nombreComplejo, :direccion, :descripcion)");
            $stmt->bindParam(':nombreComplejo', $nombreComplejo);
            $stmt->bindParam(':direccion', $direccion);
            $stmt->bindParam(':descripcion', $descripcion);
            return $stmt->execute();
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    // Actualizar un complejo deportivo existente
    public function actualizarComplejo($idcomplejo, $nombreComplejo, $direccion, $descripcion)
    {
        try {
            $stmt = $this->conexion->prepare("CALL actualizar_Complejo(:idcomplejo, :nombreComplejo, :direccion, :descripcion)");
            $stmt->bindParam(':idcomplejo', $idcomplejo, PDO::PARAM_INT);
            $stmt->bindParam(':nombreComplejo', $nombreComplejo);
            $stmt->bindParam(':direccion', $direccion);
            $stmt->bindParam(':descripcion', $descripcion);
            return $stmt->execute();
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    // Eliminar un complejo deportivo
    public function eliminarComplejo($idcomplejo)
    {
        try {
            $stmt = $this->conexion->prepare("CALL eliminar_Complejo(:idcomplejo)");
            $stmt->bindParam(':idcomplejo', $idcomplejo, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    // Listar todos los complejos deportivos
    public function listarComplejos()
    {
        try {
            $stmt = $this->conexion->prepare("CALL listar_Complejo()");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    // Obtener un complejo deportivo por su ID
    public function obtenerComplejoPorId($idcomplejo)
    {
        try {
            $stmt = $this->conexion->prepare("CALL ver_Complejo(:idcomplejo)");
            $stmt->bindParam(':idcomplejo', $idcomplejo, PDO::PARAM_INT);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($resultado && $resultado['descripcion'] === null) {
                $resultado['descripcion'] = '';
            }
            return $resultado;
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
    
}
?>
