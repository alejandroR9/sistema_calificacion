<?php
require_once '../../db/Conexion.php';
require_once '../../utilidades/ObtenerFechas.php';
class ModeloMatricula
{
    protected $db;

    public function __construct()
    {
        $this->db = Conexion::obtenerConexion();
    }

    public function crearMatricula($id_alumno, $id_usuario, $id_periodo_academico, $id_nivel, $monto_matricula)
    {
        $sql = "INSERT INTO matricula (id_alumno,id_usuario,id_periodo_academico,id_nivel,fecha_matricula,monto_matricula) 
        VALUES (:id_alumno,:id_usuario,:id_periodo_academico,:id_nivel,:fecha_matricula,:monto_matricula)";

        $fecha = ObtenerFechas::fechaActual();
        $query = $this->db->prepare($sql);
        $query->bindParam(':id_alumno', $id_alumno, PDO::PARAM_INT);
        $query->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $query->bindParam(':id_periodo_academico', $id_periodo_academico, PDO::PARAM_INT);
        $query->bindParam(':id_nivel', $id_nivel, PDO::PARAM_INT);
        $query->bindParam(':fecha_matricula', $fecha);
        $query->bindParam(':monto_matricula', $monto_matricula);
        $query->execute();

        $idMatricula = $this->db->lastInsertId();

        //DETALLES DE MATRICULA
        $query = "SELECT * FROM curso_docente p  
                WHERE p.id_periodo = $id_periodo_academico AND p.id_nivel  = $id_nivel";
        $query = $this->db->query($query);
        $resultado = $query->fetchAll(PDO::FETCH_ASSOC);

        foreach ($resultado as $key) {
            $sql = "INSERT INTO detalle_matricula (id_curso_docente,id_matricula) 
                    VALUES (:id_curso_docente,:id_matricula)";
            $fecha = ObtenerFechas::fechaActual();
            $query = $this->db->prepare($sql);
            $query->bindParam(':id_curso_docente', $key['id'], PDO::PARAM_INT);
            $query->bindParam(':id_matricula', $idMatricula, PDO::PARAM_INT);
            $query->execute();
        }

        return true;
    }

    public function obtenerMatriculas($search = '')
    {
        $sql = "SELECT CONCAT(p.nombres,', ',p.apellidos) AS  nombre, pa.descripcion AS periodo, CONCAT(n.numero_de_nivel,'° ',n.nivel) nivel, m.*
        FROM matricula m  
        INNER JOIN persona p ON 
        p.id = m.id_alumno 
        INNER JOIN nivel_academico n ON
        n.id = m.id_nivel 
        INNER JOIN periodo_academico pa ON 
        pa.id = m.id_periodo_academico 
        WHERE p.nombres LIKE '%$search%' 
        ORDER BY m.id DESC LIMIT 20 ";
        $stmt = $this->db->query($sql);

        $resultado =  $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }
}
