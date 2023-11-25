<?php
require './ModeloPeriodo.php';
require './ControladorPeriodo.php';


$modelo = new ModeloPeriodo();
$controlador = new ControladorPeriodo($modelo);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Crear un nuevo usuario
    $data = json_decode(file_get_contents("php://input"), true);

    if ($data) {
        $controlador->crearPeriodo($data);
    }
} elseif ($_SERVER["REQUEST_METHOD"] === "GET") {

    if(isset($_GET['get'])) {
        // Obtener lista de usuarios
        $usuarios = $controlador->obtenerPeriodo($_GET['get']);
        header("Content-Type: application/json");
        echo ApiResponse::success('success', false, 201, $usuarios);
    } else {
        // Obtener lista de usuarios
        $usuarios = $controlador->obtenerPeriodos($_GET['search']);
        header("Content-Type: application/json");
        echo ApiResponse::success('success', false, 201, $usuarios);

    }
} elseif ($_SERVER["REQUEST_METHOD"] === "PUT") {
    // Actualizar un usuario
    $data = json_decode(file_get_contents("php://input"), true);

    if ($data) {
        $controlador->actualizarPeriodo($data, $_GET['id']);
    }
} else if ($_SERVER["REQUEST_METHOD"] === "DELETE") {
    if ($_GET['delete']) {
        $controlador->eliminarPeriodo($_GET['delete']);
    }
}
