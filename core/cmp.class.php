<?php
/**
 *
 */
class Cmp{
    function __construct(){
        // code...
    }
    public function parseComponent($name, $args){
        $template = $this->create($name, $args);
        $script = $this->get_string_between($template,"<script>","</script>");
        $html = $this->get_string_between($template,"</script>","<style>");
        $css = $this->get_string_between($template,"<style>","</style>");

        preg_match_all('/[.]+.+{/', $css , $resultado, PREG_SET_ORDER, 0);

        $hash = substr(md5(time()),0,16);
        foreach ($resultado as $key => $value) {
            $css =  str_replace($value[0] , "#$hash ".$value[0] , $css) ;
        }
        $html =  str_replace("<kaiwik>" , "<kaiwik id='$hash' >"  , $html) ;
        return [$html, $css, $script];
    }
    function create($name, $arg = []) {
       $template= new template("vistas/_cmp/".$name.".kaiwik" , $arg);
       return $template;
   }
   function get_string_between($string, $start, $end){
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }

}


 ?>
