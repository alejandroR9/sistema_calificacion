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
                <div class="mb-3 mt-2" style="display: flex; align-items: end;gap:1rem;flex-wrap: wrap;">
                    <div>
                        <label for="id_curso" class="form-label">Cursos</label>
                        <select class="form-select" id="id_curso" aria-label="Default select example">
                        </select>
                    </div>
                    <div>
                        <label for="id_alumnos" class="form-label">Buscar</label>
                        <div class="position-relative">
                            <input type="search" id="search" placeholder="Buscar alumnos por nombre">
                            <div id="id_alumnos" class="content-search"  style="display: none;"></div>
                        </div>
                    </div>
                    
                    <button type="button" class="btn btn-success" id="consultation">Consultar notas</button>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#crearNotas" data-bs-whatever="@mdo">Nueva calificación</button>
                </div>
            </div>
            <h4  class="card-header py-3" id="promedio">
                
            </h4>
        </div>
        <div class="card-body  over-flow-auto">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">Descripción</th>
                        <th scope="col">Nota</th>
                        <th scope="col">Fecha</th>
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
    <!-- detalles del temario -->
    <div class="modal fade" id="crearNotas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Asignar notas</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="px-4">
                    <label for="descripcion" class="form-label">Descripción de la nota</label>
                    <input type="text" class="form-control" id="descripcion" placeholder="Descripción de la nota">
                </div>
                <div class="modal-body" id="dataAlumnos">

                </div>
                <div class="p-4">
                    <button class="btn btn-primary" id="registrar">Registrar notas</button>
                </div>
            </div>
        </div>
    </div>

    <script src="./assets/js/header.js"></script>
    <script src="./app/scripts/record.js" type="module"></script>
    <script src="./app/scripts/graficos.js"></script>
</body>

</html>