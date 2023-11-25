<?php
require_once '../../db/Conexion.php';
require_once '../../utilidades/ObtenerFechas.php';
class ModeloPersona
{
    protected $db;

    public function __construct()
    {
        $this->db = Conexion::obtenerConexion();
    }

    public function crearPersona($id_usuario, $id_rol, $dni, $password, $apellidos, $nombres, $direccion, $telefono, $correo, $seccion, $nombrePadre, $apellidoPadre, $celularPadre, $correoPadre)
    {


        //VALIDAR SI EXISTE UN DNI CON EL DNI QUE ME ESTA ENVIANDO EL USUARIO
        $validateDni = "SELECT * FROM persona WHERE dni = $dni";
        $stmtValidateDni = $this->db->query($validateDni);
        $persona = $stmtValidateDni->fetchAll(PDO::FETCH_ASSOC);
        if (!empty($persona)) {
            return false;
        }



        $sql = "INSERT INTO persona (id_usuario, id_rol, dni, password,apellidos, nombres,direccion,telefono,correo,seccion,fecha_de_creacion,clave_principal) 
        VALUES (:id_usuario, :id_rol, :dni, :password,:apellidos, :nombres,:direccion,:telefono,:correo,:seccion,:fecha_de_creacion,:clave_principal)";

        $passMD5 = md5($password);
        $fecha = ObtenerFechas::fechaActual();

        $query = $this->db->prepare($sql);
        $query->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $query->bindParam(':id_rol', $id_rol, PDO::PARAM_INT);
        $query->bindParam(':dni', $dni, PDO::PARAM_STR);
        $query->bindParam(':password', $passMD5, PDO::PARAM_STR);
        $query->bindParam(':apellidos', $apellidos, PDO::PARAM_STR);
        $query->bindParam(':nombres', $nombres, PDO::PARAM_STR);
        $query->bindParam(':direccion', $direccion, PDO::PARAM_STR);
        $query->bindParam(':telefono', $telefono, PDO::PARAM_STR);
        $query->bindParam(':correo', $correo, PDO::PARAM_STR);
        $query->bindParam(':seccion', $seccion, PDO::PARAM_STR);
        $query->bindParam(':fecha_de_creacion', $fecha, PDO::PARAM_STR);
        $query->bindParam(':clave_principal', $passMD5, PDO::PARAM_STR);


        $resultado = $query->execute();

        $idAlumno = $this->db->lastInsertId();

        //INSERTAMOS LOS PADRES O APODERADOS DE LOS ALUMNOS
        if ($id_rol == 3) {
            $sqlPadres = "INSERT INTO alumnos_padre (id_alumno, nombre, apellido, correo,celular) 
                    VALUES (:id_alumno, :nombre, :apellido, :correo,:celular)";


            $queryPadres = $this->db->prepare($sqlPadres);
            $queryPadres->bindParam(':id_alumno', $idAlumno, PDO::PARAM_INT);
            $queryPadres->bindParam(':nombre', $nombrePadre, PDO::PARAM_STR);
            $queryPadres->bindParam(':apellido', $apellidoPadre, PDO::PARAM_STR);
            $queryPadres->bindParam(':correo', $correoPadre, PDO::PARAM_STR);
            $queryPadres->bindParam(':celular', $celularPadre, PDO::PARAM_STR);
            $queryPadres->execute();
        }
        return $resultado;
    }

