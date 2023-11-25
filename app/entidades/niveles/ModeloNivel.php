<?php
require_once '../../db/Conexion.php';

require_once '../../utilidades/ObtenerFechas.php';
class ModeloNivel
{
    protected $db;

    public function __construct()
    {
        $this->db = Conexion::obtenerConexion();
    }

    public function crearNivel($id_usuario , $nivel,$numero_de_nivel,$estado)
    {
        $sql = "INSERT INTO nivel_academico (id_usuario ,nivel,numero_de_nivel,fecha_de_creacion,estado) 
        VALUES (:id_usuario ,:nivel,:numero_de_nivel,:fecha_de_creacion,:estado)";

        $fecha = ObtenerFechas::fechaActual();

        $query = $this->db->prepare($sql);
        $query->bindParam(':id_usuario', $id_usuario, PDO::PARAM_STR);
        $query->bindParam(':nivel', $nivel, PDO::PARAM_STR);
        $query->bindParam(':numero_de_nivel', $numero_de_nivel, PDO::PARAM_STR);
        $query->bindParam(':fecha_de_creacion', $fecha, PDO::PARAM_STR);
        $query->bindParam(':estado', $estado, PDO::PARAM_STR);

        $resultado = $query->execute();
        return $resultado;
    }

    public function obtenerNiveles($search = '')
    {
        $sql = "SELECT n.*, u.nombre FROM nivel_academico n 
        INNER JOIN usuarios u ON 
        u.id = n.id_usuario
         WHERE n.nivel LIKE '%$search%' 
         ORDER BY n.id DESC LIMIT 20";
        $stmt = $this->db->query($sql);

        $resultado =  $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function obtenerNivel(int $id)
    {
        $sql = "SELECT * FROM nivel_academico WHERE id = $id";
        $stmt = $this->db->query($sql);

        $resultado =  $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function actualizarNivel($id, $nivel,$numero_de_nivel,$estado)
    {
        $sql = "UPDATE nivel_academico SET nivel = :nivel,numero_de_nivel = :numero_de_nivel, estado = :estado WHERE id = :id";
        $query = $this->db->prepare($sql);

        $query->bindParam(':nivel', $nivel, PDO::PARAM_STR);
        $query->bindParam(':numero_de_nivel', $numero_de_nivel, PDO::PARAM_STR);
        $query->bindParam(':estado', $estado, PDO::PARAM_STR);
        $query->bindParam(':id', $id, PDO::PARAM_INT);

        $resultado =  $query->execute();
        return $resultado;
    }

    public function eliminarNivel($id)
    {
        $sql = "DELETE FROM nivel_academico WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);

        $resultado =  $stmt->execute();
        return $resultado;
    }
}
