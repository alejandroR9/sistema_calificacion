<?php
include '../../utilidades/ApiResponse.php';
class ControladorPeriodo {
    private $modelo;

    public function __construct($modelo) {
        $this->modelo = $modelo;
    }

    /**
     * @param object Datos en formato de objeto
     */
    public function crearPeriodo($data) {
        if($data['descripcion'] <= 0) {
            echo  ApiResponse::error('descripcion vacio',422);
        }

        $resultado =  $this->modelo->crearPeriodo($data['descripcion'],$data['estado']);
        if($resultado){
            echo ApiResponse::success('success',false,200);
        }
        die();
    }

    public function obtenerPeriodos($search = '') {
        return $this->modelo->obtenerPeriodos($search);
    }

    public function obtenerPeriodo($data) {
        return $this->modelo->obtenerPeriodo($data);
    }

    public function actualizarPeriodo($data, $id) {
        if($data['descripcion'] =='') {
            return ApiResponse::error('descripcion vacio',422);
        }

        $resultado =  $this->modelo->actualizarPeriodo($id, $data['descripcion'],$data['estado']);

        if($resultado){
            echo ApiResponse::success('success',false,200);
            return;
        }
        echo ApiResponse::error('error',true,500);
    }

    public function eliminarPeriodo($data) {
        $resultado =  $this->modelo->eliminarPeriodo($data);
        if($resultado){
            echo ApiResponse::success('success',false,201);
            return;
        }
        echo ApiResponse::error('error',true, 500);
    }
}
