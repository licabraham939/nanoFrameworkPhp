<?php
include 'helper.class.php';
include 'lib.class.php';
include 'cmp.class.php';
/**
 * Contexto de una conexio y datos del usurio
 */
class Context{
    public $title ;  private $css = []; private $js = [];
    private $csscmp = ""; private $jscmp = "";

    function __construct($ddbb){
        $this->db = $ddbb;
    }

    public function help($name, $args){
        $obj = new Helper();
        return $obj->$name(...$args);
    }
    public function lib($name, $args = []){
        $obj =  new Lib();
        return $obj->$name(...$args);
    }
    public function cmp($name, $args = []){
        $obj =  new Cmp();
        [$html, $css, $js] = $obj->paseComponent($name,$args);
        $this->csscmp.=$css;
        $this->jscmp.=$js;
        return $html;
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
           "csscmp" => $this->csscmp,
           "jscmp" => $this->jscmp,
       ];
   }

}

 ?>
