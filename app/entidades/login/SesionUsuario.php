<?php 

class SesionUsuario{
    public function __construct(){
        session_start();
     }
 
     public function setCurrentUser($user){
         $_SESSION['usuario'] = $user;
     }
     public function setTipoUsuario($tipo){
         $_SESSION['tipo'] = $tipo;
     }
 
     public function getCurrentUser(){
         return $_SESSION['usuario'];
     }
 
     public function closeSession(){
         session_unset();
         session_destroy();
     }
}