<?php
 class LogIn  extends Context {
     private $context;
     function __construct($context){
         $this->context = $context;
         $this->context->title = "Iniciar";
          if($context->session_exist()) header("location:/admin");
     }

     public function index(){
         $html  = $this->context->create("nav");
         $html  .= $this->context->create("logIn");
         $html  .= $this->context->create("footer");
         return $this->context->ret($html);
     }

     public function iniciar_session(){
         $data = $this->context->model("user")->get($_POST["email"]);
         if(count($data) > 0){
              if(password_verify($_POST["password"], $data[0]->password)){
                  $this->context->session_open($data[0]->name, $data[0]->rol);
                  header("location:/admin");
              }
              else $msj =  "Verifique la contraseña";
         }
         else $msj =  "El usuario no existe";
         // RENDER
         $html  = $this->context->create("nav");
         $html  .= $this->context->create("logIn",[
             "msj" => $msj
         ]);
         $html  .= $this->context->create("footer");
         return $this->context->ret($html);
     }

     public function cerrar_session(){
         $this->context->session_close();
         header("location:/logIn");
     }

}

?>
