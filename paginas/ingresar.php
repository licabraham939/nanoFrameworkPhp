<?php
 class  Ingresar extends Context {
     private $context;
     function __construct($context){
         $this->context = $context;
         $this->context->title = "Iniciar";
          if($context->sessionExist()) header("location:/admin");
     }

     public function index($arg = null){
         $html  = $this->context->create("_componentes/nav");
         $html  .= $this->context->create("logIn");
         $html  .= $this->context->create("_componentes/footer");
         return $this->context->ret($html);
     }

      public function iniciar_session($arg = null){
          $data = $this->context->model("user")->get($_POST["email"]);
          if(count($data) > 0){
               if(password_verify($_POST["password"], $data[0]->password)){
                   $this->context->sessionStart($_POST["email"]);
                   header("location:/admin");
               }
               else $msj =  "Verifique la contraseña";
          }
          else $msj =  "El usuario no existe";
          // RENDER
          $html  = $this->context->create("_componentes/nav");
          $html  .= $this->context->create("logIn",[
              "msj" => $msj,
              "email" => $_POST["email"],
          ]);
          $html  .= $this->context->create("_componentes/footer");
          return $this->context->ret($html);
      }

      public function cerrar_session(){
          $this->context->sessionFinish();
          header("location:/ingresar");
      }
 }

?>
