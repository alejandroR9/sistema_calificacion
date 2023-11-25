<?php
require_once './app/db/Conexion.php';

class Login
{

    private string $nombre;
    private string $usuario;
    private string $tipoUsuario;
    private int $id;
    private int $periodo;
    private int $nivel;
    /**
     * Metodo para inicir sesión
     * @param string $usuario Nombre del usuario
     * @param string $password Contraseña del usuario
     */
    public function login(string $usuario, string $password): bool
    {
        $db = Conexion::obtenerConexion();
        
        $md5pass = md5($password);
        $sql = "SELECT * FROM usuarios WHERE usuario = :usuario AND password = :password AND estado = 1";
        $query = $db->prepare($sql);
        $query->execute(['usuario' => $usuario, 'password' => $md5pass]);
        if ($query->rowCount()) {
            return true;
        } else {
            return false;
        }
    }
     /**
     * Metodo para traer los datos del usuario
     * @param string $usuario Nombre del usuario
     */
    public function setUser($usuario)
    {
        $db = Conexion::obtenerConexion();
        $sql = "SELECT * FROM usuarios WHERE usuario = :usuario";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
        $stmt->execute();
        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->getPeriodoAcademico();
        if (!empty($resultado)) {
            $this->nombre = $resultado[0]['nombre'];
            $this->usuario = $resultado[0]['usuario'];
            $this->tipoUsuario = $resultado[0]['id_rol'];
            $this->id = $resultado[0]['id'];
            $this->getNivelAcademico($resultado[0]['id']);
            
        } else {
            return false;
        }
    }



    /**
     * Metodo para inicir sesión como docente o alumno
     * @param string $usuario Nombre del usuario
     * @param string $password Contraseña del usuario
     */
    public function loginAlumnosDocentes(string $usuario, string $password): bool
    {
        $db = Conexion::obtenerConexion();
        
        $md5pass = md5($password);
        $sql = "SELECT * FROM persona WHERE dni = :dni AND password = :password AND estado = 1";
        $query = $db->prepare($sql);
        $query->execute(['dni' => $usuario, 'password' => $md5pass]);
        if ($query->rowCount()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Metodo para traer los datos del alumno o docente
     * @param string $dni Nombre del usuario
     */
    public function setUserAlumnosDocentes($dni)
    {
        $db = Conexion::obtenerConexion();
        $sql = "SELECT * FROM persona WHERE dni = :dni";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':dni', $dni, PDO::PARAM_STR);
        $stmt->execute();
        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->getPeriodoAcademico();
        if (!empty($resultado)) {
            $this->nombre = $resultado[0]['nombres'];
            $this->usuario = $resultado[0]['dni'];
            $this->tipoUsuario = $resultado[0]['id_rol'];
            $this->id = $resultado[0]['id'];  
            if($resultado[0]['id_rol']==2) {
                $this->getNivelAcademicoDocente($resultado[0]['id'],$this->periodo);
            } else {
                $this->getNivelAcademico($resultado[0]['id']); 
            }
        } else {
            return false;
        }
    }


    public function getPeriodoAcademico(){

        $db = Conexion::obtenerConexion();
        $sql = "SELECT * FROM periodo_academico WHERE estado = 1 LIMIT 1";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (!empty($resultado)) {           
            $this->periodo = $resultado[0]['id'];            
        } else {
            $this->periodo = 0;
        }
    }

    public function getNivelAcademico($id){

        $db = Conexion::obtenerConexion();
        $sql = "SELECT * FROM matricula WHERE id_alumno  = $id";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (!empty($resultado)) {           
            $this->nivel = $resultado[0]['id_nivel'];            
        } else {
            $this->nivel = 0;
        }
    }

    public function getNivelAcademicoDocente($id,$id_periodo){

        $db = Conexion::obtenerConexion();
        $sql = "SELECT * FROM curso_docente WHERE id_docente  = $id AND id_periodo=$id_periodo";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (!empty($resultado)) {           
            $this->nivel = $resultado[0]['id_nivel'];            
        } else {
            $this->nivel = 0;
        }
    }


    public function getNombre()
    {
        return $this->nombre;
    }
    public function getUsuario()
    {
        return $this->usuario;
    }
    public function getTipoUsuario()
    {
        return $this->tipoUsuario;
    }
    public function getLogin()
    {
        return $this->id;
    }
    public function getPeriodo()
    {
        return $this->periodo;
    }
    public function getNivel()
    {
        return $this->nivel;
    }
}
