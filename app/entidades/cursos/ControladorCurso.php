<?php
include '../../utilidades/ApiResponse.php';
class ControladorCurso
{
    private $modelo;

    public function __construct($modelo)
    {
        $this->modelo = $modelo;
    }

    /**
     * @param object Datos en formato de objeto
     */
    public function crearCurso($data)
    {
        if ($data['nombre'] <= 0) {
            echo  ApiResponse::error('nombre vacio', 422);
        }      

        
        $resultado =  $this->modelo->crearCurso($data['id_usuario'], $data['idnivel_academico'], $data['nombre'], $data['creditos'], $data['foto']);
            if ($resultado) {
                echo ApiResponse::success('success', false, 200);
            }
    }

    public function obtenerCursos($search = '')
    {
        return $this->modelo->obtenerCursos($search);
    }

    public function obtenerCursosAlumno($idNivel = 0, $idPeriodo=0,$idAlumno = 0)
    {
        return $this->modelo->obtenerCursosAlumno($idNivel, $idPeriodo,$idAlumno );
    }
    public function obtenerCursosAlumnoDocente($idNivel = 0, $idPeriodo=0,$idDocente = 0)
    {
        return $this->modelo->obtenerCursosAlumnoDocente($idNivel, $idPeriodo,$idDocente );
    }

    public function obtenerCurso($data)
    {
        return $this->modelo->obtenerCurso($data);
    }

    public function actualizarCurso($data, $id)
    {
        if ($data['nombre'] =='') {
            echo  ApiResponse::error('nombre vacio', 422);
        }


        $resultado =  $this->modelo->actualizarCurso($id, $data['idnivel_academico'], $data['nombre'], $data['creditos']);

        if ($resultado) {
            echo ApiResponse::success('success', false, 200);
            return;
        }
        echo ApiResponse::error('error', true, 500);
    }

    public function eliminarCurso($data)
    {
        $resultado =  $this->modelo->eliminarCurso($data);
        if ($resultado) {
            echo ApiResponse::success('success', false, 201);
            return;
        }
        echo ApiResponse::error('error', true, 500);
    }
}
