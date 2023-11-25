<?php
require_once '../../db/Conexion.php';
class ModeloCurso
{
    protected $db;

    public function __construct()
    {
        $this->db = Conexion::obtenerConexion();
    }

    public function crearCurso($id_usuario,$idnivel_academico ,$nombre,$creditos,$foto)
    {
        $sql = "INSERT INTO cursos (id_usuario,idnivel_academico,nombre,creditos,foto) 
        VALUES (:id_usuario,:idnivel_academico,:nombre,:creditos,:foto)";


        $query = $this->db->prepare($sql);
        $query->bindParam(':id_usuario', $id_usuario);
        $query->bindParam(':idnivel_academico', $idnivel_academico);
        $query->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $query->bindParam(':creditos', $creditos);
        $query->bindParam(':foto', $foto, PDO::PARAM_STR);

        $resultado = $query->execute();
        return $resultado;
    }

    public function obtenerCursos($search = '')
    {
        $sql = "SELECT * FROM cursos c  WHERE c.nombre LIKE '%$search%' ORDER BY c.id DESC LIMIT 20 ";
        $stmt = $this->db->query($sql);

        $resultado =  $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function obtenerCursosAlumno($idNivel, $idPeriodo,$idAlumno)
    {
        $sql = "SELECT c.* 
        FROM detalle_matricula dm   
        INNER JOIN matricula m ON
        m.id =  dm.id_matricula 
        INNER JOIN curso_docente cd ON
        cd.id = dm.id_curso_docente 
        INNER JOIN cursos c  ON
        c.id = cd.idcurso
        WHERE cd.id_periodo = $idPeriodo AND m.id_nivel = $idNivel AND m.id_alumno = $idAlumno
        ";
        $stmt = $this->db->query($sql);

        $resultado =  $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }
    public function obtenerCursosAlumnoDocente($idNivel, $idPeriodo,$idDocente)
    {
        $sql = "SELECT c.* 
        FROM curso_docente cd   
        INNER JOIN cursos c  ON
        c.id = cd.idcurso
        WHERE cd.id_periodo = $idPeriodo AND cd.id_nivel = $idNivel AND cd.id_docente  = $idDocente
        ";
        $stmt = $this->db->query($sql);

        $resultado =  $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function obtenerCurso(int $id)
    {
        $sql = "SELECT * FROM cursos WHERE id = $id";
        $stmt = $this->db->query($sql);

        $resultado =  $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function actualizarCurso($id, $idnivel_academico ,$nombre,$creditos)
    {
        $sql = "UPDATE cursos SET idnivel_academico = :idnivel_academico, nombre = :nombre, creditos = :creditos WHERE id = :id";
        $query = $this->db->prepare($sql);

        $query->bindParam(':idnivel_academico', $idnivel_academico);
        $query->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $query->bindParam(':creditos', $creditos);
        $query->bindParam(':id', $id, PDO::PARAM_INT);

        $resultado =  $query->execute();
        return $resultado;
    }

    public function eliminarCurso($id)
    {
        $sql = "DELETE FROM cursos WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);

        $resultado =  $stmt->execute();
        return $resultado;
    }
}
