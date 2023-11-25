<?php
include '../../utilidades/ApiResponse.php';
class ControladorConfiguraciones
{
    private $modelo;

    public function __construct($modelo)
    {
        $this->modelo = $modelo;
    }

    /**
     * @param object Datos en formato de objeto
     */
    public function crearEmpresa($data)
    {
        if ($data['nombre'] <= 0) {
            echo  ApiResponse::error('nombre vacio', 422);
            return;
        }


        $resultado =  $this->modelo->crearEmpresa($data['nombre'], $data['direccion'], $data['celular'], $data['logo'], $data['foto']);
        if ($resultado) {
            echo ApiResponse::success('success', false, 200);
        }
    }

    public function obtenerEmpresa()
    {
        return $this->modelo->obtenerEmpresa();
    }



    public function actualizarEmpresa($data, $id)
    {
        if ($data['nombre'] == '') {
            echo  ApiResponse::error('nombre vacio', 422);
            return;
        }


        $resultado =  $this->modelo->actualizarEmpresa($data['id'], $data['nombre'], $data['direccion'], $data['celular'], $data['logo'], $data['foto']);

        if ($resultado) {
            echo ApiResponse::success('success', false, 200);
            return;
        }
        echo ApiResponse::error('error', true, 500);
    }
}
