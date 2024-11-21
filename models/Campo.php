<?php
// models/Campo.php

require_once 'conexion.php';

class Campo
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = (new Conexion())->getConexion();
    }

    // Registrar un nuevo campo deportivo
    public function registrarCampo($idcomplejo, $tipoDeporte, $nombre, $capacidad, $precioHora, $imagenCampo)
    {
        try {
            $stmt = $this->conexion->prepare("CALL registrar_Campo(:idcomplejo, :tipoDeporte, :nombreCampo, :capacidad, :precioHora, :imagenCampo)");
            $stmt->bindParam(':idcomplejo', $idcomplejo, PDO::PARAM_INT);
            $stmt->bindParam(':tipoDeporte', $tipoDeporte);
            $stmt->bindParam(':nombreCampo', $nombre); // Asegurarse de que 'nombreCampo' se mapea correctamente
            $stmt->bindParam(':capacidad', $capacidad, PDO::PARAM_INT);
            $stmt->bindParam(':precioHora', $precioHora);
            if ($imagenCampo) {
                $stmt->bindParam(':imagenCampo', $imagenCampo);
            } else {
                $stmt->bindParam(':imagenCampo', $imagenCampo, PDO::PARAM_NULL);
            }
            return $stmt->execute();
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    // Actualizar un campo deportivo existente
    public function actualizarCampo($idcampo, $idcomplejo, $tipoDeporte, $nombre, $capacidad, $precioHora, $imagenCampo, $estado)
    {
        try {
            $stmt = $this->conexion->prepare("CALL actualizar_Campo(:idcampo, :idcomplejo, :tipoDeporte, :nombreCampo, :capacidad, :precioHora, :imagenCampo, :estado)");
            $stmt->bindParam(':idcampo', $idcampo, PDO::PARAM_INT);
            $stmt->bindParam(':idcomplejo', $idcomplejo, PDO::PARAM_INT);
            $stmt->bindParam(':tipoDeporte', $tipoDeporte);
            $stmt->bindParam(':nombreCampo', $nombre); // Asegurarse de que 'nombreCampo' se mapea correctamente
            $stmt->bindParam(':capacidad', $capacidad, PDO::PARAM_INT);
            $stmt->bindParam(':precioHora', $precioHora);
            if ($imagenCampo) {
                $stmt->bindParam(':imagenCampo', $imagenCampo);
            } else {
                $stmt->bindParam(':imagenCampo', $imagenCampo, PDO::PARAM_NULL);
            }
            $stmt->bindParam(':estado', $estado);
            return $stmt->execute();
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    // Listar todos los campos deportivos
    public function listarCampos()
    {
        try {
            $stmt = $this->conexion->prepare("CALL listar_Campo()");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function listarCamposPorComplejo($idcomplejo)
    {
        try {
            $stmt = $this->conexion->prepare("CALL listar_Campos_Por_Complejo(:idcomplejo)");
            $stmt->bindParam(':idcomplejo', $idcomplejo, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    // Eliminar un campo deportivo
    public function eliminarCampo($idCampo)
    {
        try {
            // Llamar al procedimiento almacenado
            $stmt = $this->conexion->prepare("CALL eliminar_Campo(:idcampo)");
            $stmt->bindParam(':idcampo', $idCampo, PDO::PARAM_INT);
            $stmt->execute();

            return true;
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    // Obtener la imagen de un campo deportivo
    public function obtenerImagenCampo($idCampo)
    {
        try {
            $stmt = $this->conexion->prepare("SELECT imagenCampo FROM campos WHERE idcampo = :idcampo");
            $stmt->bindParam(':idcampo', $idCampo, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (Exception $e) {
            return null;
        }
    }

    // Obtener un campo deportivo por su ID
    public function obtenerCampoPorId($idCampo)
    {
        try {
            $stmt = $this->conexion->prepare("CALL ver_Campo(:idcampo)");
            $stmt->bindParam(':idcampo', $idCampo, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    // Seleccionar campos según tipo de deporte y/o nombre de campo
    public function seleccionarCampo($tipoDeporte = null, $nombreCampo = null)
    {
        try {
            // Preparar la llamada al procedimiento almacenado
            $stmt = $this->conexion->prepare("CALL seleccionar_Campo(:tipoDeporte, :nombreCampo)");

            // Enlazar parámetros
            if ($tipoDeporte !== null) {
                $stmt->bindParam(':tipoDeporte', $tipoDeporte, PDO::PARAM_STR);
            } else {
                $stmt->bindValue(':tipoDeporte', null, PDO::PARAM_NULL);
            }

            if ($nombreCampo !== null) {
                $stmt->bindParam(':nombreCampo', $nombreCampo, PDO::PARAM_STR);
            } else {
                $stmt->bindValue(':nombreCampo', null, PDO::PARAM_NULL);
            }

            $stmt->execute();

            // Obtener los resultados
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
    // Obtener tipos de deporte por complejo
    public function getTiposDeDeportePorComplejo($idcomplejo)
    {
        try {
            $stmt = $this->conexion->prepare("CALL obtener_tipos_de_deporte_por_complejo(:idcomplejo)");
            $stmt->bindParam(':idcomplejo', $idcomplejo, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    // Obtener campos por complejo y tipo de deporte
    public function getCamposPorComplejoYDeporte($idcomplejo, $tipoDeporte)
    {
        try {
            $stmt = $this->conexion->prepare("CALL obtener_campos_por_complejo_y_deporte(:idcomplejo, :tipoDeporte)");
            $stmt->bindParam(':idcomplejo', $idcomplejo, PDO::PARAM_INT);
            $stmt->bindParam(':tipoDeporte', $tipoDeporte, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
?>
