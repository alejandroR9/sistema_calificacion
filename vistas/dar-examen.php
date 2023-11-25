<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dar examen | Sistema Realidad aumentada</title>
    <?php include './componentes/bootstrap.php' ?>
    <link rel="stylesheet" href="./assets/css/main.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>

<body>
    <?php include './componentes/header.php' ?>
    <input type="hidden" id="key" value="<?php echo $_GET['examen'] ?>">
    <main class="main">

    
        <div class="card p-3">
            <div id="header-content">

            </div>
            <div id="preguntas" class="card"></div>
            <div class="text-end mt-3">
            <button class="btn btn-primary btn-sm" style="display: none;" id="siguiente">Empezar</button>
            <button class="btn btn-primary btn-sm" style="display: none;" id="enviar">Enviar examen</button>
            </div>
        </div>

    </main>

    <script src="./assets/js/header.js"></script>
    <script src="./app/scripts/dar-examen.js"></script>
</body>

</html>