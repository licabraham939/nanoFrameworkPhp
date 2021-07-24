<?php
 class AdminMy  extends Context {
     private $context;
     function __construct($context){
         $this->context = $context;
         $this->context->title = "Inicio";
         if(!$context->sessionExist()) header("location:/");
     }
     public function index(){
         $us   = $this->context->sessionUser();
         $html  = $this->context->create("_componentes/navLog");
         $html  .= $this->context->create("_componentes/title",[
             "title" => "Mis datos"
         ]);
         $html  .=  $this->context->create("admin/userdata", [
                 "name" =>$us->name,
                 "email" => $us->email,
                 "phone" => $us->phone
         ]);
         $html  .= $this->context->create("_componentes/footer");
         return $this->context->ret($html);
     }


     public function update( ){
         $usuario   = $this->context->sessionUser();
         $this->context->model("user")->update($_POST["tel"], $_POST["name"],$usuario->id);
         header("location:/adminMy");
     }
}

?>
