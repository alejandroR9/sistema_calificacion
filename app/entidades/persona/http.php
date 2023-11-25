<?php
require './ModeloPersona.php';
require './ControladorPersona.php';


$modelo = new ModeloPersona();
$controlador = new ControladorPersona($modelo);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Crear un nuevo usuario
    $data = json_decode(file_get_contents("php://input"), true);

    if ($data) {
        $controlador->crearPersona($data);
    }
} elseif ($_SERVER["REQUEST_METHOD"] === "GET") {

    if(isset($_GET['get'])) {
        // Obtener lista de usuarios
        $usuarios = $controlador->obtenerPersona($_GET['get']);
        header("Content-Type: application/json");
        echo ApiResponse::success('success', false, 201, $usuarios);
    } else if(isset($_GET['id_periodo']) && isset($_GET['id_nivel']) && isset($_GET['id_curso'])  && isset($_GET['id_docente'])) {
        // Obtener lista de usuarios
        $usuarios = $controlador->obtenerPersonaCursos($_GET['id_periodo'],$_GET['id_nivel'] ,$_GET['id_curso'],$_GET['id_docente']);
        header("Content-Type: application/json");
        echo ApiResponse::success('success', false, 201, $usuarios);
    } else {
        // Obtener lista de usuarios
        $usuarios = $controlador->obtenerPersonas($_GET['search'],$_GET['role']);
        header("Content-Type: application/json");
        echo ApiResponse::success('success', false, 201, $usuarios);

    }
} elseif ($_SERVER["REQUEST_METHOD"] === "PUT") {
    // Actualizar un usuario
    $data = json_decode(file_get_contents("php://input"), true);

    if(isset($_GET['id'])){
        if ($data) {
            $controlador->actualizarPersona($data, $_GET['id']);
        }
    } else if(isset($_GET['id_persona'])){
        $controlador->resetearClave($_GET['id_persona']);
    }
} else if ($_SERVER["REQUEST_METHOD"] === "DELETE") {
    if ($_GET['delete']) {
        $controlador->eliminarPersona($_GET['delete']);
    }
}
