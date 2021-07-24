<?php
 class Inicio  extends Context {
     private $context;
     function __construct($context){
         $this->context = $context;
         $this->context->title = "Inicio";
     }
     public function index(){
         $html  = ($this->context->sessionExist())
            ?$this->context->create("_componentes/navLog")
            :$this->context->create("_componentes/nav");

         $html  .= $this->context->create("inicio", [
             "title" => "Inicio"
         ]);

         $html  .= $this->context->create("_componentes/footer");
         return $this->context->ret($html);
     }
}

?>
