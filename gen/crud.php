<?php

include 'core/conexion.class.php';
include 'config.php';

$ENTIDAD = strtolower($argv[1]); array_shift($argv); array_shift($argv);
$ATRIBUTOS = $argv;

//Create Table
// ==============================================
  $str = 'CREATE TABLE IF NOT EXISTS `'.$ENTIDAD.'` (
    `id` int(11) NOT NULL AUTO_INCREMENT,';
  $k=0;
  for (; $k < count($ATRIBUTOS) ; $k++) {
    $i = explode(':',$ATRIBUTOS[$k]);
    $str.='   `'.$i[0].'` '.getTyp($i[1]).' NOT NULL,
    ';
  }
  $str.='PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4';

  $db->consult($str,[]);

  function getTyp($t){
    switch ($t) {
      case 'string':
        return 'varchar(20)';
        break;
      case 'int':
        return 'varchar(11)';
        break;
      case 'float':
        return 'float(10,3)';
        break;
      default:
        echo "Error Type Sintax string-int-float";
        die();
        break;
    }
  }
// Create Model
// ==============================================
$archivo = fopen("modelos/$ENTIDAD.php","w+b");
if($archivo == false ){
  echo "Error al crear el archivo";
  die();
}

fwrite($archivo, '<?php

class Model_'.ucfirst($ENTIDAD).'{
    private $db;
    function __construct($ddbb){
        $this->db = $ddbb;
    }
    public function get($id){
        $qry = "SELECT * FROM `'.$ENTIDAD.'`   WHERE id = ? ";
        $data  = $this->db->consult($qry, [$id]);
        return $data;
    }
    public function gets(){
        $qry = "SELECT * FROM `'.$ENTIDAD.'` ";
        $data  = $this->db->consult($qry, []);
        return $data;
    }

    public function create('.sqlCreateArg($ATRIBUTOS).'){
        $qry = "INSERT INTO `'.$ENTIDAD.'` '.sqlCreate($ATRIBUTOS).'";
        $data  = $this->db->consult($qry, ['.sqlCreateArg($ATRIBUTOS).']);
        return $data;
    }
    public function update('.sqlCreateArg($ATRIBUTOS).', $id){
        $qry = "UPDATE `'.$ENTIDAD.'` SET  '.sqlCreateUpdate($ATRIBUTOS).'  WHERE id = ?";
        $data  = $this->db->consult($qry, ['.sqlCreateArg($ATRIBUTOS).', $id]);
        return $data;
    }
    public function delete($id){
        $qry = "DELETE FROM `'.$ENTIDAD.'` WHERE id = ?";
        $data  = $this->db->consult($qry, [$id]);
        return $data;
    }

}

?>');
fflush($archivo);fclose($archivo);

function sqlCreate($atr){
  $str = '(';
  $k=0;
  for (; $k < count($atr) - 1 ; $k++) {
    $i = explode(':',$atr[$k]);  $str.='`'.$i[0].'`,';
  }
  $i = explode(':',$atr[$k]);
  $str.='`'.$i[0].'`)
                VALUES (';
  $k = 0;
  for (; $k < count($atr) - 1  ; $k++) {
     $str.='?,';
  }
  $str.='?)';
  return $str;
}

function sqlCreateArg($atr){
  $str = '';
  $k=0;
  for (; $k < count($atr) - 1 ; $k++) {
    $i = explode(':',$atr[$k]);
    $str.='$'.$i[0].', ';
  }
  $i = explode(':',$atr[$k]);
  $str.='$'.$i[0];
  return $str;
}

function sqlCreateUpdate($atr){
  $str = '';
  $k=0;
  for (; $k < count($atr) - 1 ; $k++) {
    $i = explode(':',$atr[$k]);
    $str.='`'.$i[0].'` = ?, ';
  }
  $i = explode(':',$atr[$k]);
  $str.='`'.$i[0].'` = ? ';
  return $str;
}

// Create ENTIDAD CREATE
// ==============================================
$micarpeta = "paginas/panel/$ENTIDAD";
if (!file_exists($micarpeta)) {
    mkdir($micarpeta, 0777, true);
}
$archivo = fopen("paginas/panel/$ENTIDAD/create.php","w+b");
if($archivo == false ){
  echo "Error al crear el archivo";
  die();
}
fwrite($archivo,'<?php
 class Create  extends Context {
     private $context;
     function __construct($context){
         $this->context = $context;
         $this->context->title = "'.ucfirst($ENTIDAD).'";
     }
     public function index(){
         $html  = ($this->context->sessionExist())
            ?$this->context->create("_componentes/navLog")
            :$this->context->create("_componentes/nav");

         $html .= $this->context->create("'.$ENTIDAD.'/create");

         $html  .= $this->context->create("_componentes/footer");
         return $this->context->ret($html);
     }

     public function add($value=""){
       $this->context->model("'.$ENTIDAD.'")->create(
           '.createArgAdd($ATRIBUTOS).'
        );
       header("location:/panel/'.$ENTIDAD.'");
     }
}
?>');
fflush($archivo);fclose($archivo);

function createArgAdd($atr){
  $str = '';
  $k=0;
  for (; $k < count($atr) - 1 ; $k++) {
    $i = explode(':',$atr[$k]);
    $str.='$_POST["'.$i[0].'"],
           ';
  }
  $i = explode(':',$atr[$k]);
  $str.='$_POST["'.$i[0].'"]';
  return $str;
}

// Create VISTA CREATE
// ==============================================
$micarpeta = "vistas/$ENTIDAD";
if (!file_exists($micarpeta)) {
    mkdir($micarpeta, 0777, true);
}
$archivo = fopen("vistas/$ENTIDAD/create.kaiwik","w+b");
if($archivo == false ){
  echo "Error al crear el archivo";
  die();
}
fwrite($archivo,'<script>
    console.log("HOLA");
</script>

<kaiwik>

  <section >
      <div class="container pt-5">
        <h4>Añadir '.ucfirst($ENTIDAD).'</h4>
        <a href="/panel">Panel<a/> / <a href="/panel/'.$ENTIDAD.'">'.ucfirst($ENTIDAD).'<a/> / new
      </div>
  <section />

  <section>
      <div class="container py-5 ">
             <form class="" action="/panel/'.$ENTIDAD.'/create/add" method="post">
                 '.createInputs($ATRIBUTOS).'
                 <button type="submit" class="btn   my-3 btn-primary btn-sm">Agregar</button>
             </form>
   </div>
   </section>

</kaiwik>

<style>
    .colo{
        color: blue;
    }
    .colo2{
        color: green;
    }
</style>
');
fflush($archivo);fclose($archivo);
function createInputs($atr){
  $str = '';
  $k=0;
  for (; $k < count($atr)  ; $k++) {
    $i = explode(':',$atr[$k]);
    $str.='<input name="'.$i[0].'"  required  placeholder="'.$i[0].'"  class="form-control mb-3">
                 ';
  }
  return $str;
}

// Create VISTA READ
$micarpeta = "vistas/$ENTIDAD";
if (!file_exists($micarpeta)) {
    mkdir($micarpeta, 0777, true);
}
$archivo = fopen("vistas/$ENTIDAD/read.kaiwik","w+b");
if($archivo == false ){
  echo "Error al crear el archivo";
  die();
}
fwrite($archivo,'<script>
    console.log("HOLA");
</script>

<kaiwik>

  <section >
      <div class="container pt-5">
        <h4>Listando '.ucfirst($ENTIDAD).'</h4>
        <a href="/panel">Panel<a/> / <a href="/'.$ENTIDAD.'">'.ucfirst($ENTIDAD).'<a/>
      </div>
  <section />

  <section >
      <div class="container">
          <div class="float-end py-2">
              <a href="/panel/'.$ENTIDAD.'/create" class="btn btn-primary btn-sm">Añadir '.$ENTIDAD.'</a>
          </div>
              <table class="table   table-hover text-center">
                <thead class=" shadow-sm">
                  <tr>
                    <th scope="col">#id</th>
                    '.createTableHeadList($ATRIBUTOS).'
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody>
                      <?php foreach ($data as $key => $value): ?>
                          <tr>
                            <td><?= $value->id?></td>
                            '.createTableList($ATRIBUTOS).'
                          <td>
                            <a href="/'.$ENTIDAD.'/<?= $value->id?>" class="btn btn-secondary btn-sm">Detalles</a>
                            <a href="/panel/'.$ENTIDAD.'/delete/<?= $value->id?>" class="btn btn-danger btn-sm">Eliminar</a>
                            <a href="/panel/'.$ENTIDAD.'/update/<?= $value->id?>" class="btn btn-primary btn-sm">Actualizar</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
              </table>
      </div>
  </section>

</kaiwik>

<style>
    .colo{
        color: blue;
    }
    .colo2{
        color: green;
    }
</style>
');
fflush($archivo);fclose($archivo);
function createTableList($atr){
  $str = '';
  $k=0;
  for (; $k < count($atr)  ; $k++) {
    $i = explode(':',$atr[$k]);
    $str.='<td><?= $value->'.$i[0].'?></td>
                 ';
  }
  return $str;
}


function createTableHeadList($atr){
  $str = '';
  $k=0;
  for (; $k < count($atr)  ; $k++) {
    $i = explode(':',$atr[$k]);
    $str.='<th scope="col">'.$i[0].'</th>
                 ';
  }
  return $str;
}


// Create CONTROLLER READ
$micarpeta = "paginas/$ENTIDAD";
if (!file_exists($micarpeta)) {
    mkdir($micarpeta, 0777, true);
}
$archivo = fopen("paginas/panel/$ENTIDAD/index.php","w+b");
if($archivo == false ){
  echo "Error al crear el archivo";
  die();
}
fwrite($archivo,'<?php
 class '.ucfirst($ENTIDAD).'  extends Context {
     private $context;
     function __construct($context){
         $this->context = $context;
         $this->context->title = "'.ucfirst($ENTIDAD).'";
     }
     public function index(){
         $html  = ($this->context->sessionExist())
            ?$this->context->create("_componentes/navLog")
            :$this->context->create("_componentes/nav");

         $data = $this->context->model("'.$ENTIDAD.'")->gets();

         $html .= $this->context->create("'.$ENTIDAD.'/read", $data);

         $html  .= $this->context->create("_componentes/footer");
         return $this->context->ret($html);
     }

     public function delete($args=[]){
       $id = $args[0];
       $this->context->model("'.$ENTIDAD.'")->delete($id );
       header("location:/panel/'.$ENTIDAD.'");
    }
}

?>
');
fflush($archivo);fclose($archivo);



// Create VISTA UPDATE
$micarpeta = "vistas/$ENTIDAD";
if (!file_exists($micarpeta)) {
    mkdir($micarpeta, 0777, true);
}
$archivo = fopen("vistas/$ENTIDAD/update.kaiwik","w+b");
if($archivo == false ){
  echo "Error al crear el archivo";
  die();
}
fwrite($archivo,'<script>
    console.log("HOLA");
</script>

<kaiwik>

  <section >
      <div class="container pt-5">
        <h4>Actualizar  '.ucfirst($ENTIDAD).'</h4>
        <a href="/panel">Panel<a/> / <a href="/panel/entidad"> '.ucfirst($ENTIDAD).'<a/> / update
      </div>
  <section />

  <section>
      <div class="container py-5 ">
             <form class="" action="/panel/'.$ENTIDAD.'/update/put" method="post">
                <input name="id" value="<?= $data->id ?>" required   hidden />
                  '.createInputsUpdate($ATRIBUTOS).'
                 <button type="submit" class="btn   my-3 btn-primary btn-sm">Actualizar</button>
             </form>
      </div>
  </section>

</kaiwik>

<style>
    .colo{
        color: blue;
    }
    .colo2{
        color: green;
    }
</style>


');
fflush($archivo);fclose($archivo);
function createInputsUpdate($atr){
  $str = '';
  $k=0;
  for (; $k < count($atr)  ; $k++) {
    $i = explode(':',$atr[$k]);
    $str.='<input name="'.$i[0].'" value="<?= $data->'.$i[0].' ?>" required  placeholder="'.$i[0].'"  class="form-control mb-3" />
                 ';
  }
  return $str;
}
// Create VISTA INDEX PUBLIC
$micarpeta = "vistas/$ENTIDAD";
if (!file_exists($micarpeta)) {
    mkdir($micarpeta, 0777, true);
}
$archivo = fopen("vistas/$ENTIDAD/index.kaiwik","w+b");
if($archivo == false ){
  echo "Error al crear el archivo";
  die();
}
fwrite($archivo,'<script>
    console.log("HOLA");
</script>

<kaiwik>

  <section >
      <div class="container pt-5">
        <h4>'.ucfirst($ENTIDAD).'</h4>
        <a href="/">Home<a/> / '.ucfirst($ENTIDAD).'
      </div>
  <section />

  <section >
      <div class="container py-3">

          <div class="row">
              <?php foreach ($data as $key => $value): ?>
                <div class="col-4 ">
                  <div class="card p-3 m-2">
                      <p class="text-muted"><?= $value->id?></p>
                        '.valueIndexList($ATRIBUTOS).'
                      <a href="/'.$ENTIDAD.'/<?= $value->id?>">Detalles</a>
                    </div>
                  </div>
              <?php endforeach; ?>
          </div>


      </div>
  </section>

</kaiwik>

<style>
    .colo{
        color: blue;
    }
    .colo2{
        color: green;
    }
</style>
');
fflush($archivo);fclose($archivo);
function valueIndexList($atr){
  $str = '';
  $k=0;
  for (; $k < count($atr)  ; $k++) {
    $i = explode(':',$atr[$k]);
    $str.='<p><?= $value->'.$i[0].' ?></p>
                 ';
  }
  return $str;
}

// Create VISTA READ
$micarpeta = "vistas/$ENTIDAD";
if (!file_exists($micarpeta)) {
    mkdir($micarpeta, 0777, true);
}
$archivo = fopen("paginas/panel/$ENTIDAD/update.php","w+b");
if($archivo == false ){
  echo "Error al crear el archivo";
  die();
}
fwrite($archivo,'<?php
 class Update  extends Context {
     private $context;
     function __construct($context){
         $this->context = $context;
         $this->context->title = "Inicio";
     }
     public function index($args = []){
         $html  = ($this->context->sessionExist())
            ?$this->context->create("_componentes/navLog")
            :$this->context->create("_componentes/nav");

         $data = $this->context->model('.$ENTIDAD.')->get($args[0]);
         $html .= $this->context->create("'.$ENTIDAD.'/update", $data[0]);

         $html  .= $this->context->create("_componentes/footer");
         return $this->context->ret($html);
     }
     public function put($arg = []){
       $this->context->model("'.$ENTIDAD.'")->update(
         '.createArgAdd($ATRIBUTOS).',
          $_POST["id"]
        );
         header("location:/panel/'.$ENTIDAD.'");
    }
}

?>

');
fflush($archivo);fclose($archivo);


// Create VISTA ENTIDAD
$micarpeta = "vistas/$ENTIDAD";
if (!file_exists($micarpeta)) {
    mkdir($micarpeta, 0777, true);
}
$archivo = fopen("paginas/$ENTIDAD.php","w+b");
if($archivo == false ){
  echo "Error al crear el archivo";
  die();
}
fwrite($archivo,'<?php
 class '.ucfirst($ENTIDAD).'  extends Context {
     private $context;
     function __construct($context){
         $this->context = $context;
         $this->context->title = "Inicio";
     }
     public function index($arg = []){
         $html  = ($this->context->sessionExist())
            ?$this->context->create("_componentes/navLog")
            :$this->context->create("_componentes/nav");

         if(count($arg)){
           $data = $this->context->model("'.$ENTIDAD.'")->get($arg[0])[0];
           $html .= $this->context->create("'.$ENTIDAD.'/show",$data);
         }else {
           $data = $this->context->model("'.$ENTIDAD.'")->gets();
           $html .= $this->context->create("'.$ENTIDAD.'/index", $data);
         }
         $html  .= $this->context->create("_componentes/footer");
         return $this->context->ret($html);
     }

}

?>
');
fflush($archivo);fclose($archivo);

// Create VISTA SHOW
$micarpeta = "vistas/$ENTIDAD";
if (!file_exists($micarpeta)) {
  mkdir($micarpeta, 0777, true);
}
$archivo = fopen("vistas/$ENTIDAD/show.kaiwik","w+b");
if($archivo == false ){
  echo "Error al crear el archivo";
  die();
}
fwrite($archivo,'<script>
    console.log("HOLA");
</script>

<kaiwik>

  <section >
      <div class="container pt-5">
        <h4> Detalles </h4>
        <a href="/">Home<a/> / <a href="/'.$ENTIDAD.'"> '.ucfirst($ENTIDAD).'<a/> / <?= $data->id?>
      </div>
  <section />

  <section>
      <div class="container py-5 ">
      '.valueShowList($ATRIBUTOS).'
      </div>
   </section>

</kaiwik>

<style>
    .colo{
        color: blue;
    }
    .colo2{
        color: green;
    }
</style>
');
fflush($archivo);fclose($archivo);
function valueShowList($atr){
  $str = '';
  $k=0;
  for (; $k < count($atr)  ; $k++) {
    $i = explode(':',$atr[$k]);
    $str.='<strong>'.$i[0].'</strong><p><?= $data->'.$i[0].' ?></p>
    ';
  }
  return $str;
}
?>
