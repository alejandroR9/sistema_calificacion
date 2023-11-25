<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Realidad aumentada</title>
    <?php include './componentes/bootstrap.php' ?>
    <link rel="stylesheet" href="./assets/css/main.css">
</head>

<body>
    <?php include './componentes/header.php' ?>
    <main class="main">
        <?php if ($login->getTipoUsuario() == 3) { ?>

            <section class="grid-curso" id="curso">

            </section>
        <?php } ?>
    </main>
    <script src="./assets/js/header.js"></script>
    <?php if ($login->getTipoUsuario() == 3) { ?>
        <script src="./app/scripts/cursos-home.js"></script>
    <?php } ?>
</body>

</html>