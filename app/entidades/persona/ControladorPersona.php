<?php
include '../../utilidades/ApiResponse.php';
class ControladorPersona {
    private $modelo;

    public function __construct($modelo) {
        $this->modelo = $modelo;
    }

    /**
     * @param object Datos en formato de obejeto
     */
    public function crearPersona($data) {
        if($data['id_rol'] <= 0) {
            echo  ApiResponse::error('rol invalido',422);
        }
        // mas validacione...

        $resultado =  $this->modelo->crearPersona($data['id_usuario'], $data['id_rol'], $data['dni'], $data['password'], $data['apellidos'], $data['nombres'], $data['direccion'], $data['telefono'], $data['correo'], $data['seccion'], $data['nombrePadre'], $data['apellidoPadre'], $data['celularPadre'], $data['correoPadre']);
        if($resultado){
            echo ApiResponse::success('success',false,200);
            return;
        } 
        echo ApiResponse::error('dni duplicado',false,500);
        die();
    }

    public function obtenerPersonas($search = '',$role = 2) {
        return $this->modelo->obtenerPersonas($search,$role);
    }

    public function obtenerPersona($data) {
        return $this->modelo->obtenerPersona($data);
    }
    public function obtenerPersonaCursos($idPeriodo, $idNivel, $idCurso, $idDocente) {
        return $this->modelo->obtenerPersonaCursos($idPeriodo, $idNivel, $idCurso, $idDocente);
    }

    public function actualizarPersona($data, $id) {
        if($data['nombres'] =='') {
            return ApiResponse::error('nombre vacio',422);
        }
        // mas validaciones

        $resultado =  $this->modelo->actualizarPersona($id, $data['dni'],  $data['apellidos'], $data['nombres'], $data['direccion'], $data['telefono'], $data['correo'], $data['seccion'], $data['nombrePadre'], $data['apellidoPadre'], $data['celularPadre'], $data['correoPadre']);

        if($resultado){
            echo ApiResponse::success('success',false,200);
            return;
        }
        echo ApiResponse::error('error',true,500);
    }
    public function resetearClave($id) {
        $resultado =  $this->modelo->resetearClave($id);

        if($resultado){
            echo ApiResponse::success('success',false,200);
            return;
        }
        echo ApiResponse::error('error',true,500);
    }

    public function eliminarPersona($data) {
        $resultado =  $this->modelo->eliminarPersona($data);
        if($resultado){
            echo ApiResponse::success('success',false,201);
            return;
        }
        echo ApiResponse::error('error',true, 500);
    }
}
