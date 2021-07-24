<?php
class Categorias{
    private $db;
    function __construct($ddbb){
        $this->db = $ddbb;
    }

    public function gets(){
        $qry = "SELECT * FROM `categorias` ";
        $data  = $this->db->consult($qry, []);
        return $data;
    }

    public function getsByUser($id){
        $qry = "SELECT * FROM `categorias` WHERE id_user = ? ";
        $data  = $this->db->consult($qry, [$id]);
        return $data;
    }

    public function create( $idUser, $nombre, $description){
        $qry = "INSERT INTO `categorias`(  `id_user`, `name`, `description`) VALUES (?,?,?)";
        $data  = $this->db->consult($qry, [$idUser, $nombre, $description]);
        return $data;
    }
    public function update($nombre, $description, $id, $idUser){
        $qry = "UPDATE `categorias` SET  `name`=?,`description`=? WHERE `id` = ? and `id_user` = ?";
        $data  = $this->db->consult($qry, [$nombre, $description, $id, $idUser]);
        return $data;
    }
    public function delete($id, $idUser){
        $qry = "DELETE FROM `categorias` WHERE id = ? and id_user = ?";
        $data  = $this->db->consult($qry, [$id, $idUser]);
        return $data;
    }

}

 ?>
