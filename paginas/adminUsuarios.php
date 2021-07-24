<?php
 class AdminUsuarios  extends Context {
     private $context;
     function __construct($context){
         $this->context = $context;
         $this->context->title = "Inicio";
         if(!$context->sessionExist()) header("location:/");
     }
     public function index(){
         if($this->context->sessionUser()->rol == 0) header("location:/admin");
         $usuarios = $this->context->model("user")->gets();

         $html  = $this->context->create("_componentes/navLog");
         $html  .= $this->context->create("_componentes/title",[
             "title" => "Usuarios"
         ]);
         $html  .=  $this->context->create("admin/tableUser", [
                        "usuarios" => $usuarios
         ]);
         $html  .= $this->context->create("_componentes/footer");
         return $this->context->ret($html);
     }

     function active($id){
          if($this->context->sessionUser()->rol == 1){
              $this->context->model("user")->active($id[0]);
          }
          header("location:/adminUsuarios");
     }
}

?>
