<?php 

namespace MVC;

class Router {

    public $routeGET = [];
    public $routePOST = [];

    public function get($url, $fn){
        $this->routeGET[$url] = $fn;
    }

    public function post($url, $fn){
        $this->routePOST[$url] = $fn;
    }

    public function comporbarRutas(){
        session_start();

        $auth = $_SESSION['login'] ?? null;

        $routeAdmin = ['/admin', '/propiedades/crear', '/propiedades/actualizar', '/propiedades/eliminar', '/vendedores/crear',];

        $url = $_SERVER['PATH_INFO'] ?? '/';
        $method = $_SERVER['REQUEST_METHOD'];

        if($method === 'GET'){
            $fn = $this->routeGET[$url] ?? null;
        }else{
            $fn = $this->routePOST[$url] ?? null;
        } 

        if(in_array($url, $routeAdmin) && !$auth){
            header('Location: /');
        }

        if($fn){
            call_user_func($fn, $this);
        }else{
            echo "Pagina no encontrada";
        }
    }

    public function render($view, $data = []){

        foreach($data as $key => $value){
            $$key = $value;
        }
        ob_start();
        include_once __DIR__  . "/views/$view.php";

        $contenido = ob_get_clean();

        include_once __DIR__ . "/views/layout.php";
    }

}