    public function obtenerPersonas($search = '', $role)
    {
        $sql = "SELECT p.*, r.descripcion AS rol FROM persona p 
        INNER JOIN roles r ON 
        r.id = p.id_rol WHERE p.nombres LIKE '%$search%' AND p.id_rol = $role ORDER BY p.id DESC LIMIT 20 ";
        $stmt = $this->db->query($sql);

        $resultado =  $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function obtenerPersona(int $id)
    {
        $sql = "SELECT p.*,ap.nombre AS nombrePadre,ap.apellido AS apellidoPadre,ap.celular AS celularPadre,ap.correo AS correoPadre  FROM persona p
        LEFT JOIN alumnos_padre ap ON 
        ap.id_alumno = p.id
        WHERE p.id = $id";
        $stmt = $this->db->query($sql);

        $resultado =  $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function obtenerPersonaCursos($idPeriodo, $idNivel, $idCurso, $idDocente)
    {
        try {

            $sql = "SELECT a.* 
        FROM detalle_matricula dm 
        INNER JOIN matricula m ON  
        m.id = dm.id_matricula 
        INNER JOIN curso_docente cd ON 
        cd.id = dm.id_curso_docente 
        INNER JOIN persona a ON  
        a.id = m.id_alumno 
        WHERE m.id_periodo_academico  = $idPeriodo 
        AND m.id_nivel  = $idNivel 
        AND cd.idcurso  = $idCurso 
        AND cd.id_docente  = $idDocente 
        GROUP BY a.id";
            $stmt = $this->db->query($sql);

            $resultado =  $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function actualizarPersona($id, $dni,  $apellidos, $nombres, $direccion, $telefono, $correo, $seccion, $nombrePadre, $apellidoPadre, $celularPadre, $correoPadre)
    {
        $sql = "UPDATE persona SET dni=:dni, apellidos=:apellidos, nombres=:nombres,direccion=:direccion,telefono=:telefono,correo=:correo,seccion=:seccion WHERE id = :id";
        $query = $this->db->prepare($sql);

        $query->bindParam(':dni', $dni, PDO::PARAM_STR);
        $query->bindParam(':apellidos', $apellidos, PDO::PARAM_STR);
        $query->bindParam(':nombres', $nombres, PDO::PARAM_STR);
        $query->bindParam(':direccion', $direccion, PDO::PARAM_STR);
        $query->bindParam(':telefono', $telefono, PDO::PARAM_STR);
        $query->bindParam(':correo', $correo, PDO::PARAM_STR);
        $query->bindParam(':seccion', $seccion, PDO::PARAM_STR);
        $query->bindParam(':id', $id, PDO::PARAM_INT);

        $resultado =  $query->execute();

        //VALIDAR SI EXISTE UN PADRE O APODERADO DEL ALUMNO
        $validate = "SELECT * FROM alumnos_padre WHERE id_alumno = $id";
        $stmtValidate = $this->db->query($validate);

        //VALIDAR EL TIPO DE PERSONA
        $validatePersona = "SELECT * FROM persona WHERE id = $id";
        $stmtValidatePersona = $this->db->query($validatePersona);

        if (!empty($stmtValidate->fetchAll(PDO::FETCH_ASSOC))) {

            //INSERTAMOS LOS PADRES O APODERADOS DE LOS ALUMNOS
            $sqlPadres = "UPDATE alumnos_padre SET nombre=:nombre,apellido=:apellido,correo=:correo,celular=:celular WHERE id_alumno = $id";
            $queryPadres = $this->db->prepare($sqlPadres);
            $queryPadres->bindParam(':nombre', $nombrePadre, PDO::PARAM_STR);
            $queryPadres->bindParam(':apellido', $apellidoPadre, PDO::PARAM_STR);
            $queryPadres->bindParam(':correo', $correoPadre, PDO::PARAM_STR);
            $queryPadres->bindParam(':celular', $celularPadre, PDO::PARAM_STR);
            $queryPadres->execute();
        } else {
            $persona = $stmtValidatePersona->fetchAll(PDO::FETCH_ASSOC);
            if ($persona[0]['id_rol'] == 3) {
                $sqlPadres = "INSERT INTO alumnos_padre (id_alumno, nombre, apellido, correo,celular) 
                VALUES (:id_alumno, :nombre, :apellido, :correo,:celular)";


                $queryPadres = $this->db->prepare($sqlPadres);
                $queryPadres->bindParam(':id_alumno', $id, PDO::PARAM_INT);
                $queryPadres->bindParam(':nombre', $nombrePadre, PDO::PARAM_STR);
                $queryPadres->bindParam(':apellido', $apellidoPadre, PDO::PARAM_STR);
                $queryPadres->bindParam(':correo', $correoPadre, PDO::PARAM_STR);
                $queryPadres->bindParam(':celular', $celularPadre, PDO::PARAM_STR);
                $queryPadres->execute();
            }
        }


        return $resultado;
    }


    public function resetearClave($id)
    {
        $validatePersona = "SELECT * FROM persona WHERE id = $id";
        $stmtValidatePersona = $this->db->query($validatePersona);
        $persona = $stmtValidatePersona->fetchAll(PDO::FETCH_ASSOC);

        $sql = "UPDATE persona SET password=:password WHERE id = :id";
        $query = $this->db->prepare($sql);
        $query->bindParam(':password', $persona[0]['clave_principal'], PDO::PARAM_STR);
        $query->bindParam(':id', $id, PDO::PARAM_INT);

        $resultado =  $query->execute();

        return $resultado;
    }

    public function eliminarPersona($id)
    {
        $sql = "DELETE FROM persona WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);

        $resultado =  $stmt->execute();
        return $resultado;
    }
}
