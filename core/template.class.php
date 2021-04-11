<?php

/*
 * Template
 */
class Template{
    private $content;
    function __construct($path, $data = []){
        extract($data); // crea las varibales a partir del clave valor
        ob_start();
        include($path);
        $this->content = ob_get_clean();
    }

    public function __toString(){
        return $this->content;
    }
}

 ?>
