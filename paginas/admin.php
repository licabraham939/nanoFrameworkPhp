<?php
 class Admin  extends Context {
     private $context;
     function __construct($context){
         $this->context = $context;
         $this->context->title = "Inicio";
         if(!$context->session_exist()) header("location:/");
     }
     public function index(){
         $models = $this->sidebar();
         $html  = $this->context->create("navLog");
         $html  .= $this->context->create("panel", [
             "models" => $models,
             "rol" => ($this->context->session_rol())?"ADMIN":"CLIENTE",
             "name" => $this->context->session_user(),
              "child" => $this->context->create("userdata",[
                  "name" => $this->context->session_user(),
                  "email" => "email@gmail.com"
              ])
         ]);
         $html  .= $this->context->create("footer");
         return $this->context->ret($html);
     }

     public function usuarios(){
         if($this->context->session_rol() == 0) header("location:/admin");
         $models = $this->sidebar();
         $usuarios = $this->context->model("user")->gets();

         $html  = $this->context->create("navLog");
         $html  .= $this->context->create("panel", [
                "models" => $models,
                "rol" => ($this->context->session_rol())?"ADMIN":"CLIENTE",
                "name" => $this->context->session_user(),
                "child" => $this->context->create("tableUser", [
                        "usuarios" => $usuarios
             ])
         ]);
         $html  .= $this->context->create("footer");
         return $this->context->ret($html);
     }

     private function sidebar() {
         $menu = [ ["url"=>"/admin", "name"=>"Mis datos"] ];
         if($this->context->session_rol()){
             array_push( $menu, ["url"=>"/admin/usuarios", "name"=>"Usuarios"]  );
         }
         return $menu;
     }
}

?>
