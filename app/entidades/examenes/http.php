<?php
require './ModeloExamen.php';
require './ControladorExamen.php';


$modelo = new ModeloExamen();
$controlador = new ControladorExamen($modelo);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Crear un nuevo usuario
    $data = json_decode(file_get_contents("php://input"), true);

    if ($data) {
        $controlador->crearExamen($data);
    }
} elseif ($_SERVER["REQUEST_METHOD"] === "GET") {
    // Obtener lista de examenes
    if(isset($_GET['search']) && isset($_GET['id_docente'])) {
        $data = $controlador->obtenerExamenes($_GET['search'],$_GET['id_docente']);
        header("Content-Type: application/json");
        echo ApiResponse::success('success', false, 201, $data);
    }
    // Obtener lista de examenes del alumno
    if(isset($_GET['id_alumno'])) {
        $data = $controlador->obtenerExamenesAlumnos($_GET['id_alumno']);
        header("Content-Type: application/json");
        echo ApiResponse::success('success', false, 201, $data);
    }
    // Obtener un examen en especifico
    if(isset($_GET['examen'])) {
        $data = $controlador->obtenerExamen($_GET['examen']);
        header("Content-Type: application/json");
        echo ApiResponse::success('success', false, 201, $data);
    }
} 
