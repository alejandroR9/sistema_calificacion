<?php
include '../../utilidades/ApiResponse.php';
class ControladorNotas {
    private $modelo;

    public function __construct($modelo) {
        $this->modelo = $modelo;
    }

    /**
     * @param object Datos en formato de objeto
     */
    public function crearNotas($data) {
        if($data['descripcion'] == '') {
            echo  ApiResponse::error('nota vacio',422);
            return;
        }
        // mas validaciones.....

        $resultado =  $this->modelo->crearNotas($data['id_periodo'],$data['id_nivel'],$data['idcurso'] , $data['notas'],$data['descripcion']);
        if($resultado){
            echo ApiResponse::success('success',false,200);
        }
        die();
    }

    public function obtenerNotas($search = '', $id_periodo, $id_nivel, $idcurso, $idalumno) {
        return $this->modelo->obtenerNotas($search, $id_periodo, $id_nivel, $idcurso, $idalumno);
    }


    public function eliminarNotas($data) {
        $resultado =  $this->modelo->eliminarNotas($data);
        if($resultado){
            echo ApiResponse::success('success',false,201);
            return;
        }
        echo ApiResponse::error('error',true, 500);
    }
}
