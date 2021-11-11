<?php
class Files extends Context {
    function __construct( ){
    }
    public function main()  {
        $cmp = "hola este es el main";
        return $cmp;
    }
    public function ls($dir)  {
        $files = scandir($dir);
        unset($files[0]);  unset($files[1]);
        $cmp = $this->create("showfiles",["files" => $files, "rut" => HOST."/$dir"]);
        return $cmp;
    }
}
?>
