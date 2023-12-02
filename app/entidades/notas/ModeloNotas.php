<?php
require_once '../../db/Conexion.php';

class ModeloNotas
{
    protected $db;

    public function __construct()
    {
        $this->db = Conexion::obtenerConexion();
    }

    public function crearNotas($id_periodo, $id_nivel, $idcurso, $notas, $descripcion)
    {
        $resultado = null;

        foreach ($notas as $value) {
            $sql = "INSERT INTO notas (id_periodo,id_nivel,idcurso,idalumno,nota,descripcion) 
        VALUES (:id_periodo,:id_nivel,:idcurso,:idalumno,:nota,:descripcion)";

            $query = $this->db->prepare($sql);
            $query->bindParam(':id_periodo', $id_periodo);
            $query->bindParam(':id_nivel', $id_nivel);
            $query->bindParam(':idcurso', $idcurso);
            $query->bindParam(':idalumno', $value['id']);
            $query->bindParam(':nota', $value['nota']);
            $query->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);

            $resultado = $query->execute();
        }


        return $resultado;
    }

    public function obtenerNotas($search = '', $id_periodo, $id_nivel, $idcurso, $idalumno)
    {
        $sql = "SELECT *
         FROM notas n 
         WHERE descripcion 
         LIKE '%$search%' 
         AND id_periodo = $id_periodo 
         AND id_nivel = $id_nivel 
         AND idcurso = $idcurso 
         AND idalumno = $idalumno
         ORDER BY n.id DESC";
        $stmt = $this->db->query($sql);

        $resultado =  $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }


    public function eliminarNota($id)
    {
        $sql = "DELETE FROM notas WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);

        $resultado =  $stmt->execute();
        return $resultado;
    }
}
