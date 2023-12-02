<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Temarios | Sistema Realidad aumentada</title>
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

                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo">Nuevo temario</button>
                </div>
            </div>
            <div class="card-body  over-flow-auto">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Curso</th>
                            <th scope="col">Nivel</th>
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
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Temarios</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="register" autocomplete="off">
                            <div class="mb-3">
                                <label for="id_curso" class="form-label">Cursos</label>
                                <select class="form-select" id="id_curso" aria-label="Default select example">
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="titulo" class="form-label">Título:</label>
                                <input type="text" class="form-control" id="titulo" placeholder="Título" minlength="2" required>
                            </div>
                            <div class="mb-3">
                                <label for="descripcion" class="form-label">Descripción:</label>
                                <textarea  id="descripcion" cols="30" rows="2" class="form-control" placeholder="Descripción" minlength="2" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="url_apk" class="form-label">Cargar Apk</label>
                                <input type="file" class="form-control" id="url_apk">
                            </div>
                            <div class="mb-3">
                                <label for="descripcion_apk" class="form-label">Descripción:</label>
                                <textarea  id="descripcion_apk" cols="30" rows="2" class="form-control" placeholder="Descripción APK" minlength="2" required></textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label for="peso_apk" class="form-label">Peso Apk:</label>
                                <input type="number" class="form-control" value="0" id="peso_apk"  required>
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

        <!-- detalles del temario -->
        <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Temarios del curso</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="dataTemario">
                        
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="./assets/js/header.js"></script>
    <script src="./app/scripts/temarios.js"></script>
</body>

</html>