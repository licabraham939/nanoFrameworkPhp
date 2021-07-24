<?php
 class AdminCategorias  extends Context {
    private $context;
    function __construct($context){
        $this->context = $context;
        $this->context->title = "Categoria";
        if(!$context->sessionExist()) header("location:/");
    }
    public function index(){
         $usuario = $this->context->sessionUser();
        $html  = ($this->context->sessionExist())
           ?$this->context->create("_componentes/navLog")
           :$this->context->create("_componentes/nav");

        $html  .= $this->context->create("_componentes/title",[
            "title"=> "CRUD CATEGORIAS",
            "parrafo"=> "Si elimina una categoria tambien se eliminaran todos los productos asociados a el"
        ]);
        $html  .= $this->context->create("categoria/editar", [
            "categoriasList" => $this->context->model("categorias")->getsByUser($usuario->id)
        ]);

        $html  .= $this->context->create("_componentes/footer");
        return $this->context->ret($html);
    }

    public function add_categoria() {
        $usuario = $this->context->sessionUser();
        if($_POST["id"] == ""){
            $this->context->model("categorias")->create($usuario->id, $_POST["nombre"], $_POST["description"]);
        }
        else {
            // $nombre, $description, $id, $idUser
            $this->context->model("categorias")->update($_POST["nombre"], $_POST["description"], $_POST["id"], $usuario->id);
        }
        header("location:/adminCategorias");
    }
    public function remove_categoria($id) {
        $usuario = $this->context->sessionUser();
        $this->context->model("categorias")->delete($id[0], $usuario->id);
        header("location:/adminCategorias");
    }
}

 ?>
