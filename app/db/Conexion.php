<?php
class Conexion {
    private static $conexion = null;
    
    private function __construct() {
        $dsn = "mysql:host=localhost;dbname=colegio_test";
        $usuario = "root";
        $contrasena = "123456";
        
        try {
            self::$conexion = new PDO($dsn, $usuario, $contrasena);
            self::$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error al conectar a la base de datos: " . $e->getMessage());
        }
    }
    
    public static function obtenerConexion() {
        if (self::$conexion === null) {
            new Conexion();
        }
        return self::$conexion;
    }
}
