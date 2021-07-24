<?php
 class Admin  extends Context {
     private $context;
     function __construct($context){
         $this->context = $context;
         $this->context->title = "Inicio";
         if(!$context->sessionExist()){
             header("location:/");
             die();             
         }
     }
     public function index(){
         $usuario = $this->context->sessionUser();
         $html  = $this->context->create("_componentes/navLog");
         $html  .= $this->context->create("_componentes/title",[
             "title" => "ADMIN"
         ]);
          $html  .= $this->context->create("admin",[
              "name" => "General",
              "cards" => $this->getGeneralCard()
          ]);
           if($usuario->status == 1){
          $html  .= $this->context->create("admin",[
              "name" => "Modelo",
              "cards" => $this->getModelCard()
          ]);
        }
           if($usuario->rol == 1){
               $html  .= $this->context->create("admin",[
                   "name" => "Administrador",
                   "cards" => $this->getAdminCard()
               ]);
           }
         $html  .= $this->context->create("admin");
         $html  .= $this->context->create("_componentes/footer");
         return $this->context->ret($html);
     }

     private function getGeneralCard()  {
         return [
             [
                 "img" => "https://hpanel.hostinger.com/img/order_set_main_domain.10879899.svg",
                 "title" => "Mis datos",
                 "url" => "/adminMy"
            ],
             [
                 "img" => "https://hpanel.hostinger.com/img/order_order_usage.d9ce7403.svg",
                 "title" => "Cuenta",
                 "url" => "/"
            ],
             [
                 "img" => "https://hpanel.hostinger.com/img/website_seo.1260fda2.svg",
                 "title" => "Pasarela de pagos",
                 "url" => "/"
            ],
        ];
     }
     private function getModelCard()  {
         return [
             [
                 "img" => "https://hpanel.hostinger.com/img/website_digital_marketing.7c5b297e.svg",
                 "title" => "Productos",
                 "url" => "/adminProductos"
            ],
             [
                 "img" => "https://hpanel.hostinger.com/img/website_business_service.969ff456.svg",
                 "title" => "Categorias",
                 "url" => "/adminCategorias"
            ],
             [
                 "img" => "https://hpanel.hostinger.com/img/migrations_requests.15111741.svg",
                 "title" => "Pedidos",
                 "url" => "/adminPedidos"
            ],
             [
                 "img" => "https://hpanel.hostinger.com/img/website_auto_installer.eaa6f3a6.svg",
                 "title" => "Completadas",
                 "url" => "/"
            ],
        ];
     }
     private function getAdminCard()  {
         return [
             [
                 "img" => "https://hpanel.hostinger.com/img/files_ftp_accounts.72c05a65.svg",
                 "title" => "Usuarios",
                 "url" => "/adminUsuarios"
            ],
             [
                 "img" => "https://hpanel.hostinger.com/img/wordpress_plugins.6d247aba.svg",
                 "title" => "Estadisticas",
                 "url" => "/"
            ],
        ];
     }
}

?>
