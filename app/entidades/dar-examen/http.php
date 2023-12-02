<?php
require './ModeloDarExamen.php';
require './ControladorDarExamen.php';


$modelo = new ModeloDarExamen();
$controlador = new ControladorDarExamen($modelo);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Crear un nuevo usuario
    $data = json_decode(file_get_contents("php://input"), true);

    if ($data) {
        $controlador->crearExamen($data);
    }
} elseif ($_SERVER["REQUEST_METHOD"] === "GET") {
    
    // Obtener lista de examenes
    if (isset($_GET['respuestas']) && isset($_GET['examen']) && isset($_GET['alumno'])) {
        $data = $controlador->obtenerRespuestas($_GET['examen'], $_GET['alumno']);
        header("Content-Type: application/json");
        echo ApiResponse::success('success', false, 201, $data);
    }

    // Obtener lista de examenes
    if (isset($_GET['id_examen']) && isset($_GET['id_alumno'])) {
        $data = $controlador->obtenerResultados($_GET['id_examen'], $_GET['id_alumno']);
        header("Content-Type: application/json");
        echo ApiResponse::success('success', false, 201, $data);
    }
}
