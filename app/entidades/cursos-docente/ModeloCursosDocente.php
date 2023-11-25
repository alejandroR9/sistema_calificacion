<?php
require_once '../../db/Conexion.php';
class ModeloCursosDocente
{
    protected $db;

    public function __construct()
    {
        $this->db = Conexion::obtenerConexion();
    }

    public function crearCursosDocente($data)
    {

        //VALIDAMOS QUE EL CURSO NO ESTE ASIGNADO AL DOCENTE PARA NO DUPLICAR DATOS
        foreach ($data as $key) {
            $docente = $key['id_docente'];
            $idcurso = $key['id_curso'];
            $id_periodo = $key['id_periodo'];
            $id_nivel = $key['id_nivel'];
            $sql = "SELECT * FROM curso_docente WHERE id_docente = $docente AND idcurso = $idcurso AND id_periodo = $id_periodo AND id_nivel = $id_nivel";
            $query = $this->db->prepare($sql);
            $query->execute();
            if($query->rowCount() > 0 ) {
                return false;
            }
        }


        foreach ($data as $key) {
            $sql = "INSERT INTO curso_docente (id_docente,idcurso,id_periodo,id_nivel) 
        VALUES (:id_docente,:idcurso,:id_periodo,:id_nivel)";


            $query = $this->db->prepare($sql);
            $query->bindParam(':id_docente', $key['id_docente']);
            $query->bindParam(':idcurso', $key['id_curso']);
            $query->bindParam(':id_periodo', $key['id_periodo']);
            $query->bindParam(':id_nivel', $key['id_nivel']);

            $query->execute();
        }
        return true;
    }

    public function obtenerCursosDocentes($search = '')
    {
        $sql = "SELECT CONCAT(p.nombres,', ',p.apellidos) AS docente, cc.nombre, pa.descripcion,CONCAT(n.numero_de_nivel,'° ',n.nivel) AS nivel
        FROM curso_docente c  
        INNER JOIN persona p ON
        p.id = c.id_docente
        INNER JOIN cursos cc ON 
        cc.id = c.idcurso 
        INNER JOIN periodo_academico pa ON 
        pa.id = c.id_periodo 
        INNER JOIN nivel_academico n ON 
        n.id = c.id_nivel 
        WHERE cc.nombre LIKE '%$search%' 
        ORDER BY p.id DESC LIMIT 20 ";
        $stmt = $this->db->query($sql);

        $resultado =  $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    //Lista los curso del docente a a cual a sido asignado, segun el periodo
    public function obtenerCursosDelDocente($idDocente)
    {


        //OBTNER EL ULTIMO PERIDO ACTIVO
        $queryPeriodo = "SELECT * FROM periodo_academico WHERE estado = 1 ORDER BY id DESC LIMIT 1";
        $send = $this->db->query($queryPeriodo);
        $resultado =  $send->fetchAll(PDO::FETCH_ASSOC);
        $idperiodo = $resultado[0]['id'];


        $sql = "SELECT c.*, cc.nombre, pa.descripcion,CONCAT(n.numero_de_nivel,'° ',n.nivel) AS nivel
        FROM curso_docente c  
        INNER JOIN cursos cc ON 
        cc.id = c.idcurso 
        INNER JOIN periodo_academico pa ON 
        pa.id = c.id_periodo 
        INNER JOIN nivel_academico n ON 
        n.id = c.id_nivel 
        WHERE c.id_docente = $idDocente AND c.id_periodo = $idperiodo
        ORDER BY c.id DESC";
        $stmt = $this->db->query($sql);

        $resultado =  $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }


    public function eliminarCursosDocente($id)
    {
        $sql = "DELETE FROM curso_docente WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);

        $resultado =  $stmt->execute();
        return $resultado;
    }
}
