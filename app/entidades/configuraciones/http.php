<?php
require './ModelConfiguarciones.php';
require './ControladorConfiguraciones.php';


$modelo = new ModelConfiguarciones();
$controlador = new ControladorConfiguraciones($modelo);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Crear un nuevo usuario
    $data = $_POST;
    // Verifica si se ha enviado una imagen
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $nombreArchivo = $_FILES['foto']['name'];
        $rutaArchivo = '../../../assets/imagenes/colegio/' . $nombreArchivo;
        $rutaGuardar = './assets/imagenes/colegio/' . $nombreArchivo;
        move_uploaded_file($_FILES['foto']['tmp_name'], $rutaArchivo);

        $data['foto'] = $rutaGuardar; // Agrega la información de la imagen a los datos
    } else {
        $data['foto'] = null; // No se envió una imagen
    }
    // Verifica si se ha enviado una imagen
    if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
        $nombreArchivo = $_FILES['logo']['name'];
        $rutaArchivo = '../../../assets/imagenes/colegio/' . $nombreArchivo;
        $rutaGuardar = './assets/imagenes/colegio/' . $nombreArchivo;
        move_uploaded_file($_FILES['logo']['tmp_name'], $rutaArchivo);

        $data['logo'] = $rutaGuardar; // Agrega la información de la imagen a los datos
    } else {
        $data['logo'] = null; // No se envió una imagen
    }

    if (isset($data['id'])) {
        $controlador->actualizarEmpresa($data, $data['id']);
    } else {
        $controlador->crearEmpresa($data);
    }
} elseif ($_SERVER["REQUEST_METHOD"] === "GET") {

    $data = $controlador->obtenerEmpresa();
    header("Content-Type: application/json");
    echo ApiResponse::success('success', false, 201, $data);
}
