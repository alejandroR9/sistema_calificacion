<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cursos | Sistema Realidad aumentada</title>
    <?php include './componentes/bootstrap.php' ?>
    <link rel="stylesheet" href="./assets/css/main.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>

<body>
    <?php include './componentes/header.php' ?>
    <main class="main">
        <div class="form-control">
            <div class="card-header">
                <div class="mb-3 mt-2 flex-center">
                    <input type="search" class="form-control" id="search" placeholder="Buscar...">

                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo">Nuevo curso</button>
                </div>
            </div>
            <div class="card-body  over-flow-auto">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">foto</th>
                            <th scope="col">nombre</th>
                            <!-- <th scope="col">creditos</th> -->
                            <th scope="col" class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="dataBody">

                    </tbody>
                </table>
            </div>
        </div>

        <!-- registrar usuarios -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Cursos</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="register"  autocomplete="off" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Descripción del curso:</label>
                                <input type="text" class="form-control" id="nombre" placeholder="Descripción del curso" minlength="2" required>
                            </div>
                            <!-- <div class="mb-3" style="display: none;">
                                <label for="creditos" class="form-label">Creditos:</label>
                                <input type="number" class="form-control" id="creditos" placeholder="Creditos" required>
                            </div> -->
                            <div class="mb-3">
                                <label for="idnivel_academico" class="form-label">Niveles academicos</label>
                                <select class="form-select" id="idnivel_academico" aria-label="Default select example">
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="foto" class="form-label">Foto o poster</label>
                                <input type="file" class="form-control" id="foto">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="./assets/js/header.js"></script>
    <script src="./app/scripts/cursos.js"></script>
</body>

</html>