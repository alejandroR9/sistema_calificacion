<?php
require './ModeloMatricula.php';
require './ControladorMatricula.php';


$modelo = new ModeloMatricula();
$controlador = new ControladorMatricula($modelo);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Crear un nuevo usuario
    $data = json_decode(file_get_contents("php://input"), true);

    if ($data) {
        $controlador->crearMatricula($data);
    }
} elseif ($_SERVER["REQUEST_METHOD"] === "GET") {
    // Obtener lista de usuarios
    $usuarios = $controlador->obtenerMatriculas($_GET['search']);
    header("Content-Type: application/json");
    echo ApiResponse::success('success', false, 201, $usuarios);
}
