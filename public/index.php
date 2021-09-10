<?php
require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\PropiedadController; 
use Controllers\VendedorController; 
use Controllers\PageController;
use Controllers\LoginController;


$router = new Router();

//---- GET -----
$router->get('/', [PageController::class,'index']);
$router->get('/nosotros', [PageController::class,'nosotros']);
$router->get('/anuncios', [PageController::class,'anuncios']);
$router->get('/anuncio', [PageController::class,'anuncio']);
$router->get('/contacto', [PageController::class,'contacto']);
$router->get('/blog', [PageController::class,'blog']);
$router->get('/entrada', [PageController::class,'entrada']);


//---- POST -----
$router->post('/contacto', [PageController::class,'contacto']);

//-----Autenticacion
$router->get('/login',  [LoginController::class,'login']);
$router->get('/signup',  [LoginController::class,'create']);
$router->post('/login',  [LoginController::class,'login']);
$router->get('/logout',  [LoginController::class,'logout']);

//---------------------CRUD-------------------------------
//---- GET -----
//---Propiedades---
$router->get('/admin', [PropiedadController::class,'index']);
$router->get('/propiedades/crear', [PropiedadController::class,'create']);
$router->get('/propiedades/actualizar', [PropiedadController::class,'update']);

//---Vendedores---
$router->get('/vendedores/crear', [VendedorController::class,'create']);
$router->get('/vendedores/actualizar', [VendedorController::class,'update']);


//---- POST -----
$router->post('/propiedades/crear', [PropiedadController::class,'create']);
$router->post('/propiedades/actualizar', [PropiedadController::class,'update']);
$router->post('/propiedades/eliminar', [PropiedadController::class,'delete']);

//---Vendedores---
$router->post('/vendedores/eliminar', [VendedorController::class,'delete']);
$router->post('/vendedores/crear', [VendedorController::class,'create']);
$router->post('/vendedores/actualizar', [VendedorController::class,'update']);



$router->comporbarRutas();