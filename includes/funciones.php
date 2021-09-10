<?php
define('TEMPLATES_URL', __DIR__ . '/templates/');
define('FUNCIONES_URL', __DIR__ . 'funciones.php');
define('CARPETA_IMG', $_SERVER['DOCUMENT_ROOT'] . '/imagenes/');

function incluirTemplates( string $nombre, bool $inicio = false ){
    include TEMPLATES_URL . "${nombre}.php";
}

function autenticacion(){
    session_start();
    if(!$_SESSION['login']){
        header('Location: /');
    }
}

function debug($var){
    echo "<pre>";
    var_dump($var);
    echo "</pre>";
    exit;
}

//Sanitize Values in Inputs

function s($html){
    $s = htmlspecialchars($html);
    return $s;
}

// Validar entrada de dato correcto

function validarTipoContenido($tipo){
    $tipos = ['propiedad', 'vendedor'];

    return in_array($tipo, $tipos);
}

function mostarAlerta($codigo){
    $mensaje = '';

    switch($codigo){
        case 1:
            $mensaje = 'Creado Correctamente';
            break;
        case 2:
            $mensaje = 'Actualizado Correctamente';
            break;
        case 3:
            $mensaje = 'Eliminado Correctamente';
            break;
        default:
            $mensaje = false;
            break;
    }

    return $mensaje;
}

function redirectOrValidate(string $url){
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);
    if(!$id){
        header("Location: ${url}");
    }

    return $id;
}