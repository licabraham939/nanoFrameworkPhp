<?php
 class Inicio  extends Context {
     private $context;
     function __construct($context){
         $this->context = $context;
         $this->context->title = "Inicio";
     }
     public function index(){
         $html  = ($this->context->session_exist())
            ?$this->context->create("navLog")
            :$this->context->create("nav");
         $html  .= $this->context->create("inicio", [
             "title" => "Inicio"
         ]); 
         $html  .= $this->context->create("footer");
         return $this->context->ret($html);
     }
}

?>
