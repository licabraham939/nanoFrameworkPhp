<?php
 class Example  extends Context {
     private $context;
     function __construct($context){
         $this->context = $context;
         $this->context->title = "About";
     }

     public function index(){
         $html  = ($this->context->sessionExist())
            ?$this->context->create("_componentes/navLog")
            :$this->context->create("_componentes/nav");
        // Permite usar funciones definidas en helper
        // $html  .= $this->create("showfiles",["name" => "SOY UN COMPONENTE DE UN SOLO ARCHIVO"]);
        // y en lib por defecto del sistema
        // var_dump($this->help("suma",[1, 1]));
         $html  .= $this->lib("files")->ls("@recursos");
         $html  .= $this->context->create("_componentes/footer");
         return $this->ret($html);
     }

     // ej:http://localhost:3001/about/f/123/23
     public function test($arg){
         $html  = $this->context->create("_componentes/nav");
         return $this->ok(["asdf","df"], "si claro");
     }

}

?>
