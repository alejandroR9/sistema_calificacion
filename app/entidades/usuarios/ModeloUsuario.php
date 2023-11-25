<?php
require_once '../../db/Conexion.php';
class ModeloUsuario
{
    protected $db;

    public function __construct()
    {
        $this->db = Conexion::obtenerConexion();
    }

    public function crearUsuario($id_rol, $nombre, $correo, $usuario, $password, $estado)
    {
        $md5Password = md5($password);
        $sql = "INSERT INTO usuarios (id_rol, nombre, correo, usuario,password, estado) 
        VALUES (:id_rol, :nombre, :correo, :usuario,:password, :estado)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_rol', $id_rol, PDO::PARAM_INT);
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
        $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
        $stmt->bindParam(':password', $md5Password, PDO::PARAM_STR);
        $stmt->bindParam(':estado', $estado);

        $resultado = $stmt->execute();
        return $resultado;
    }

    public function obtenerUsuarios($search = '')
    {
        $sql = "SELECT u.*, r.descripcion AS rol FROM usuarios u 
        INNER JOIN roles r ON 
        r.id = u.id_rol WHERE u.nombre LIKE '%$search%' ORDER BY u.id DESC LIMIT 20 ";
        $stmt = $this->db->query($sql);

        $resultado =  $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function obtenerUsuario(int $id)
    {
        $sql = "SELECT * FROM usuarios WHERE id = $id";
        $stmt = $this->db->query($sql);

        $resultado =  $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function actualizarUsuario($id,  $nombre, $correo, $usuario)
    {
        $sql = "UPDATE usuarios SET nombre = :nombre, correo = :correo, usuario = :usuario WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
        $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        $resultado =  $stmt->execute();
        return $resultado;
    }

    public function eliminarUsuario($id)
    {
        $sql = "DELETE FROM usuarios WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);

        $resultado =  $stmt->execute();
        return $resultado;
    }
}
