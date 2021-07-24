<?php
 class Registrarse  extends Context {
     private $context;
     function __construct($context){
         $this->context = $context;
         $this->context->title = "Registrarse";
         if($context->sessionExist()) header("location:/admin");
     }

     public function index(){
         $html  = $this->context->create("_componentes/nav");
         $html  .= $this->context->create("registrarse");
         $html  .= $this->context->create("_componentes/footer");
         return $this->context->ret($html);
     }

     public function login(){
         $msj = "";
         if($this->context->model("user")->exist($_POST["email"]))
            $msj = "El usuario con el email ya existe";
        else{
            $this->context->model("user")->create($_POST["name"],password_hash( $_POST["pass1"], PASSWORD_DEFAULT), $_POST["email"]);
            $this->context->sessionStart($_POST["email"]);
            header("location:/admin"); die();
        }
         $html  = $this->context->create("_componentes/nav");
         $html  .= $this->context->create("registrarse",[
             "msj" => $msj
         ]);
         $html  .= $this->context->create("_componentes/footer");
         return $this->context->ret($html);
     }

}

?>
