<?php
include '../../utilidades/ApiResponse.php';
class ControladorUsuario {
    private $modelo;

    public function __construct($modelo) {
        $this->modelo = $modelo;
    }

    /**
     * @param object Datos en formato de obejeto
     */
    public function crearUsuario($data) {
        if($data['id_rol'] <= 0) {
            echo  ApiResponse::error('rol invalido',422);
        }
        if($data['nombre'] =='') {
             echo ApiResponse::error('nombre vacio',422);
             return;
        }
        if($data['correo'] =='') {
            echo ApiResponse::error('correo vacio',422);
            return;
        }
        if($data['usuario'] =='') {
             echo ApiResponse::error('usuario vacio',422);
             return;
        }
        if($data['password'] =='') {
            echo ApiResponse::error('password vacio',422);
            return;
        }
        
        $resultado =  $this->modelo->crearUsuario($data['id_rol'], $data['nombre'],$data['correo'], $data['usuario'], $data['password'], 1);
        if($resultado){
            echo ApiResponse::success('success',false,200);
        }
        die();
    }

    public function obtenerUsuarios($search = '') {
        return $this->modelo->obtenerUsuarios($search);
    }

    public function obtenerUsuario($data) {
        return $this->modelo->obtenerUsuario($data);
    }

    public function actualizarUsuario($data, $id) {
        if($data['nombre'] =='') {
            return ApiResponse::error('nombre vacio',422);
        }
        if($data['correo'] =='') {
            return ApiResponse::error('correo vacio',422);
        }
        if($data['usuario'] =='') {
            return ApiResponse::error('usuario vacio',422);
        }
        if($data['usuario'] =='') {
            return ApiResponse::error('usuario vacio',422);
        }
        $resultado =  $this->modelo->actualizarUsuario($id, $data['nombre'],$data['correo'], $data['usuario']);

        if($resultado){
            echo ApiResponse::success('success',false,200);
            return;
        }
        echo ApiResponse::error('error',true,500);
    }

    public function eliminarUsuario($data) {
        $resultado =  $this->modelo->eliminarUsuario($data);
        if($resultado){
            echo ApiResponse::success('success',false,201);
            return;
        }
        echo ApiResponse::error('error',true, 500);
    }
}
