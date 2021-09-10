<?php 

namespace Controllers;
use MVC\Router;
use Model\Propiedad;
use Model\Vendedor;
use Intervention\Image\ImageManagerStatic as Image;

class PropiedadController{

    public static function index(Router $router){

        $resultado = $_GET['resultado'] ?? null;
        $propiedades = Propiedad::all();
        $vendedores = Vendedor::all();

        $router->render("propiedades/admin",[
            'propiedades' => $propiedades,
            'resultado' => $resultado,
            'vendedores' => $vendedores
        ]);
    }

    public static function create(Router $router){
        $propiedad = new Propiedad();
        $vendedores = Vendedor::all();

        $errores = Propiedad::getErrores();

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $propiedad = new Propiedad($_POST['propiedad']);
        
            if(!is_dir(CARPETA_IMG)){
        
                mkdir(CARPETA_IMG);
            }
        
            $nombreImagen = md5( uniqid( rand(), true)) . ".jpg";
        
            if($_FILES['propiedad']['tmp_name']['imagen']){
                $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
                $propiedad->setImg($nombreImagen);
            }
        
            $errores = $propiedad->validar();
        
            if(empty($errores)){
        
                $image->save(CARPETA_IMG . $nombreImagen);
        
                $propiedad->Save();
            }
            
        }

        $router->render("propiedades/crear", [
            'propiedad' => $propiedad,
            'vendedores' => $vendedores,
            'errores' => $errores
        ]);
    }

    public static function update(Router $router){
        $id = redirectOrValidate('/propiedades/admin');
        $propiedad = Propiedad::find($id);
        $errores = Propiedad::getErrores();
        $vendedores = Vendedor::all();

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            //Lleanmos el array
            $args = $_POST['propiedad'];
        
            //Sincronizamos los datos 
            $propiedad->sync($args);
        
            //Validamos si hay errores
            $errores = $propiedad->validar();
        
            //Genera nombre random
            $nombreImagen = md5( uniqid( rand(), true)) . ".jpg";
        
            //Subimos Imagen
           
            if($_FILES['propiedad']['tmp_name']['imagen']){
                $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
                $propiedad->setImg($nombreImagen);
            }
        
           if(empty($errores)){
        
            if($_FILES['propiedad']['tmp_name']['imagen']){
                $image->save(CARPETA_IMG . $nombreImagen);
            }
        
            $propiedad->Save();
        
            } 
        }

        $router->render("propiedades/actualizar", [
            'propiedad' => $propiedad,
            'errores' => $errores,
            'vendedores' => $vendedores
        ]);
    }

    public static function delete(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);
            if($id){
                $tipo = $_POST['tipo'];
                if(validarTipoContenido($tipo)){
                    $propiedad = propiedad::find($id);
                    $propiedad->Delete();
                }
        
            }
        }
    }
}