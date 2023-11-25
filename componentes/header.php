<?php
require_once './app/utilidades/ObtenerFechas.php';
?>
<header class="main-header">
    <div class="header-info">
        <button class="ver-menu"><svg width="24px" height="24px" stroke-width="1.5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" color="currentColor">
                <path d="M3 5H21" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                <path d="M3 12H21" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                <path d="M3 19H21" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
        </button>
        <h1 class="header-titulo">Sistema de realidad aumentada</h1>
        <div class="header-fecha">
            <?php echo ObtenerFechas::fechaParaHeader() ?>
        </div>
        <div class="header-info-user">
            <h2 class="header-user-name"><?php echo $login->getUsuario() ?></h2>
            <img src="./assets/imagenes/user.png" class="header-icono" alt="Icono de usuario">
            <a href="./app/entidades/login/CerrarSesion.php" class="boton-salir">
                <img src="./assets/imagenes/salir.png" alt="icono de salir">
            </a>

            <input type="hidden" id="login" value="<?php echo $login->getLogin() ?>">
            <input type="hidden" id="tipo" value="<?php echo $login->getTipoUsuario() ?>">
            <input type="hidden" id="periodo" value="<?php echo $login->getPeriodo() ?>">
            <input type="hidden" id="nivel" value="<?php echo $login->getNivel() ?>">
        </div>
    </div>
    <div class="nav-container">
        <nav class="main-nav">
            <ul class="menu" id="menu">
                <li class="menu-item">
                    <a href="./" class="menu-link">Inicio</a>
                </li>
                <?php
                if ($login->getTipoUsuario() == 1) {
                ?>
                    <li class="menu-item">
                        <span class="menu-link dropdown">Mantenimientos</span>
                        <ul class="menu sub-menu">
                            <li class="menu-item menu-sub-item">
                                <a href="./usuarios.php" class="menu-link menu-sub-link">Usuarios</a>
                            </li>
                            <li class="menu-item menu-sub-item">
                                <a href="./alumnos.php" class="menu-link menu-sub-link">Alumnos</a>
                            </li>
                            <li class="menu-item menu-sub-item">
                                <a href="./docentes.php" class="menu-link menu-sub-link">Docentes</a>
                            </li>
                            <li class="menu-item menu-sub-item">
                                <a href="./niveles.php" class="menu-link menu-sub-link">Grados académicos</a>
                            </li>
                            <li class="menu-item menu-sub-item">
                                <a href="./periodos.php" class="menu-link menu-sub-link">Años académicos</a>
                            </li>
                            <li class="menu-item menu-sub-item">
                                <a href="./matriculas.php" class="menu-link menu-sub-link">Matriculas</a>
                            </li>
                        </ul>
                    </li>
                <?php
                }
                ?>
                <?php
                if ($login->getTipoUsuario() == 2 || $login->getTipoUsuario() == 1) {
                ?>
                    <li class="menu-item">
                        <span class="menu-link dropdown">Cursos</span>
                        <ul class="menu sub-menu">
                            <li class="menu-item menu-sub-item">
                                <?php
                                if ($login->getTipoUsuario() == 1) {
                                ?>
                                    <a href="./cursos.php" class="menu-link menu-sub-link">Nuevos cursos</a>
                                    <a href="./cursos-docente.php" class="menu-link menu-sub-link">Asignar cursos</a>

                                <?php
                                }
                                ?>
                                <a href="./temarios.php" class="menu-link menu-sub-link">Temarios</a>
                                <!-- <a href="./mis-cursos.php" class="menu-link menu-sub-link">Mis cursos</a> -->
                            </li>
                        </ul>
                    </li>

                <?php
                }
                ?>
                <li class="menu-item">
                    <span class="menu-link dropdown">Examenes</span>
                    <ul class="menu sub-menu">
                        <li class="menu-item menu-sub-item">
                            <?php
                            if ($login->getTipoUsuario() == 2 || $login->getTipoUsuario() == 1) {
                            ?>
                                <a href="./examenes.php" class="menu-link menu-sub-link">Crear examen</a>
                            <?php
                            }
                            ?>
                            <?php
                            if ($login->getTipoUsuario() == 3) {
                            ?>
                                <a href="./mis-examenes.php" class="menu-link menu-sub-link">Examenes</a>
                            <?php
                            }
                            ?>
                        </li>
                        <li class="menu-item menu-sub-item">
                            <?php
                            if ($login->getTipoUsuario() == 2 || $login->getTipoUsuario() == 1) {
                            ?>
                                <a href="./record.php" class="menu-link menu-sub-link">Grafico de avance académico</a>
                            <?php
                            }
                            ?>
                        </li>
                    </ul>
                </li>
                <li class="menu-item">
                    <a href="./configuraciones.php" class="menu-link menu-sub-link">Configuraciones</a>
                </li>
            </ul>
        </nav>
    </div>
</header>