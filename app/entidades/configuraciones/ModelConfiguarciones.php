<?php
require_once '../../db/Conexion.php';
class ModelConfiguarciones
{
    protected $db;

    public function __construct()
    {
        $this->db = Conexion::obtenerConexion();
    }

    public function crearEmpresa($nombre, $direccion, $celular, $logo, $foto)
    {
        $sql = "INSERT INTO empresa (nombre,direccion,celular,logo,foto) 
        VALUES (:nombre,:direccion,:celular,:logo,:foto)";


        $query = $this->db->prepare($sql);
        $query->bindParam(':nombre', $nombre);
        $query->bindParam(':direccion', $direccion);
        $query->bindParam(':celular', $celular, PDO::PARAM_STR);
        $query->bindParam(':logo', $logo, PDO::PARAM_STR);
        $query->bindParam(':foto', $foto, PDO::PARAM_STR);

        $resultado = $query->execute();
        return $resultado;
    }

    public function obtenerEmpresa()
    {
        $sql = "SELECT * FROM empresa ";
        $stmt = $this->db->query($sql);

        $resultado =  $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }



    public function actualizarEmpresa($id, $nombre, $direccion, $celular, $logo, $foto)
    {
        $sql = "";if ($logo != NULL && $foto == NULL) {
            $sql = "UPDATE empresa SET nombre=:nombre,direccion=:direccion,celular=:celular,logo=:logo WHERE id = :id";

            $query = $this->db->prepare($sql);
            $query->bindParam(':nombre', $nombre);
            $query->bindParam(':direccion', $direccion);
            $query->bindParam(':celular', $celular, PDO::PARAM_STR);
            $query->bindParam(':logo', $logo, PDO::PARAM_STR);
            $query->bindParam(':id', $id, PDO::PARAM_INT);
        } else if ($foto != NULL && $logo == NULL) {
            $sql = "UPDATE empresa SET nombre=:nombre,direccion=:direccion,celular=:celular,foto=:foto WHERE id = :id";
            $query = $this->db->prepare($sql);
            $query->bindParam(':nombre', $nombre);
            $query->bindParam(':direccion', $direccion);
            $query->bindParam(':celular', $celular, PDO::PARAM_STR);
            $query->bindParam(':foto', $foto, PDO::PARAM_STR);
            $query->bindParam(':id', $id, PDO::PARAM_INT);
        } else {
            $sql = "UPDATE empresa SET nombre=:nombre,direccion=:direccion,celular=:celular,logo=:logo,foto=:foto WHERE id = :id";
            $query = $this->db->prepare($sql);
            $query->bindParam(':nombre', $nombre);
            $query->bindParam(':direccion', $direccion);
            $query->bindParam(':celular', $celular, PDO::PARAM_STR);
            $query->bindParam(':logo', $logo, PDO::PARAM_STR);
            $query->bindParam(':foto', $foto, PDO::PARAM_STR);
            $query->bindParam(':id', $id, PDO::PARAM_INT);
        }


        $resultado =  $query->execute();
        return $resultado;
    }

}
