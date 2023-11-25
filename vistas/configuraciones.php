<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuraciones - Sistema Realidad aumentada</title>
    <?php include './componentes/bootstrap.php' ?>
    <link rel="stylesheet" href="./assets/css/main.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <?php include './componentes/header.php' ?>
    <main class="main main-home">
        <!-- <section class="slider">
            <img src="./assets/imagenes/slider.jpg" alt="" class="slider-home">
            <div class="slider-hero">
                <div class="slider-contenido">
                    <h1 class="slider-title">Colegio de prueba</h1>
                    <div class="slider-descripcion">
                        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Tempore debitis sint commodi aliquid incidunt aperiam, architecto doloremque deserunt praesentium impedit ex reprehenderit sequi iure fugit optio? Nam incidunt repellendus doloribus?
                    </div>
                </div>
            </div>
        </section> -->

        <div class="p-4">
        <div class="modal-body p-4">
            <form id="register" autocomplete="off" enctype="multipart/form-data">
                <div class="row">
                <div class="mb-3 col-md-4">
                    <label for="nombre" class="form-label">Razón social</label>
                    <input type="text" class="form-control" id="nombre" placeholder="Razón social de la IE" minlength="2" required>
                </div>
                <div class="mb-3 col-md-4">
                    <label for="direccion" class="form-label">Dirección</label>
                    <input type="text" class="form-control" id="direccion" placeholder="Dirección" minlength="2" >
                </div>
                <div class="mb-3 col-md-4">
                    <label for="celular" class="form-label">Celular</label>
                    <input type="text" class="form-control" id="celular" placeholder="Celular 000 000 000 / 000 000 000" minlength="2" >
                </div>
                <div class="mb-3 col-md-4">
                    <label for="foto" class="form-label">Banner</label>
                    <input type="file" class="form-control" id="foto">
                    <img   id="img-foto" class="rounded float-start mt-3" alt="">
                </div>
                <div class="mb-3 col-md-4">
                    <label for="logo" class="form-label">Logo</label>
                    <input type="file" class="form-control" id="logo" >
                    <img  style="max-width: 100px;" id="img-logo" class="rounded float-start mt-3" alt="">
                </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
        </div>
    </main>
    <script src="./assets/js/header.js"></script>
    <script src="./app/scripts/configuraciones.js"></script>
</body>

</html>