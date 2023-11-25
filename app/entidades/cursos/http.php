<?php
require './ModeloCurso.php';
require './ControladorCurso.php';


$modelo = new ModeloCurso();
$controlador = new ControladorCurso($modelo);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Crear un nuevo usuario
    $data = $_POST;
    // Verifica si se ha enviado una imagen
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $nombreArchivo = $_FILES['foto']['name'];
        $rutaArchivo = '../../../assets/imagenes/cursos/' . $nombreArchivo;
        $rutaGuardar = './assets/imagenes/cursos/' . $nombreArchivo;
        move_uploaded_file($_FILES['foto']['tmp_name'], $rutaArchivo);

        $data['foto'] = $rutaGuardar; // Agrega la información de la imagen a los datos
    } else {
        $data['foto'] = null; // No se envió una imagen
    }

    if ($data) {
        $controlador->crearCurso($data);
    }
} elseif ($_SERVER["REQUEST_METHOD"] === "GET") {

    if (isset($_GET['get'])) {

        $data = $controlador->obtenerCurso($_GET['get']);
        header("Content-Type: application/json");
        echo ApiResponse::success('success', false, 201, $data);
    } else if (isset($_GET['periodo_id']) && isset($_GET['nivel_id']) && isset($_GET['alumno_id'])) {
        $data = $controlador->obtenerCursosAlumno($_GET['nivel_id'],$_GET['periodo_id'],$_GET['alumno_id']);
        header("Content-Type: application/json");
        echo ApiResponse::success('success', false, 201, $data);
    } else if (isset($_GET['periodo_id']) && isset($_GET['nivel_id']) && isset($_GET['docente_id'])) {
        $data = $controlador->obtenerCursosAlumnoDocente($_GET['nivel_id'],$_GET['periodo_id'],$_GET['docente_id']);
        header("Content-Type: application/json");
        echo ApiResponse::success('success', false, 201, $data);
    } else {

        $data = $controlador->obtenerCursos($_GET['search']);
        header("Content-Type: application/json");
        echo ApiResponse::success('success', false, 201, $data);
    }
} elseif ($_SERVER["REQUEST_METHOD"] === "PUT") {

    $data = json_decode(file_get_contents("php://input"), true);

    if ($data) {
        $controlador->actualizarCurso($data, $_GET['id']);
    }
} else if ($_SERVER["REQUEST_METHOD"] === "DELETE") {
    if ($_GET['delete']) {
        $controlador->eliminarCurso($_GET['delete']);
    }
}
