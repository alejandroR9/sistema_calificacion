<?php
require_once '../../db/Conexion.php';
class ModeloTemario
{
    protected $db;

    public function __construct()
    {
        $this->db = Conexion::obtenerConexion();
    }

    public function crearTemario($id_curso,$titulo,$descripcion,$url_apk)
    {
        $sql = "INSERT INTO temario (id_curso,titulo,descripcion,url_apk) 
        VALUES (:id_curso,:titulo,:descripcion,:url_apk)";


        $query = $this->db->prepare($sql);
        $query->bindParam(':id_curso', $id_curso);
        $query->bindParam(':titulo', $titulo, PDO::PARAM_STR);
        $query->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
        $query->bindParam(':url_apk', $url_apk, PDO::PARAM_STR);

        $resultado = $query->execute();
        return $resultado;
    }

    public function obtenerTemarios($search = '')
    {
        $sql = "SELECT c.*, n.nivel, n.numero_de_nivel,t.url_apk FROM temario t  
        INNER JOIN cursos c ON 
        c.id = t.id_curso
        INNER JOIN nivel_academico n ON 
        n.id = c.idnivel_academico
        WHERE c.nombre LIKE '%$search%'
        GROUP BY c.id 
        ORDER BY c.id DESC LIMIT 20 ";

        $stmt = $this->db->query($sql);

        $resultado =  $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function obtenerTemario(int $id)
    {
        $sql = "SELECT * FROM temario WHERE id_curso = $id";
        $stmt = $this->db->query($sql);

        $resultado =  $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function actualizarTemario($id, $titulo,$descripcion)
    {
        $sql = "UPDATE temario SET titulo = :titulo, descripcion = :descripcion WHERE id = :id";
        $query = $this->db->prepare($sql);

        $query->bindParam(':titulo', $titulo);
        $query->bindParam(':descripcion', $descripcion);
        $query->bindParam(':id', $id, PDO::PARAM_INT);

        $resultado =  $query->execute();
        return $resultado;
    }

    public function eliminarTemario($id)
    {
        $sql = "DELETE FROM temario WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);

        $resultado =  $stmt->execute();
        return $resultado;
    }
}
