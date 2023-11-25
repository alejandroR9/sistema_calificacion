<?php
require_once '../../db/Conexion.php';
class ModeloPeriodo
{
    protected $db;

    public function __construct()
    {
        $this->db = Conexion::obtenerConexion();
    }

    public function crearPeriodo($descripcion,$estado)
    {
        $sql = "INSERT INTO periodo_academico (descripcion,estado) 
        VALUES (:descripcion,:estado)";


        $query = $this->db->prepare($sql);
        $query->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
        $query->bindParam(':estado', $estado, PDO::PARAM_STR);

        $resultado = $query->execute();
        return $resultado;
    }

    public function obtenerPeriodos($search = '')
    {
        $sql = "SELECT * FROM periodo_academico p  WHERE p.descripcion LIKE '%$search%' ORDER BY p.id DESC LIMIT 20 ";
        $stmt = $this->db->query($sql);

        $resultado =  $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function obtenerPeriodo(int $id)
    {
        $sql = "SELECT * FROM periodo_academico WHERE id = $id";
        $stmt = $this->db->query($sql);

        $resultado =  $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function actualizarPeriodo($id, $descripcion,$estado)
    {
        $sql = "UPDATE periodo_academico SET descripcion = :descripcion, estado = :estado WHERE id = :id";
        $query = $this->db->prepare($sql);

        $query->bindParam(':descripcion', $descripcion);
        $query->bindParam(':estado', $estado);
        $query->bindParam(':id', $id, PDO::PARAM_INT);

        $resultado =  $query->execute();
        return $resultado;
    }

    public function eliminarPeriodo($id)
    {
        $sql = "DELETE FROM periodo_academico WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);

        $resultado =  $stmt->execute();
        return $resultado;
    }
}
