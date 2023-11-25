<?php
include '../../utilidades/ApiResponse.php';
class ControladorMatricula
{
    private $modelo;

    public function __construct($modelo)
    {
        $this->modelo = $modelo;
    }

    /**
     * @param object Datos en formato de objeto
     */
    public function crearMatricula($data)
    {
        if ($data['id_alumno'] <= 0) {
            echo  ApiResponse::error('id_alumno vacio', 422);
            return;
        }
        if ($data['id_usuario'] <= 0) {
            echo  ApiResponse::error('id_usuario vacio', 422);
            return;
        }
        if ($data['id_periodo_academico'] <= 0) {
            echo  ApiResponse::error('id_periodo_academico vacio', 422);
            return;
        }
        if ($data['id_nivel'] <= 0) {
            echo  ApiResponse::error('id_nivel vacio', 422);
            return;
        }

        $resultado =  $this->modelo->crearMatricula($data['id_alumno'], $data['id_usuario'], $data['id_periodo_academico'], $data['id_nivel'], $data['monto_matricula']);
        if ($resultado) {
            echo ApiResponse::success('success', false, 200);
        }
        die();
    }

    public function obtenerMatriculas($search = '')
    {
        return $this->modelo->obtenerMatriculas($search);
    }
}
