<?php

require_once 'conexion.php';

class Reserva
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = (new Conexion())->getConexion();
    }

    public function registrarReserva($data)
    {
        try {
            $this->conexion->beginTransaction();

            $idpersona = $data['idpersona'];
            $idcampo = $data['idcampo'];
            $fechaInicio = $data['fechaInicio'];
            $horaInicio = $data['horaInicio'];
            $horaReservar = $data['horaReservar'];
            $productos = $data['productos']; // array of products
            $servicios = $data['servicios']; // array of services

            // Llamar al procedimiento almacenado
            $stmt = $this->conexion->prepare("CALL registrar_reserva(:idpersona, :idcampo, :fechaInicio, :horaInicio, :horaReservar, @p_idreserva)");

            $stmt->bindParam(':idpersona', $idpersona);
            $stmt->bindParam(':idcampo', $idcampo);
            $stmt->bindParam(':fechaInicio', $fechaInicio);
            $stmt->bindParam(':horaInicio', $horaInicio);
            $stmt->bindParam(':horaReservar', $horaReservar);

            $stmt->execute();

            // Obtener el idreserva generado
            $result = $this->conexion->query("SELECT @p_idreserva AS idreserva");
            $idreserva = $result->fetch(PDO::FETCH_ASSOC)['idreserva'];

            $montototal = 0;

            // Obtener el precio de la reservación
            $stmt = $this->conexion->prepare("SELECT precioReservacion FROM reservas WHERE idreserva = :idreserva");
            $stmt->bindParam(':idreserva', $idreserva);
            $stmt->execute();
            $precioReservacion = $stmt->fetch(PDO::FETCH_ASSOC)['precioReservacion'];

            $montototal += $precioReservacion;

            // Insertar productos
            foreach ($productos as $producto) {
                $nombre = $producto['nombre'];
                $cantidad = $producto['cantidad'];
                $precio = $producto['precio'];
                $total = $producto['total'];

                // Obtener idproducto
                $stmt = $this->conexion->prepare("SELECT idproducto FROM productos WHERE nombre = :nombre AND estado = 'activo'");
                $stmt->bindParam(':nombre', $nombre);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($row) {
                    $idproducto = $row['idproducto'];

                    // Insertar en detalle_reserva_productos
                    $stmt = $this->conexion->prepare("INSERT INTO detalle_reserva_productos (idreserva, idproducto, cantidad, precio, total) VALUES (:idreserva, :idproducto, :cantidad, :precio, :total)");
                    $stmt->bindParam(':idreserva', $idreserva);
                    $stmt->bindParam(':idproducto', $idproducto);
                    $stmt->bindParam(':cantidad', $cantidad);
                    $stmt->bindParam(':precio', $precio);
                    $stmt->bindParam(':total', $total);
                    $stmt->execute();

                    $montototal += $total;

                    // Actualizar cantidad en productos
                    $stmt = $this->conexion->prepare("UPDATE productos SET cantidad = cantidad - :cantidad WHERE idproducto = :idproducto");
                    $stmt->bindParam(':cantidad', $cantidad);
                    $stmt->bindParam(':idproducto', $idproducto);
                    $stmt->execute();
                } else {
                    throw new Exception('Producto no encontrado: ' . $nombre);
                }
            }

            // Insertar servicios
            foreach ($servicios as $servicio) {
                $nombre = $servicio['nombre'];
                $precio = $servicio['precio'];
                $total = $servicio['total'];

                // Obtener idservicio
                $stmt = $this->conexion->prepare("SELECT idservicio FROM servicios WHERE nombre = :nombre AND estado = 'activo'");
                $stmt->bindParam(':nombre', $nombre);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($row) {
                    $idservicio = $row['idservicio'];

                    // Insertar en detalle_reserva_servicios
                    $stmt = $this->conexion->prepare("INSERT INTO detalle_reserva_servicios (idreserva, idservicio, precio, total) VALUES (:idreserva, :idservicio, :precio, :total)");
                    $stmt->bindParam(':idreserva', $idreserva);
                    $stmt->bindParam(':idservicio', $idservicio);
                    $stmt->bindParam(':precio', $precio);
                    $stmt->bindParam(':total', $total);
                    $stmt->execute();

                    $montototal += $total;
                } else {
                    throw new Exception('Servicio no encontrado: ' . $nombre);
                }
            }

            // Actualizar montototal en reservas
            $stmt = $this->conexion->prepare("UPDATE reservas SET montototal = :montototal WHERE idreserva = :idreserva");
            $stmt->bindParam(':montototal', $montototal);
            $stmt->bindParam(':idreserva', $idreserva);
            $stmt->execute();

            $this->conexion->commit();
            return ['mensaje' => 'Reserva registrada correctamente'];
        } catch (Exception $e) {
            $this->conexion->rollBack();
            return ['error' => $e->getMessage()];
        }
    }

    public function listarReservas()
    {
        try {
            $stmt = $this->conexion->prepare("CALL listar_reserva()");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
    public function eliminarReserva($idreserva)
    {
        try {
            // Preparar la llamada al procedimiento almacenado
            $stmt = $this->conexion->prepare("CALL eliminar_reserva(:idreserva)");
            $stmt->bindParam(':idreserva', $idreserva, PDO::PARAM_INT);
            $stmt->execute();

            // Obtener el mensaje de respuesta del procedimiento
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result && isset($result['mensaje'])) {
                return ['mensaje' => $result['mensaje']];
            } else {
                return ['error' => 'No se pudo eliminar la reserva.'];
            }
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
    public function obtenerHorasOcupadas($idcampo, $fecha)
    {
        try {
            $stmt = $this->conexion->prepare("CALL obtener_horas_ocupadas(:idcampo, :fecha)");
            $stmt->bindParam(':idcampo', $idcampo, PDO::PARAM_INT);
            $stmt->bindParam(':fecha', $fecha);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
    // Nuevo método para listar reservas por persona
    public function listarReservasPorPersona($idpersona)
    {
        try {
            $stmt = $this->conexion->prepare("CALL listar_reserva_por_persona(:idpersona)");
            $stmt->bindParam(':idpersona', $idpersona, PDO::PARAM_INT);
            $stmt->execute();
            $reservas = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $reservas;
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
    public function obtenerDetalleReserva($idreserva)
    {
        try {
            // Obtener detalles generales de la reserva
            $stmt = $this->conexion->prepare("CALL listar_reserva()"); // Reutilizando el procedimiento existente
            $stmt->execute();
            $reservas = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $detalleReserva = null;

            foreach ($reservas as $reserva) {
                if ($reserva['idreserva'] == $idreserva) {
                    $detalleReserva = $reserva;
                    break;
                }
            }

            if (!$detalleReserva) {
                return ['error' => 'Reserva no encontrada'];
            }

            // Obtener productos asociados a la reserva
            $stmt = $this->conexion->prepare("SELECT dp.cantidad, p.nombre, dp.precio, dp.total FROM detalle_reserva_productos dp JOIN productos p ON dp.idproducto = p.idproducto WHERE dp.idreserva = :idreserva");
            $stmt->bindParam(':idreserva', $idreserva, PDO::PARAM_INT);
            $stmt->execute();
            $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Obtener servicios asociados a la reserva
            $stmt = $this->conexion->prepare("SELECT ds.precio, s.nombre, ds.total FROM detalle_reserva_servicios ds JOIN servicios s ON ds.idservicio = s.idservicio WHERE ds.idreserva = :idreserva");
            $stmt->bindParam(':idreserva', $idreserva, PDO::PARAM_INT);
            $stmt->execute();
            $servicios = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Combinar toda la información
            $detalleReserva['productos'] = $productos;
            $detalleReserva['servicios'] = $servicios;

            return $detalleReserva;
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
