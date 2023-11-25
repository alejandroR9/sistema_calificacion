<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumnos | Sistema Realidad aumentada</title>
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

                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo">Nuevo alumno</button>
                </div>
            </div>
            <div class="card-body  over-flow-auto">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Nombres</th>
                            <th scope="col">DNI</th>
                            <th scope="col">direccion</th>
                            <th scope="col">telefono</th>
                            <th scope="col">correo</th>
                            <th scope="col">seccion</th>
                            <th scope="col">fecha_de_creacion</th>
                            <th scope="col">estado</th>
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
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Mantenimiento de alumnos</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="register" autocomplete="off">
                            <div class="row">
                                <div class="mb-3 col-4">
                                    <label for="nombre" class="form-label">Nombres:</label>
                                    <input type="text" class="form-control" id="nombre" placeholder="Nombres" minlength="2" required>
                                </div>
                                <div class="mb-3 col-4">
                                    <label for="apellidos" class="form-label">Apellidos:</label>
                                    <input type="text" class="form-control" id="apellidos" placeholder="Apellidos" minlength="5" required>
                                </div>
                                <div class="mb-3 col-4">
                                    <label for="correo" class="form-label">Correo:</label>
                                    <input type="email" class="form-control" id="correo" placeholder="Correo electrónico">
                                </div>
                                <div class="mb-3 col-4">
                                    <label for="password" class="form-label">Contraseña:</label>
                                    <input type="password" class="form-control" id="password" placeholder="contraseña">
                                </div>
                                <div class="mb-3 col-4">
                                    <label for="dni" class="form-label">Dni:</label>
                                    <input type="number" class="form-control" id="dni" placeholder="DNI" min="5000" required>
                                </div>
                                <div class="mb-3 col-4">
                                    <label for="direccion" class="form-label">Dirección:</label>
                                    <input type="text" class="form-control" id="direccion" placeholder="Direccion">
                                </div>
                                <div class="mb-3 col-4">
                                    <label for="telefono" class="form-label">Telefono:</label>
                                    <input type="text" class="form-control" id="telefono" placeholder="Telefono">
                                </div>
                                <div class="mb-3 col-4">
                                    <label for="seccion" class="form-label">Sección:</label>
                                    <select class="form-select" id="seccion" aria-label="Default select example">
                                        <option value="A">SECCION A</option>
                                        <option value="B">SECCION B</option>
                                        <option value="C">SECCION C</option>
                                        <option value="D">SECCION D</option>
                                        <option value="E">SECCION E</option>
                                        <option value="F">SECCION F</option>
                                        <option value="G">SECCION G</option>
                                        <option value="H">SECCION H</option>
                                        <option value="I">SECCION I</option>
                                        <option value="UNICA">SECCION UNICA</option>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <div>
                                    <h2 class="fs-4">Informacion de padres o apoderados</h2>

                                    <div class="row">
                                        <div class="mb-3 col-md-6">
                                            <label for="nombre_padre" class="form-label">Nombre:</label>
                                            <input type="text" class="form-control" id="nombre_padre" placeholder="Nombre de padre o apoderado">
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="apellido_padre" class="form-label">Apellidos:</label>
                                            <input type="text" class="form-control" id="apellido_padre" placeholder="Apellido de padre o apoderado">
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="celular_padre" class="form-label">Celular:</label>
                                            <input type="text" class="form-control" id="celular_padre" placeholder="Celular">
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="correo_padre" class="form-label">Correo:</label>
                                            <input type="email" class="form-control" id="correo_padre" placeholder="Celular">
                                        </div>
                                    </div>
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
    <script src="./app/scripts/alumnos.js"></script>
</body>

</html>