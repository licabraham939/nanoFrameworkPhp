<?php
 class Registrarse  extends Context {
     private $context;
     function __construct($context){
         $this->context = $context;
         $this->context->title = "Registrarse";
         if($context->session_exist()) header("location:/admin");
     }

     public function index(){
         $html  = $this->context->create("nav");
         $html  .= $this->context->create("registrarse");
         $html  .= $this->context->create("footer");
         return $this->context->ret($html);
     }

     public function login(){
         $msj = "";
         if($this->context->model("user")->exist("pepe"))
            $msj = "El usuario ya existe";
        else{
            $this->context->model("user")->create($_POST["name"], $_POST["pass1"], $_POST["email"]);
            $this->context->session_open($_POST["name"],0);
            header("location:/admin");
        }
         $html  = $this->context->create("nav");
         $html  .= $this->context->create("registrarse",[
             "msj" => $msj
         ]);
         $html  .= $this->context->create("footer");
         return $this->context->ret($html);
     }

}

?>
