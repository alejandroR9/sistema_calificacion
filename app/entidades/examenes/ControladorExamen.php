<?php
include '../../utilidades/ApiResponse.php';
class ControladorExamen {
    private $modelo;

    public function __construct($modelo) {
        $this->modelo = $modelo;
    }

    /**
     * @param object Datos en formato de objeto
     */
    public function crearExamen($data) {
        if($data['id_curso_docente'] <= 0) {
            echo  ApiResponse::error('id_curso_docente vacio',422);
            return;
        }
        if($data['titulo'] == '') {
            echo  ApiResponse::error('titulo vacio',422);
            return;
        }
        if($data['descripcion'] == '') {
            echo  ApiResponse::error('descripcion vacio',422);
            return;
        }
        if($data['tiempo'] <= 0) {
            echo  ApiResponse::error('tiempo vacio',422);
            return;
        }
        if($data['expiracion'] =='') {
            echo  ApiResponse::error('tiempo vacio',422);
            return;
        }

        $resultado =  $this->modelo->crearExamen($data['id_curso_docente'],$data['titulo'],$data['descripcion'],$data['tiempo'],$data['preguntas'],$data['expiracion']);
        if($resultado){
            echo ApiResponse::success('success',false,200);
        }
        die();
    }

    public function obtenerExamenes($search = '',$idDocente) {
        return $this->modelo->obtenerExamenes($search,$idDocente);
    }

    public function obtenerExamenesAlumnos($idAlumno) {
        return $this->modelo->obtenerExamenesAlumnos($idAlumno);
    }

    public function obtenerExamen($idExamen) {
        return $this->modelo->obtenerExamen($idExamen);
    }

}
