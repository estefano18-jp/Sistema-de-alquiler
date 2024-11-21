<?php

class Conexion {

    // Almacenamos los datos de conexión
    private $servidor = "localhost";
    private $puerto = "3306";
    private $baseDatos = "SISTEMACAMPOALQUILER";
    private $usuario = "root";
    private $clave = "";

    public function getConexion() {
        $pdo = null;
        try {
            $pdo = new PDO(
                "mysql:host={$this->servidor};port={$this->puerto};dbname={$this->baseDatos};charset=UTF8", 
                $this->usuario, 
                $this->clave
            );
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (Exception $e) {
            die("Error en la conexión: " . $e->getMessage());
        } finally {
            // Aquí puedes cerrar la conexión si lo necesitas, aunque PDO lo hace automáticamente.
            if ($pdo) {
                $pdo = null;
            }
        }
    }
}  
