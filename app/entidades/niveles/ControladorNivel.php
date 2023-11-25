<?php
include '../../utilidades/ApiResponse.php';
class ControladorNivel {
    private $modelo;

    public function __construct($modelo) {
        $this->modelo = $modelo;
    }

    /**
     * @param object Datos en formato de objeto
     */
    public function crearNivel($data) {
        if($data['nivel'] == '') {
            echo  ApiResponse::error('nivel vacio',422);
        }
        // mas validaciones.....

        $resultado =  $this->modelo->crearNivel($data['id_usuario'] , $data['nivel'],$data['numero_de_nivel'],$data['estado']);
        if($resultado){
            echo ApiResponse::success('success',false,200);
        }
        die();
    }

    public function obtenerNiveles($search = '') {
        return $this->modelo->obtenerNiveles($search);
    }

    public function obtenerNivel($data) {
        return $this->modelo->obtenerNivel($data);
    }

    public function actualizarNivel($data, $id) {
        if($data['nivel'] == '') {
            echo  ApiResponse::error('nivel vacio',422);
        }

        $resultado =  $this->modelo->actualizarNivel($id, $data['nivel'], $data['numero_de_nivel'],$data['estado']);

        if($resultado){
            echo ApiResponse::success('success',false,200);
            return;
        }
        echo ApiResponse::error('error',true,500);
    }

    public function eliminarNivel($data) {
        $resultado =  $this->modelo->eliminarNivel($data);
        if($resultado){
            echo ApiResponse::success('success',false,201);
            return;
        }
        echo ApiResponse::error('error',true, 500);
    }
}
