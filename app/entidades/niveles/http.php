<?php
require './ModeloNivel.php';
require './ControladorNivel.php';


$modelo = new ModeloNivel();
$controlador = new ControladorNivel($modelo);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Crear un nuevo usuario
    $data = json_decode(file_get_contents("php://input"), true);

    if ($data) {
        $controlador->crearNivel($data);
    }
} elseif ($_SERVER["REQUEST_METHOD"] === "GET") {

    if(isset($_GET['get'])) {
        // Obtener lista de usuarios
        $usuarios = $controlador->obtenerNivel($_GET['get']);
        header("Content-Type: application/json");
        echo ApiResponse::success('success', false, 201, $usuarios);
    } else {
        // Obtener lista de usuarios
        $usuarios = $controlador->obtenerNiveles($_GET['search']);
        header("Content-Type: application/json");
        echo ApiResponse::success('success', false, 201, $usuarios);

    }
} elseif ($_SERVER["REQUEST_METHOD"] === "PUT") {
    // Actualizar un usuario
    $data = json_decode(file_get_contents("php://input"), true);

    if ($data) {
        $controlador->actualizarNivel($data, $_GET['id']);
    }
} else if ($_SERVER["REQUEST_METHOD"] === "DELETE") {
    if ($_GET['delete']) {
        $controlador->eliminarNivel($_GET['delete']);
    }
}
