<?php
/**
 * CONEXION CON LA BASE DE DATOS
 */
class DB{
  private $pdo;

  function __construct($host, $ddbb, $user, $pass){
    $link = 'mysql:host='.$host.';dbname='.$ddbb;
    try {
        $this->pdo = new PDO($link, $user, $pass);
    } catch (PDOException $e){
        print "¡Error!: " . $e->getMessage() . "<br/>";
        die();
    }
  }

  public function consult($sql,$array){
    $sentencia = $this->pdo->prepare($sql);
    $sentencia->execute($array);
    $datos = $sentencia->fetchAll(PDO::FETCH_CLASS);
    return $datos;
  }
}


 ?>
