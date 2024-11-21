<?php

require_once 'Conexion.php';

class Usuario extends Conexion
{

    private $pdo;

    public function __CONSTRUCT()
    {
        $this->pdo = parent::getConexion();
    }

    // Método para el inicio de sesión
    public function login($params = [])
    {
        try {
            // Llamada al procedimiento almacenado para verificar el usuario y la contraseña
            $query = $this->pdo->prepare("CALL spu_usuarios_login(?, ?)");
            $query->execute([$params['nomuser'], $params['passuser']]);
            return $query->fetchAll(PDO::FETCH_ASSOC); // Retorna el resultado de la consulta
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    // Método para registrar un usuario (con idpersona, nomuser, passuser, rol)
    public function add($params = []): int
    {
        $idusuario = null;
        try {
            $query = $this->pdo->prepare("CALL spu_usuarios_registrar(?, ?, ?, ?)");
            $query->execute(
                array(
                    $params['idpersona'],
                    $params['nomuser'],
                    password_hash($params['passuser'], PASSWORD_BCRYPT),
                    $params['rol']
                )
            );
            $row = $query->fetch(PDO::FETCH_ASSOC);
            $idusuario = $row['idusuario'];
        } catch (Exception $e) {
            $idusuario = -1;
        }

        return $idusuario;
    }

    public function obtenerDatosUsuario($idUsuario) {
        try {
            $query = $this->pdo->prepare("SELECT p.idpersona, p.nombre, p.apellido, p.telefono, p.nrodocumento 
                                          FROM personas p 
                                          INNER JOIN usuarios u ON p.idpersona = u.idpersona 
                                          WHERE u.idusuario = ?");
            $query->execute([$idUsuario]);
            return $query->fetch(PDO::FETCH_ASSOC) ?: [];
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }


    // Método para registrar una persona usando tu procedimiento almacenado
    public function registerPerson($nombre, $apellido, $telefono, $nrodocumento)
    {
        try {
            $query = $this->pdo->prepare("CALL spu_registrar_persona(?, ?, ?, ?)");
            $query->execute([$nombre, $apellido, $telefono, $nrodocumento]);
            $row = $query->fetch(PDO::FETCH_ASSOC);
            return $row['idpersona'] ?? -1;
        } catch (Exception $e) {
            return -1; // Error al registrar persona
        }
    }

    // Verificar si ya existe el usuario por número de documento
    public function checkExistingUser($nrodocumento)
    {
        try {
            $query = $this->pdo->prepare("SELECT idusuario FROM usuarios WHERE idpersona IN (SELECT idpersona FROM personas WHERE nrodocumento = ?)");
            $query->execute([$nrodocumento]);
            return $query->fetch(PDO::FETCH_ASSOC) !== false; // Devuelve true si existe, false si no
        } catch (Exception $e) {
            return false; // Error al consultar si el usuario existe
        }
    }


    // Verificar si la persona ya existe por número de documento
    public function checkExistingPerson($nrodocumento)
    {
        try {
            $query = $this->pdo->prepare("SELECT idpersona FROM personas WHERE nrodocumento = ?");
            $query->execute([$nrodocumento]);
            return $query->fetch(PDO::FETCH_ASSOC); // Devuelve los datos de la persona si existe
        } catch (Exception $e) {
            return false;
        }
    }

    // Registrar usuario
    public function registerUser($idpersona, $nomuser, $passuser)
    {
        try {
            $query = $this->pdo->prepare("CALL spu_usuarios_registrar_cliente(?, ?, ?)");
            $query->execute([$idpersona, $nomuser, $passuser]);
            $row = $query->fetch(PDO::FETCH_ASSOC);
            return $row['idusuario'] ?? -1;
        } catch (Exception $e) {
            return -1; // Error al registrar usuario
        }
    }


    // Método para registrar un nuevo usuario y persona
    public function registerNewUser($params = [])
    {
        try {
            // Primero registramos la persona
            $query = $this->pdo->prepare("CALL spu_personas_registrar(?, ?, ?, ?)");
            $query->execute(array($params['nombres'], $params['apellidos'], $params['telefono'], $params['nrodocumento']));
            $idpersona = $this->pdo->lastInsertId(); // Obtener el ID de la nueva persona

            // Luego registramos al usuario
            $query = $this->pdo->prepare("CALL spu_usuarios_registrar(?, ?, ?, ?)");
            $query->execute(array(
                $idpersona,
                $params['email'],
                password_hash($params['contraseña'], PASSWORD_BCRYPT),
                $params['rol']
            ));

            return $this->pdo->lastInsertId(); // Devolvemos el ID del nuevo usuario
        } catch (Exception $e) {
            return -1; // Error al registrar
        }
    }

    // Verificar si el nombre de usuario ya existe
    public function nomuserExists($nomuser)
    {
        try {
            $query = $this->pdo->prepare("SELECT COUNT(*) as count FROM usuarios WHERE nomuser = ?");
            $query->execute([$nomuser]);
            $result = $query->fetch(PDO::FETCH_ASSOC);
            return $result['count'] > 0;
        } catch (Exception $e) {
            return false;
        }
    }


    // Validar si el nombre ya está registrado
    public function nameExists($nombre)
    {
        try {
            $query = $this->pdo->prepare("SELECT COUNT(*) as count FROM personas WHERE nombre = ?");
            $query->execute([$nombre]);
            $result = $query->fetch(PDO::FETCH_ASSOC);
            return $result['count'] > 0; // Retorna true si el nombre y apellido ya están registrados
        } catch (Exception $e) {
            return false; // Error al consultar si el nombre existe
        }
    }

    // Validar si el apellido ya está registrado
    public function apellidoExists($apellido)
    {
        try {
            $query = $this->pdo->prepare("SELECT COUNT(*) as count FROM personas WHERE apellido = ?");
            $query->execute([$apellido]);
            $result = $query->fetch(PDO::FETCH_ASSOC);
            return $result['count'] > 0; // Retorna true si el apellido ya está registrado
        } catch (Exception $e) {
            return false; // Error al consultar si el apellido existe
        }
    }

     // Verificar si el teléfono ya está registrado
    public function phoneExists($telefono)
    {
        try {
            $query = $this->pdo->prepare("SELECT COUNT(*) as count FROM personas WHERE telefono = ?");
            $query->execute([$telefono]);
            $result = $query->fetch(PDO::FETCH_ASSOC);
            return $result['count'] > 0;
        } catch (Exception $e) {
            return false;
        }
    }
}
