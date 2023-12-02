<?php
include '../../utilidades/ApiResponse.php';
class ControladorTemario {
    private $modelo;

    public function __construct($modelo) {
        $this->modelo = $modelo;
    }

    /**
     * @param object Datos en formato de objeto
     */
    public function crearTemario($data) {
        if($data['titulo'] <= 0) {
            echo  ApiResponse::error('titulo vacio',422);
        }

        $resultado =  $this->modelo->crearTemario($data['id_curso'],$data['titulo'],$data['descripcion'],$data['url_apk'],$data['descripcion_apk'],$data['peso_apk']);
        if($resultado){
            echo ApiResponse::success('success',false,200);
        }
        die();
    }

    public function obtenerTemarios($search = '') {
        return $this->modelo->obtenerTemarios($search);
    }

    public function obtenerTemario($data) {
        return $this->modelo->obtenerTemario($data);
    }

    public function actualizarTemario($data, $id) {
        if($data['titulo'] =='') {
            return ApiResponse::error('titulo vacio',422);
        }

        $resultado =  $this->modelo->actualizarTemario($id,$data['titulo'],$data['descripcion']);

        if($resultado){
            echo ApiResponse::success('success',false,200);
            return;
        }
        echo ApiResponse::error('error',true,500);
    }

    public function eliminarTemario($data) {
        $resultado =  $this->modelo->eliminarTemario($data);
        if($resultado){
            echo ApiResponse::success('success',false,201);
            return;
        }
        echo ApiResponse::error('error',true, 500);
    }
}
