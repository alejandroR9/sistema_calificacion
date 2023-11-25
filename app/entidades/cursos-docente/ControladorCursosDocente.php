<?php
include '../../utilidades/ApiResponse.php';
class ControladorCursosDocente {
    private $modelo;

    public function __construct($modelo) {
        $this->modelo = $modelo;
    }

    /**
     * @param object Datos en formato de objeto
     */
    public function crearCursosDocente($data) {
        if(empty($data['cursos'])) {
            echo  ApiResponse::error('cursos vacios',422);
            return;
        }

        $resultado =  $this->modelo->crearCursosDocente($data['cursos']);
        if($resultado){
            echo ApiResponse::success('success',false,200);
        } else {            
            echo ApiResponse::success('error',false,422);
        }
        die();
    }

    public function obtenerCursosDocentes($search = '') {
        return $this->modelo->obtenerCursosDocentes($search);
    }

    public function obtenerCursosDocente($data) {
        return $this->modelo->obtenerCursosDocente($data);
    }

    public function obtenerCursosDelDocente($idDocente) {
        return $this->modelo->obtenerCursosDelDocente($idDocente);
    }

    public function eliminarCursosDocente($data) {
        $resultado =  $this->modelo->eliminarCursosDocente($data);
        if($resultado){
            echo ApiResponse::success('success',false,201);
            return;
        }
        echo ApiResponse::error('error',true, 500);
    }
}
