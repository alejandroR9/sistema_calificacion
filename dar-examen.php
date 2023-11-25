
<?php
include_once './app/entidades/login/Login.php';
include_once './app/entidades/login/SesionUsuario.php';
$login = new Login();
$user = new SesionUsuario();

if (isset($_SESSION['usuario'])) {
    if ($_SESSION['tipo'] == 1) {
        $login->setUser($user->getCurrentUser());
        if ($login != false) include_once "./vistas/dar-examen.php";
    } else {
        $login->setUserAlumnosDocentes($user->getCurrentUser());
        if ($login != false) include_once "./vistas/dar-examen.php";
    }
} else if (isset($_POST['usuario']) && isset($_POST['password'])  && isset($_POST['tipo_usuario'])) {

    $usuario = $_POST['usuario'];
    $password = $_POST['password'];
    $tipoUsuario = $_POST['tipo_usuario'];

    //ACCESO PARA ADMINISTRADORES
    if ($tipoUsuario == 1) {
        if ($login->login($usuario, $password)) {

            $user->setCurrentUser($usuario);
            $user->setTipoUsuario($tipoUsuario);
            $login->setUser($usuario);

            if ($login != false) {
                include_once "./vistas/dar-examen.php";
            }
        } else {
            $errorLogin = '<div class="alert alert-danger mt-3 alert-dismissible fade show" role="alert">
                            <strong>Usuario y/o contraseña incorrecta</strong> 
                            <p>Por favor ingresa una credencial válida.</p>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
            include_once "./login.php";
        }

        //ACCESO PARA ALUMNOS Y DOCENTES
    } else {
        if ($login->loginAlumnosDocentes($usuario, $password)) {

            $user->setCurrentUser($usuario);
            $user->setTipoUsuario($tipoUsuario);
            $login->setUserAlumnosDocentes($usuario);

            if ($login != false) include_once "./vistas/dar-examen.php";
        } else {
            $errorLogin = '<div class="alert alert-danger mt-3 alert-dismissible fade show" role="alert">
                            <strong>Usuario y/o contraseña incorrecta</strong> 
                            <p>Por favor ingresa una credencial válida.</p>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
            include_once "./login.php";
        }
    }
} else {
    include_once "./login.php";
}
