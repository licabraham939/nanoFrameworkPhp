<?php
 class Error404  extends Context {
     private $context;
     function __construct($context){
         $this->context = $context;
         $this->context->title = "Not Found 404 ";
     }

     public function index(){
         $html  = ($this->context->sessionExist())
            ?$this->context->create("_componentes/navLog")
            :$this->context->create("_componentes/nav");
         $html  .= $this->context->create("error404");
         $html  .= $this->context->create("_componentes/footer");
         return $this->context->ret($html);
     }

}

?>
