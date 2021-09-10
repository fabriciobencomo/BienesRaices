<?php 
namespace Controllers;

use MVC\Router;
use Model\Propiedad;
use PHPMailer\PHPMailer\PHPMailer;

class PageController {
    public static function index(Router $router){
        $inicio = true;
        $propiedades = Propiedad::get(3);
        $router->render('pages/index',[
            'propiedades' => $propiedades,
            'inicio' => $inicio
        ]);
    }
    public static function nosotros(Router $router){
        $router->render('pages/nosotros',[
            
        ]);
    }
    public static function anuncios(Router $router){
        $propiedades = Propiedad::all();
        $router->render('pages/anuncios',[
            'propiedades' => $propiedades
        ]);
    }
    public static function anuncio(Router $router){
        $id = redirectOrValidate('/index');
        $propiedad = propiedad::find($id);
        $router->render('pages/anuncio',[
            'propiedad' => $propiedad
        ]);
    }
    public static function blog(Router $router){
        $router->render('pages/blog',[
            
        ]);
    }
    public static function entrada(Router $router){
        $router->render('pages/entrada',[
            
        ]);
    }
    public static function contacto(Router $router){
        $mensaje = null;

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $respuestas = $_POST['contacto'];

            //Configuracion SMTP
            $phpmailer = new PHPMailer();
            $phpmailer->isSMTP();
            $phpmailer->Host = 'smtp.mailtrap.io';
            $phpmailer->SMTPAuth = true;
            $phpmailer->Port = 2525;
            $phpmailer->Username = '8f5c775988f8c5';
            $phpmailer->Password = 'bcb7ee6b72fb9e';
            $phpmailer->SMTPSecure = 'tls';

            //configuracion de los mails
            $phpmailer->setFrom('admin@bienesraices.com');
            $phpmailer->addAddress('admin@bienesraices.com', 'bienesRaices.com');
            $phpmailer->Subject = 'Tienes un Mensaje Nuevo';

            //Habilitar html
            $phpmailer->isHTML(true);
            $phpmailer->CharSet = 'UTF-8';

            //Definir contenido
            $contenido = '<html>';
            $contenido .= '<p>Tienes un mensaje Nuevo </p>'  ;
            $contenido .= '<p>Nombre: ' .$respuestas['nombre'] . '</p>'  ;
            $contenido .= '<p>Mensaje: ' .$respuestas['mensaje'] . '</p>'  ;
            $contenido .= '<p>Vende o Compra: ' .$respuestas['tipo'] . '</p>'  ;
            $contenido .= '<p>Precio o Presupuesto: $' .$respuestas['precio'] . '</p>'  ;

            //Enviar de forma condicional los datos
            if($respuestas['contactar'] === 'telefono'){
                $contenido .= '<p>Medio a contactar: ' .$respuestas['contactar'] . '</p>'  ;
                $contenido .= '<p>Telefono: ' .$respuestas['telefono'] . '</p>'  ;
                $contenido .= '<p>Fecha de Contacto: ' .$respuestas['fecha'] . '</p>'  ;
                $contenido .= '<p>Hora: ' .$respuestas['hora'] . '</p>'  ;
            }elseif ($respuestas['contactar'] === 'email') {
                $contenido .= '<p>Medio a contactar: ' .$respuestas['contactar'] . '</p>'  ;
                $contenido .= '<p>E-mail: ' .$respuestas['email'] . '</p>'  ;
            }
            $contenido  .= '</html>';

            $phpmailer->Body = $contenido;
            $phpmailer->AltBody = "Sin html";

            //Enviar mail
            if($phpmailer->send()){
                $mensaje = "Su mensaje ha sido enviado";
            }else {
                $mensaje = "Su mensaje no pudo ser enviado ...";
            }

        }
        $router->render('pages/contacto',[
            'mensaje' => $mensaje
        ]);
    }

    
}