<?php
require_once '../../db/Conexion.php';
require_once '../../utilidades/EnviarCorreo.php';
class ModeloDarExamen
{
    protected $db;

    public function __construct()
    {
        $this->db = Conexion::obtenerConexion();
    }

    public function crearExamen($id_examen, $id_alumno, $tiempo, $respuestas)
    {

        //PREGUNTAS DEL EXAMEN
        $preguntas = "SELECT id, respuesta FROM detalles_examen WHERE id_examen = $id_examen";
        $ejecutarpreguntas = $this->db->query($preguntas);
        $resultadoPreguntas =  $ejecutarpreguntas->fetchAll(PDO::FETCH_ASSOC);

        $notaTotal = 0;
        $respuestasComparadas = [];

        foreach ($resultadoPreguntas as $pregunta) {
            $idPregunta = $pregunta['id'];
            $respuestaCorrecta = $pregunta['respuesta'];

            // Buscar la respuesta del alumno para esta pregunta
            $respuestaAlumno = null;
            foreach ($respuestas as $respAlumno) {
                if ($respAlumno['pregunta'] == $idPregunta) {
                    $respuestaAlumno = $respAlumno['respuesta'];
                    break;
                }
            }

            if ($respuestaAlumno === null) {
                // El alumno no respondió a esta pregunta, se puede manejar de acuerdo a tus necesidades
                $respuestasComparadas[] = ["id" => $idPregunta, "correcta" => 0];
            } else {
                // Comparar la respuesta del alumno con la respuesta correcta
                if ($respuestaAlumno == $respuestaCorrecta) {
                    $notaTotal++;
                    $respuestasComparadas[] = ["id" => $idPregunta, "correcta" => 1];
                } else {
                    $respuestasComparadas[] = ["id" => $idPregunta, "correcta" => 0];
                }
            }
        }


        // Calcular la nota final del alumno
        $puntoNotas = 20 / count($resultadoPreguntas);

        $nota = $puntoNotas * $notaTotal;
        $notaFinal = 0;
        if ($nota > 20) {
            $notaFinal = 20;
        } else {
            $notaFinal = ceil($nota);
        }
        // Verificar si el alumno aprobó o no
        $aprobado = ($notaFinal > 10) ? 1 : 0;



        //INSERTAMOS EL EXAMEN DEL ALUMNO
        $sql = "INSERT INTO resultado_examen (id_examen,id_alumno,tiempo,estado,nota) 
        VALUES (:id_examen,:id_alumno,:tiempo,:estado,:nota)";
        $query = $this->db->prepare($sql);
        $query->bindParam(':id_examen', $id_examen);
        $query->bindParam(':id_alumno', $id_alumno);
        $query->bindParam(':tiempo', $tiempo);
        $query->bindParam(':estado', $aprobado);
        $query->bindParam(':nota', $notaFinal);
        $query->execute();
        $idResultadoExamen = $this->db->lastInsertId();




        //INSERTAMOS LA RESPUESTAS DEL EXAMEN DEL ALUMNO
        foreach ($respuestasComparadas as $key) {
            $preguntas = "INSERT INTO resultado_examen_detalle (id_resultado,id_detalle_examen ,estado) 
        VALUES (:id_resultado,:id_detalle_examen ,:estado)";
            $sql = $this->db->prepare($preguntas);
            $sql->bindParam(':id_resultado', $idResultadoExamen);
            $sql->bindParam(':id_detalle_examen', $key['id']);
            $sql->bindParam(':estado', $key['correcta']);
            $sql->execute();
        }


        //BUSQUEDA DEL ALUMNO
        //PREGUNTAS DEL EXAMEN
        $alumnos = "SELECT cd.*, e.titulo
         FROM examen e
         INNER JOIN curso_docente cd ON 
         cd.id = e.id_curso_docente 
         WHERE e.id = $id_examen
         ";
        $alumnosQuery = $this->db->query($alumnos);
        $resultadoAlumnos =  $alumnosQuery->fetchAll(PDO::FETCH_ASSOC);

        $notas = "INSERT INTO notas (id_periodo,id_nivel,idcurso,idalumno,nota,descripcion) 
         VALUES (:id_periodo,:id_nivel,:idcurso,:idalumno,:nota,:descripcion)";
        $sqlNotas = $this->db->prepare($notas);
        $sqlNotas->bindParam(':id_periodo', $resultadoAlumnos[0]['id_periodo']);
        $sqlNotas->bindParam(':id_nivel', $resultadoAlumnos[0]['id_nivel']);
        $sqlNotas->bindParam(':idcurso', $resultadoAlumnos[0]['idcurso']);
        $sqlNotas->bindParam(':idalumno', $id_alumno);
        $sqlNotas->bindParam(':nota', $notaFinal);
        $sqlNotas->bindParam(':descripcion', $resultadoAlumnos[0]['titulo'], PDO::PARAM_STR);
        $sqlNotas->execute();



        $this->enviarCorreo($id_alumno, $id_examen, $notaFinal, $tiempo, $aprobado);








        return true;
    }

    public function obtenerResultados($idExamen, $idAlumno)
    {
        $sql = "SELECT e.*,  CONCAT(p.nombres,', ',p.apellidos) AS nombre
        FROM resultado_examen e  
        INNER JOIN persona p ON 
        p.id = e.id_alumno
        WHERE e.id_alumno = $idAlumno  AND e.id_examen = $idExamen 
        ORDER BY e.id DESC";
        $stmt = $this->db->query($sql);

        $resultado =  $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function enviarCorreo($idAlumno, $idExamen, $nota, $tiempo, $estado)
    {
        //DATOS DEL ALUMNO
        $datosAlumno = "SELECT * FROM alumnos_padre WHERE id_alumno  = $idAlumno ";
        $stmt = $this->db->query($datosAlumno);
        $resultadoDatosAlumno =  $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (!empty($correo)) {
            $correo = $resultadoDatosAlumno[0]['correo'];
            //DATOS DEL CURSO
            $datosCurso = "SELECT c.nombre FROM examen e
            INNER JOIN curso_docente cd ON 
            cd.id = e.id_curso_docente 
            INNER JOIN cursos c ON 
            c.id = cd.idcurso
            WHERE e.id = $idExamen";
            $stmts = $this->db->query($datosCurso);
            $resultadoSatosCurso =  $stmts->fetchAll(PDO::FETCH_ASSOC);
            $curso = $resultadoSatosCurso[0]['nombre'];


            EnviarCorreo::enviarNotas($correo, $curso, $nota, $tiempo, $estado);
        }
    }
}
