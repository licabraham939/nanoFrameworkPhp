<?php
 class About  extends Context {
     private $context;
     function __construct($context){
         $this->context = $context;
         $this->context->title = "About";
     }

     public function index(){
         $html  = ($this->context->session_exist())
            ?$this->context->create("navLog")
            :$this->context->create("nav");
         $html  .= $this->context->create("about");
         $html  .= $this->context->create("footer");
         return $this->context->ret($html);
     }

     // ej:http://localhost:3001/about/f/123/23
     public function f($arg){
         $html  = $this->context->create("nav");
         $html .= json_encode($arg);
         return $this->context->ret($html);
     }

}



?>
