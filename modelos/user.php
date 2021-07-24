<?php
class User{
    private $db;
    function __construct($ddbb){
        $this->db = $ddbb;
    }
    public function gets()  {
        $qry = "SELECT * FROM `users`  ";
        $data  = $this->db->consult($qry, [ ]);
        return $data;
    }
    public function get($id)  {
        $qry = "SELECT * FROM `users` WHERE email = ?";
        $data  = $this->db->consult($qry, [$id]);
        return $data;
    }
    public function getId($id)  {
        $qry = "SELECT * FROM `users` WHERE `id` = ?";
        $data  = $this->db->consult($qry, [$id]);
        return $data;
    }

    public function create($name, $password, $email)  {
        var_dump($name, $password, $email);
        $qry = "INSERT INTO `users`
            (`id`, `name`, `password`, `email`, `rol`, `phone`, `fecha_registro`, `status`)
            VALUES (DEFAULT,?,?,?,0,0, NOW(),0)";
        $this->db->consult($qry,[$name, $password,$email]);
    }
    public function update($phone, $name, $id)  {
        $qry = "UPDATE `users` SET  `phone` = ?,  `name` = ? WHERE `id` = ? ";
        $this->db->consult($qry,[$phone, $name, $id]);
    }
    public function delete($id){

    }
    public function active($id)  {
        $statusOld = $this->getId($id)[0]->status;
        $qry = "UPDATE `users` SET  `status` = ?  WHERE `id` = ? ";
        $this->db->consult($qry,[($statusOld)?'0':'1' ,$id]);
    }
    public function exist($id)  {
        return count($this->get($id)) > 0;
    }
}
?>
