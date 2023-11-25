<?php
require_once '../../db/Conexion.php';
class ModeloExamen
{
    protected $db;

    public function __construct()
    {
        $this->db = Conexion::obtenerConexion();
    }

    public function crearExamen($id_curso_docente, $titulo, $descripcion, $tiempo, $preguntas,$expiracion)
    {


        $sql = "INSERT INTO examen (id_curso_docente,titulo,descripcion,tiempo,expiracion) 
        VALUES (:id_curso_docente,:titulo,:descripcion,:tiempo,:expiracion)";


        $query = $this->db->prepare($sql);
        $query->bindParam(':id_curso_docente', $id_curso_docente);
        $query->bindParam(':titulo', $titulo);
        $query->bindParam(':descripcion', $descripcion);
        $query->bindParam(':tiempo', $tiempo);
        $query->bindParam(':expiracion', $expiracion);
        $query->execute();
        $idExamen = $this->db->lastInsertId();


        //INSERTAMOS LA PREGUNTAS
        foreach ($preguntas as $key) {
            $preguntas = "INSERT INTO detalles_examen (id_examen,descripcion,opcion_1,opcion_2,opcion_3,opcion_4,respuesta) 
        VALUES (:id_examen,:descripcion,:opcion_1,:opcion_2,:opcion_3,:opcion_4,:respuesta)";
            $sql = $this->db->prepare($preguntas);
            $sql->bindParam(':id_examen', $idExamen);
            $sql->bindParam(':descripcion', $key['pregunta']);
            $sql->bindParam(':opcion_1', $key['respuesta1']);
            $sql->bindParam(':opcion_2', $key['respuesta2']);
            $sql->bindParam(':opcion_3', $key['respuesta3']);
            $sql->bindParam(':opcion_4', $key['respuesta4']);
            $sql->bindParam(':respuesta', $key['respuesta_correcta']);
            $sql->execute();
        }



        return true;
    }

    public function obtenerExamenes($search = '', $idDocente)
    {
        //OBTNER EL ULTIMO PERIDO ACTIVO
        $queryPeriodo = "SELECT * FROM periodo_academico WHERE estado = 1 ORDER BY id DESC LIMIT 1";
        $send = $this->db->query($queryPeriodo);
        $resultado =  $send->fetchAll(PDO::FETCH_ASSOC);
        $idperiodo = $resultado[0]['id'];

        $sql = "SELECT e.*,  c.nombre FROM examen e 
        INNER JOIN curso_docente cd ON 
        cd.id = e.id_curso_docente  
        INNER JOIN cursos c ON 
        c.id = cd.idcurso
        WHERE cd.id_docente = $idDocente 
        AND cd.id_periodo = $idperiodo  
        AND e.titulo LIKE '%$search%' 
        ORDER BY e.id DESC LIMIT 20 ";
        $stmt = $this->db->query($sql);

        $resultado =  $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function obtenerExamenesAlumnos($idAlumno)
    {
        //OBTNER EL ULTIMO PERIDO ACTIVO
        $queryPeriodo = "SELECT * FROM periodo_academico WHERE estado = 1 ORDER BY id DESC LIMIT 1";
        $send = $this->db->query($queryPeriodo);
        $resultado =  $send->fetchAll(PDO::FETCH_ASSOC);
        $idperiodo = $resultado[0]['id'];

        //OBTENER LA ULTIMA MATRICULA
        $queryMatricula = "SELECT * FROM matricula WHERE id_alumno = $idAlumno AND id_periodo_academico = $idperiodo  LIMIT 1";
        $get = $this->db->query($queryMatricula);
        if ($get->rowCount() > 0) {
            $rs = $get->fetchAll(PDO::FETCH_ASSOC);
            $idPeriodo = $rs[0]['id_periodo_academico'];
            $idNivel = $rs[0]['id_nivel'];

            //LISTAMOS LOS EXAMENES DEL ALUMNO
            $sql = "SELECT e.*,  c.nombre,  
            IF( NOW() <= e.expiracion,'activo','vencido') AS estado,
            re.id_examen
            FROM examen e 
            LEFT JOIN resultado_examen re ON 
            re.id_examen = e.id
            INNER JOIN curso_docente cd ON 
            cd.id = e.id_curso_docente  
            INNER JOIN cursos c ON 
            c.id = cd.idcurso
            WHERE cd.id_periodo = $idPeriodo 
            AND cd.id_nivel = $idNivel GROUP BY e.id
            ORDER BY e.id DESC LIMIT 20 ";
            $stmt = $this->db->query($sql);
            $resultado =  $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
            
            // AND   NOW() <= e.expiracion
        }
        return [];
    }
    public function obtenerExamen($idExamen)
    {
        //LISTAMOS LOS EXAMENES DEL ALUMNO
        $sql = "SELECT e.*,  c.nombre 
         FROM examen e 
         INNER JOIN curso_docente cd ON 
         cd.id = e.id_curso_docente  
         INNER JOIN cursos c ON 
         c.id = cd.idcurso
         WHERE e.id = $idExamen";
        $stmt = $this->db->query($sql);
        $resultado =  $stmt->fetchAll(PDO::FETCH_ASSOC);
        $id = $resultado[0]['id'];


        //OBTNER LAS PREGUNTAS DEL EXAMEN
        $detalle = "SELECT e.id, e.descripcion, e.opcion_1, e.opcion_2, e.opcion_3, e.opcion_4 
         FROM detalles_examen e
         WHERE e.id_examen = $id";
        $query = $this->db->query($detalle);
        $rs =  $query->fetchAll(PDO::FETCH_ASSOC);

        // Crear el arreglo con el formato deseado
        $examenConPreguntas = [
            'examen' => $resultado[0],
            'preguntas' => $rs
        ];

        return $examenConPreguntas;
    }
}
