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

    public function create($name, $password, $email)  {
        // $date = new DateTime();
        $qry = "INSERT INTO `users` (`name`, `email`, `password`,`rol`) VALUES (?,?,?,0)";
        $this->db->consult($qry,[$name,$email, password_hash($password , PASSWORD_DEFAULT)]);
        // $date->format('Y-m-d H:i:s')
    }
    public function update($id, $name, $password, $email, $rol)  {

    }
    public function delete($id)  {

    }
    public function exist($id)  {
        return count($this->get($id)) > 0;
    }
}
?>
