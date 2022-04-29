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

    function lib($libName){
        require_once("core/lib/".$libName.".php");
        $lib = ucfirst($libName);
        $lib = new $lib();
        return $lib;
    }

    // Modelos
    function model($modelName){
        require_once("modelos/".$modelName.".php");
        $model = "Model_".ucfirst($modelName);
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


    // Template
     function create($name, $arg = []) {
         if (file_exists("vistas/".$name."/index.html")) {
             $html= new template("vistas/".$name."/index.html" , $arg);
             $this->css[] = $name;
             $this->js[] = $name;
             return $html;
         }
         else {
             $obj =  new Cmp();
             [$html, $css, $js] = $obj->parseComponent($name,$arg);
             $this->csscmp.=$css;
             $this->jscmp.=$js;
             return $html;
         }
    }

    function ret( $html) {
       return [
           "type" => "html",
           "title" => $this->title,
           "css" => $this->css,
           "html" => $html,
           "js" => $this->js,
           "csscmp" => $this->csscmp,
           "jscmp" => $this->jscmp,
       ];
   }

       function ok($data, $mensaje = null) {
         http_response_code(200);
         return [
           "error" => false,
           "mensaje" => $mensaje,
           "data" => $data,
         ];
      }

      function error($code, $mensaje) {
        http_response_code($code);
        return [
          "error"=> true,
          "code"=> $code,
          "mensaje"=> $mensaje,
          "data" => null
        ];
      }

}

 ?>
