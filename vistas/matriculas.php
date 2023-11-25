<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matrículas | Sistema Realidad aumentada</title>
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

                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo">Nueva matrícula</button>
                </div>
            </div>
            <div class="card-body  over-flow-auto">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Alumno</th>
                            <th scope="col">Periodo</th>
                            <th scope="col">Grado</th>
                            <th scope="col">fecha</th>
                            <th scope="col">Pago</th>
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
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Matrículas</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="register" autocomplete="off">
                            <div class="row">
                                <div class="mb-3 col-4">
                                    <label for="id_alumno" class="form-label">Alumnos</label>
                                    <select class="form-select" id="id_alumno" aria-label="Default select example">
                                    </select>
                                </div>
                                <div class="mb-3 col-4">
                                    <label for="id_periodo_academico" class="form-label">Periodo</label>
                                    <select class="form-select" id="id_periodo_academico" aria-label="Default select example">
                                    </select>
                                </div>
                                <div class="mb-3 col-4">
                                    <label for="id_nivel" class="form-label">Grado académico</label>
                                    <select class="form-select" id="id_nivel" aria-label="Default select example">
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="monto_matricula" class="form-label">Precio de matrícula:</label>
                                <input type="number" class="form-control" id="monto_matricula" placeholder="Precio de matrícula" min="0" value="0" required>
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
    <script src="./app/scripts/matriculas.js" type="module"></script>
</body>

</html>