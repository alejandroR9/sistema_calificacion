<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grafico de avance académico | Sistema Realidad aumentada</title>
    <?php include './componentes/bootstrap.php' ?>
    <link rel="stylesheet" href="./assets/css/main.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="./assets/js/chart.js"></script>
</head>

<body>
    <?php include './componentes/header.php' ?>
    <main class="main">
        <h3 class="mb-3">Cafilicación de alumnos</h3>
        <div class="form-control">
            <div class="card-header">
                <form id="register" autocomplete="off">
                    <div class="mb-3 mt-2" style="display: flex; align-items: end;gap:1rem;flex-wrap: wrap;">
                        <div style="min-width: 320px;">
                            <label for="descripcion" class="form-label">Descripción de la nota</label>
                            <input type="text" class="form-control" id="descripcion" placeholder="Descripción de la nota">
                        </div>
                        <div>
                            <label for="nota" class="form-label">Ingresa la nota</label>
                            <input type="number" class="form-control" min="0" id="nota" placeholder="Ingresa la nota del alumno">
                        </div>
                        <div>
                            <label for="id_curso" class="form-label">Cursos</label>
                            <select class="form-select" id="id_curso" aria-label="Default select example">
                            </select>
                        </div>
                        <div>
                            <label for="id_curso_alumno" class="form-label">Alumnos</label>
                            <select class="form-select" id="id_curso_alumno" aria-label="Default select example">
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo">Nueva calificación</button>
                    </div>
                </form>
            </div>
            <div class="card-body  over-flow-auto">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Descripción</th>
                            <th scope="col">Nota</th>
                            <th scope="col">Fecha</th>
                            <!-- <th scope="col" class="text-end">Acciones</th> -->
                        </tr>
                    </thead>
                    <tbody id="dataBody">

                    </tbody>
                </table>
            </div>
        </div>
        <!-- aqui vamos a crear el chart -->
        <div id="contenedor-canvas">
        <canvas id="grafico"></canvas>
        </div>
    </main>

    <script src="./assets/js/header.js"></script>
    <script src="./app/scripts/record.js" type="module"></script>
    <script src="./app/scripts/graficos.js"></script>
</body>

</html>