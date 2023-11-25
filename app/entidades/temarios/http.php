<?php
require './ModeloTemario.php';
require './ControladorTemario.php';


$modelo = new ModeloTemario();
$controlador = new ControladorTemario($modelo);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = $_POST;
    ini_set('upload_max_filesize','2000M');
    ini_set('post_max_size','2000M');
    ini_set('memory_limit','2000M');
    // Verifica si se ha enviado una imagen
    if (isset($_FILES['url_apk']) && $_FILES['url_apk']['error'] === UPLOAD_ERR_OK) {
        $nombreArchivo = $_FILES['url_apk']['name'];
        $rutaArchivo = '../../../assets/apk/' . $nombreArchivo;
        $rutaGuardar = './assets/apk/' . $nombreArchivo;
        move_uploaded_file($_FILES['url_apk']['tmp_name'], $rutaArchivo);

        $data['url_apk'] = $rutaGuardar; // Agrega la información de la imagen a los datos
    } else {
        $data['url_apk'] = null; // No se envió una imagen
    }
    if ($data) {
        $controlador->crearTemario($data);
    }
} else if ($_SERVER["REQUEST_METHOD"] === "GET") {

    if (isset($_GET['get'])) {
        // Obtener lista de usuarios
        $data = $controlador->obtenerTemario($_GET['get']);
        header("Content-Type: application/json");
        echo ApiResponse::success('success', false, 201, $data);
    } else {
        // Obtener lista de usuarios
        $data = $controlador->obtenerTemarios($_GET['search']);
        header("Content-Type: application/json");
        echo ApiResponse::success('success', false, 201, $data);
    }
} else if ($_SERVER["REQUEST_METHOD"] === "PUT") {
    // Actualizar un usuario
    $data = json_decode(file_get_contents("php://input"), true);

    if ($data) {
        $controlador->actualizarTemario($data, $_GET['id']);
    }
} else if ($_SERVER["REQUEST_METHOD"] === "DELETE") {
    if ($_GET['delete']) {
        $controlador->eliminarTemario($_GET['delete']);
    }
}
