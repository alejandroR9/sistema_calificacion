<?php
require './ModeloUsuario.php';
require './ControladorUsuario.php';


$modelo = new ModeloUsuario();
$controlador = new ControladorUsuario($modelo);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Crear un nuevo usuario
    $data = json_decode(file_get_contents("php://input"), true);

    if ($data) {
        $controlador->crearUsuario($data);
    }
} elseif ($_SERVER["REQUEST_METHOD"] === "GET") {

    if(isset($_GET['get'])) {
        // Obtener lista de usuarios
        $usuarios = $controlador->obtenerUsuario($_GET['get']);
        header("Content-Type: application/json");
        echo ApiResponse::success('success', false, 201, $usuarios);
    } else {
        // Obtener lista de usuarios
        $usuarios = $controlador->obtenerUsuarios($_GET['search']);
        header("Content-Type: application/json");
        echo ApiResponse::success('success', false, 201, $usuarios);

    }
} elseif ($_SERVER["REQUEST_METHOD"] === "PUT") {
    // Actualizar un usuario
    $data = json_decode(file_get_contents("php://input"), true);

    if ($data) {
        $controlador->actualizarUsuario($data, $_GET['id']);
    }
} else if ($_SERVER["REQUEST_METHOD"] === "DELETE") {
    if ($_GET['delete']) {
        $controlador->eliminarUsuario($_GET['delete']);
    }
}
