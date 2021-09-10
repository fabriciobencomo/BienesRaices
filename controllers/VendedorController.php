<?php 

namespace Controllers;
use MVC\Router;
use Model\Vendedor;

class VendedorController{

    public static function create(Router $router){
        $vendedor = new Vendedor();

        $errores = Vendedor::getErrores();

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $vendedor = new Vendedor($_POST['vendedor']);

            $errores = $vendedor->validar();

            if(empty($errores)){
                $vendedor->Save();
            }
        }


        $router->render("vendedores/crear", [
            'vendedor' => $vendedor,
            'errores' => $errores

        ]);
    }

    public static function update(Router $router){
        $id = redirectOrValidate('/vendedores/actualizar');
        $vendedor = Vendedor::find($id);
        $errores = Vendedor::getErrores();

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $args = $_POST['vendedor'];
        
            $vendedor->sync($args);
        
            $errores = $vendedor->validar();
        
            if(empty($errores)){
                $vendedor->Save();
            }
        }

        $router->render("vendedores/actualizar", [
            'vendedor' => $vendedor,
            'errores' => $errores
        ]);
    }

    public static function delete(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);
            if($id){
                $tipo = $_POST['tipo'];
                if(validarTipoContenido($tipo)){
                    $vendedor = Vendedor::find($id);
                    $vendedor->Delete();
                }
        
            }
        }
    }
}