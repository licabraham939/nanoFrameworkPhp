<?php
class Model_Producto{
    private $db;
    function __construct($ddbb){
        $this->db = $ddbb;
    }
    public function get($id){

        $qry = "SELECT * FROM `producto`   WHERE id = ? ";
        $data  = $this->db->consult($qry, [$id]);
        return $data;
    }
    public function gets($id){

        $qry = "SELECT *
            FROM `producto` , (SELECT  `categorias`.name as nameCateg , `categorias`.id as idCateg
                                                FROM `categorias`
                                                WHERE id_user = ?) as categ
            WHERE producto.id_categoria = categ.idCateg ";
        $data  = $this->db->consult($qry, [$id]);
        return $data;
    }

    public function create( $nombre, $descripcion, $img,  $id_categoria, $precio){
        $qry = "INSERT INTO `producto`( `name`, `description`, `img`, `id_categoria`, `price`)
        VALUES (?,?,?,?,?)";
        $data  = $this->db->consult($qry, [$nombre, $descripcion, $img,  $id_categoria, $precio]);
        return $data;
    }
    public function update( $nombre, $descripcion, $img,  $id_categoria, $precio, $id){
        $qry = "UPDATE `producto` SET  `name`=? ,   `description`=?, `img` =?, `id_categoria` =?, `price` =?  WHERE id = ?";
        $data  = $this->db->consult($qry, [$nombre, $descripcion, $img,  $id_categoria, $precio, $id]);
        return $data;
    }
    public function delete($id){
        $qry = "DELETE FROM `producto` WHERE id = ?";
        $data  = $this->db->consult($qry, [$id]);
        return $data;
    }

}

 ?>
