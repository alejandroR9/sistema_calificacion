<?php
require './ModeloNotas.php';
require './ControladorNotas.php';


$modelo = new ModeloNotas();
$controlador = new ControladorNotas($modelo);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Crear un nuevo usuario
    $data = json_decode(file_get_contents("php://input"), true);

    if ($data) {
        $controlador->crearNotas($data);
    }
} elseif ($_SERVER["REQUEST_METHOD"] === "GET") {

    // Obtener lista de notas
    $notas = $controlador->obtenerNotas($_GET['search'],$_GET['id_periodo'],$_GET['id_nivel'],$_GET['idcurso'],$_GET['idalumno']);
    header("Content-Type: application/json");
    echo ApiResponse::success('success', false, 201, $notas);
} else if ($_SERVER["REQUEST_METHOD"] === "DELETE") {
    if ($_GET['delete']) {
        $controlador->eliminarNotas($_GET['delete']);
    }
}
