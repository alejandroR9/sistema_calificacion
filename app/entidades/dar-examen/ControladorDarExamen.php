<?php
include '../../utilidades/ApiResponse.php';
class ControladorDarExamen
{
    private $modelo;

    public function __construct($modelo)
    {
        $this->modelo = $modelo;
    }

    /**
     * @param object Datos en formato de objeto
     */
    public function crearExamen($data)
    {
        if ($data['id_examen'] <= 0) {
            echo  ApiResponse::error('id_examen vacio', 422);
            return;
        }
        if ($data['id_alumno'] == '') {
            echo  ApiResponse::error('id_alumno vacio', 422);
            return;
        }
        if ($data['tiempo'] == '') {
            echo  ApiResponse::error('tiempo vacio', 422);
            return;
        }
        if (count($data['respuestas']) <= 0) {
            echo  ApiResponse::error('respuestas vacio', 422);
            return;
        }

        $resultado =  $this->modelo->crearExamen($data['id_examen'], $data['id_alumno'], $data['tiempo'], $data['respuestas']);
        if ($resultado) {
            echo ApiResponse::success('success', false, 200);
        }else{
            echo ApiResponse::error('error', false, 500);

        }
    }

    public function obtenerResultados($idExamen, $idAlumno)
    {
        return $this->modelo->obtenerResultados($idExamen, $idAlumno);
    }
}
