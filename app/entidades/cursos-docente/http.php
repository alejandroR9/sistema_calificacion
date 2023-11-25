<?php
require './ModeloCursosDocente.php';
require './ControladorCursosDocente.php';


$modelo = new ModeloCursosDocente();
$controlador = new ControladorCursosDocente($modelo);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Crear un nuevo usuario
    $data = json_decode(file_get_contents("php://input"), true);

    if ($data) {
        $controlador->crearCursosDocente($data);
    }
} elseif ($_SERVER["REQUEST_METHOD"] === "GET") {

    if(isset($_GET['get'])) {
        $data = $controlador->obtenerCursosDocente($_GET['get']);
        header("Content-Type: application/json");
        echo ApiResponse::success('success', false, 201, $data);
    } else if(isset($_GET['id_docente'])) {
        $data = $controlador->obtenerCursosDelDocente($_GET['id_docente']);
        header("Content-Type: application/json");
        echo ApiResponse::success('success', false, 201, $data);
    } else {
        // Obtener lista de datos
        $data = $controlador->obtenerCursosDocentes($_GET['search']);
        header("Content-Type: application/json");
        echo ApiResponse::success('success', false, 201, $data);

    }
} else if ($_SERVER["REQUEST_METHOD"] === "DELETE") {
    if ($_GET['delete']) {
        $controlador->eliminarCursosDocente($_GET['delete']);
    }
}
