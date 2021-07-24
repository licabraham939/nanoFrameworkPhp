<?php
 class AdminProductos  extends Context {
     private $context;
     function __construct($context){
         $this->context = $context;
         $this->context->title = "About";
     }
     public function index(){
         $usuario = $this->context->sessionUser();
         $html  = ($this->context->sessionExist())
            ?$this->context->create("_componentes/navLog")
            :$this->context->create("_componentes/nav");

        $html  .= $this->context->create("_componentes/title",[
            "title" => "Productos"
        ]);
         $html  .= $this->context->create("productos/editar",[
             "productosList" => $this->context->model("producto")->gets($usuario->id)
         ]);
         $html  .= $this->context->create("_componentes/footer");
         return $this->context->ret($html);
     }

     function add(){
         $usuario = $this->context->sessionUser();
         $html  = ($this->context->sessionExist())
            ?$this->context->create("_componentes/navLog")
            :$this->context->create("_componentes/nav");

         $html  .= $this->context->create("productos/add",[
             "categorias" => $this->context->model("categorias")->getsByUser($usuario->id)
         ]);
         $html  .= $this->context->create("_componentes/footer");
         return $this->context->ret($html);
     }


     public function add_producto( ) {
         $this->context->model("producto")->create(
             $_POST["name"],$_POST["description"],  $_POST["img"],
               $_POST["id_categoria"] , $_POST["price"]
          );
           header("location:/adminProductos");
     }
     public function update_producto( ) {
         $this->context->model("producto")->update(
             $_POST["name"],$_POST["description"],  $_POST["img"],
               $_POST["id_categoria"] , $_POST["price"],  $_POST["id"]
          );
           header("location:/adminProductos");
     }
     public function remove_producto($args ) {
         $id = $args[0];
         $this->context->model("producto")->delete($id );
           header("location:/adminProductos");
     }
     function update($args){
         $id = $args[0];
          $usuario = $this->context->sessionUser();
         $html  = ($this->context->sessionExist())
            ?$this->context->create("_componentes/navLog")
            :$this->context->create("_componentes/nav");

         $html  .= $this->context->create("productos/update",[
              "producto" => $this->context->model("producto")->get($id)[0],
             "categorias" => $this->context->model("categorias")->getsByUser($usuario->id)
         ]);
         $html  .= $this->context->create("_componentes/footer");
         return $this->context->ret($html);
     }

}

?>
