<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Temario del curso de <?php echo $_GET['nombre'] ?></title>
    <?php include './componentes/bootstrap.php' ?>
    <link rel="stylesheet" href="./assets/css/main.css">
</head>

<body>
    <?php include './componentes/header.php' ?>
    <input id="idcurso" type="hidden" value="<?php echo $_GET['key'] ?>">
    <main class="main">
        <section>
            <h1 class="text-primary mb-3"><?php echo $_GET['nombre'] ?></h1>
        </section>
        
    <div class="accordion" id="dataTemario">
    </div>
    
    </main>
    </div>
    <script src="./assets/js/header.js"></script>
    <script src="./app/scripts/contenido.js"></script>
</body>

</html>