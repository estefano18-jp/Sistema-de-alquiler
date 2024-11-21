<?php
require_once 'Conexion.php';

class Persona extends Conexion {
    private $pdo;

    public function __CONSTRUCT() {
        $this->pdo = parent::getConexion();
    }

    // Método para registrar una persona
    public function add($params = []): int {
        $idgenerado = null;
        try {
            $query = $this->pdo->prepare("CALL spu_registrar_persona(?, ?, ?, ?)");
            $query->execute([
                $params['nombre'],
                $params['apellido'],
                $params['telefono'],
                $params['nrodocumento']
            ]);

            $row = $query->fetch(PDO::FETCH_ASSOC);
            $idgenerado = $row['idpersona'];
        } catch (Exception $e) {
            $idgenerado = -1;
        }
        return $idgenerado;
    }

    // Método para buscar persona por documento
    public function searchByDoc($params = []): array {
        try {
            $query = $this->pdo->prepare("CALL spu_usuarios_buscar_dni(?)");
            $query->execute([$params['nrodocumento']]);
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    // Método para listar todas las personas
    public function listAll(): array {
        try {
            $query = $this->pdo->prepare("CALL spu_listar_persona()");
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    // Método para eliminar una persona
    public function delete($idpersona): bool {
        try {
            $query = $this->pdo->prepare("CALL spu_eliminar_persona(?)");
            $query->execute([$idpersona]);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    // Método para actualizar una persona
    public function update($params = []): bool {
        try {
            $query = $this->pdo->prepare("CALL spu_actualizar_persona(?, ?, ?, ?, ?)");
            $query->execute([
                $params['idpersona'],
                $params['nombre'],
                $params['apellido'],
                $params['telefono'],
                $params['nrodocumento']
            ]);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
?>
