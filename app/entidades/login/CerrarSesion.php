<?php

    include_once './SesionUsuario.php';

    $userSession = new SesionUsuario();
    $userSession->closeSession();
    header("location: ../../../");

?>