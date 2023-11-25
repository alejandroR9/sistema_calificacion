<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de sesión</title>
    <link rel="stylesheet" href="./assets/css/main.css">
    <?php include './componentes/bootstrap.php' ?>
</head>

<body class="main-login">
    <div class="login">
        <form autocomplete="off" method="POST">
            <div class="login-img">
                <img src="./assets/imagenes/login.png" alt="">
            </div>
            <h1 class="login-title text-center">Iniciar sesión</h1>
            <select class="form-select fs-5 form-select-lg mb-3" name="tipo_usuario" aria-label="Large select example">
                <option selected>TIPO DE USUARIO</option>
                <option value="1">ADMINISTRADOR</option>
                <option value="2">DOCENTE</option>
                <option value="3">ALUMNO</option>
            </select>
            <label for="usuario" class="block w-full">
                <span class="block input-title">Usuario</span>
                <input type="text" id="usuario" name="usuario" class="login-input w-full" placeholder="Ingresa tu contraseña" required>
            </label>
            <label for="password" class="block w-full mb-1">
                <span class="block input-title">Contraseña</span>
                <input type="password" id="password" name="password" class="login-input w-full" placeholder="Ingresa tu contraseña" required>
            </label>
            <button class="button-primary w-full mt-1">
                Iniciar sesión
            </button>

            <?php
            if (isset($errorLogin)) {
                echo $errorLogin;
            }
            ?>
        </form>
    </div>
</body>

</html>