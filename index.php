<?php
include 'core/conexion.class.php';
include 'core/context.class.php';
include 'core/template.class.php';
include 'config.php';


// Enrutador
$uri = $_SERVER['REQUEST_URI'];
$uriP = explode('/',$uri);
array_shift($uriP);
//cuando en la url no hay nada significa que pintaremos la pagina inicio
if($uriP[0] =="") $uriP[0] = "inicio";
// Se procesan las paginas
if(file_exists ("paginas/".$uriP[0].".php")){
    $context = new Context($db);
    require_once("paginas/".$uriP[0].".php");
    $pg= ucfirst($uriP[0]);
    $pg = new $pg($context);
    if(isset($uriP[1])){
            if (method_exists($pg,$uriP[1])){
                $f = $uriP[1]; array_shift($uriP);array_shift($uriP);
                render( $pg->$f($uriP) );
            }
            else{
                array_shift($uriP);
                render( $pg->index($uriP));
            };
    }
    else render($pg->index());
}
else header("location:/error404");

// pinta al web completa con su js y stylo personalzado
function render($vista){
    extract($vista); // crea las varibales a partir del clave valor
    $view =  new Template("vistas/app.html",[
        "title"   => $title,
        "RootCSS"   => $css,
        "RootHTML" => $html,
        "RootJS" => $js,
        "CSSCMP" => '<style media="screen">'.$csscmp.'</style>',
        "JSCMP" => '<script type="text/javascript">'.$jscmp.' </script>'
    ]);
    echo $view;
}

?>
