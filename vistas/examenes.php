<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examenes | Sistema Realidad aumentada</title>
    <?php include './componentes/bootstrap.php' ?>
    <link rel="stylesheet" href="./assets/css/main.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>

<body>
    <?php include './componentes/header.php' ?>
    <main class="main">
        <div class="form-control">
            <h2 class="fs-3 my-3">Mis cursos</h2>
            <div class="card-header">
                <div class="mb-3 mt-2 flex-center">
                    <input type="search" class="form-control" id="search" placeholder="Buscar...">

                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo">Nuevo examen</button>
                </div>
            </div>
            <div class="card-body  over-flow-auto">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Curso</th>
                            <th scope="col">titulo</th>
                            <th scope="col">descripcion</th>
                            <th scope="col">tiempo</th>
                            <th scope="col">Expiracion</th>
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
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Crear examenes</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="register" autocomplete="off">
                            <div class="mb-3">
                                <label for="id_curso_docente" class="form-label">Cursos</label>
                                <select class="form-select" id="id_curso_docente" aria-label="Default select example">
                                </select>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-6">
                                    <label for="titulo" class="form-label">Título del examen:</label>
                                    <input type="text" class="form-control" id="titulo" placeholder="Título del examen" minlength="2" required>
                                </div>
                                <div class="mb-3 col-6">
                                    <label for="tiempo" class="form-label">Duración del examen:</label>
                                    <input type="number" class="form-control" id="tiempo" placeholder="Duración del examen" min="10" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="descripcion" class="form-label">Descripción del examen:</label>
                                <textarea class="form-control" id="descripcion" placeholder="Descripción del examen" minlength="2" required cols="30" rows="2"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="expiracion" class="form-label">Expiración:</label>
                               <input type="datetime-local" class="form-control" id="expiracion" required>
                            </div>
                            <!-- preguntas del examen -->
                            <div>
                                <h2 class="text-primary fs-4">Preguntas del examen</h2>
                                <button type="button" class="btn btn-success badge" id="agregar-pregunta">+ Añadir pregunta</button>
                                <div id="preguntas">
                                </div>

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
    <script src="./app/scripts/examenes.js" type="module"></script>
</body>

</html>