<?php

namespace Controllers;

use Model\Admin;
use MVC\Router;

class LoginController{

    public static function login(Router $router){
        $errores = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $login = new Admin($_POST);

            $errores = $login->validar();

            if(empty($errores)){
                $resultado = $login->verifyUser();
                if(!$resultado){
                    $errores = Admin::getErrores();
                }else if($resultado){
                    $auth = $login->verifyPassword($resultado);

                    if($auth){
                        $login->autenticado();
                    }else{
                        $errores = Admin::getErrores();
                    }
                }
            }
        }

        $router->render('auth/login', [
            'errores' => $errores
        ]);
    }
    public static function logout(Router $router){
        $_SESSION = [];

        header('Location: /');
    }
}