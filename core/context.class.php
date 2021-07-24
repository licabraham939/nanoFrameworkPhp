<?php
include 'helper.class.php';
include 'pass.class.php';
/**
 * Contexto de una conexio y datos del usurio
 */
class Context{
    public $title ;  private $css = []; private $js = [];

    private $helpers;
    private $pass;
    function __construct($ddbb){
        $this->db = $ddbb;
        $this->helper = new Helper();
        $this->pass = new Pass();
    }

    // Modelos
    function model($modelName){
        require_once("modelos/".$modelName.".php");
        $model = ucfirst($modelName);
        $model = new $model($this->db);
        return $model;
    }

    // Sessiones
    function sessionStart($idUser){
        session_start();
        $_SESSION['userId'] = $idUser;
    }
    function sessionFinish(){
        session_start();
        unset($_SESSION['userId']);
    }
    function sessionUser(){
        session_start();
        $user = $this->model("user")->get($_SESSION['userId']);
        if($user != []) return $user[0];
        return null;
    }
    function sessionExist(){
       session_start();  return isset($_SESSION['userId']);
    }

    //
    // function session_close(){
    //     session_start();
    //     unset($_SESSION['user']);
    //     unset($_SESSION['rol']);
    // }
    // function session_open($userName, $userRol){
    //     session_start();
    //     $_SESSION['user'] = $userName;
    //     $_SESSION['rol'] = $userRol;
    // }
    // function session_user(){
    //     session_start();  return $_SESSION['user'];
    // }
    // function session_rol(){
    //    session_start();  return $_SESSION['rol'];
    // }
    // function session_exist(){
    //    session_start();  return isset($_SESSION['rol']);
    // }

    // Template
     function create($name, $arg = []) {
        $html= new template("vistas/".$name."/index.html" , $arg);
        $this->css[] = $name;
        $this->js[] = $name;
        return $html;
    }
    function ret( $html) {
       return [
           "title" => $this->title,
           "css" => $this->css,
           "html" => $html,
           "js" => $this->js,
       ];
   }

}

 ?>
