<?php
include 'core/conexion.class.php';
include 'core/context.class.php';
include 'core/template.class.php';
include 'config.php';

// Enrutador
$uri = ($_SERVER['REQUEST_URI'] == "/")? "/inicio": $_SERVER['REQUEST_URI'];
$uriP = explode('/',$uri); array_shift($uriP);
$path = "paginas";
$i = 0;
for (; $i <  count($uriP) ; $i++){
  if($uriP[$i] != "" && file_exists($path."/".$uriP[$i]) || file_exists($path."/".$uriP[$i].".php")){
     $path .= "/".$uriP[$i];
  } else break;
}
$uriP = array_slice($uriP, $i);

if(file_exists($path.".php")){
  render($path, $uriP);
}
elseif(file_exists($path."/".$uriP[0].".php")){
  render($path."/".$uriP[0], array_slice($uriP, 1));
}
elseif(file_exists($path."/"."index.php")){
  render($path."/index", $uriP);
}
else header("location:/error404");

function render($file,$arg){
  $context = new Context($GLOBALS["db"]);
  require_once($file.".php");
  $pg= ucfirst(array_pop(explode('/',$file)));
  if($pg == "Index"){
    $t = explode('/',$file);
    $pg= ucfirst($t[count($t)-2]); 
  }
  $pg = new $pg($context);

  if(isset($arg[0])){
    if (method_exists($pg,$arg[0])){
          $f = $arg[0]; array_shift($arg);
          draw($pg->$f($arg));
      }
      else{
            array_shift($uriP);
            draw( $pg->index($arg));
        };
  }else draw($pg->index());
}

// pinta al web completa con su js y stylo personalzado
function draw($vista){
    switch ($vista["type"]) {
        case 'html':
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
            break;
        default:
            header('Content-Type: application/json; charset=utf-8');
            echo(json_encode($vista));
            break;
    }
}

?>
