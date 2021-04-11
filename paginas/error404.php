<?php
 class Error404  extends Context {
     private $context;
     function __construct($context){
         $this->context = $context;
         $this->context->title = "Not Found 404 ";
     }

     public function index(){
         $html  = ($this->context->session_exist())
            ?$this->context->create("navLog")
            :$this->context->create("nav");
         $html  .= $this->context->create("error404");
         return $this->context->ret($html);
     }

}

?>
