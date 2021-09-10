<?php 

namespace Model;

class Vendedor extends ActiveRecord{

        protected static $tabla = 'vendedores';

        protected static $columnasDB = ['id', 'nombre', 'apellido', 'telefono'];

        //PROPIERTIES
        public $id;
        public $nombre;
        public $apellido;
        public $telefono;

        //CONSTRUCTOR
        public function __construct($args = [])
        {
            $this->id = $args['id'] ?? null;
            $this->nombre = $args['nombre'] ?? '';
            $this->apellido = $args['apellido'] ?? '';
            $this->telefono = $args['telefono'] ?? '';
   
        }

        //VALIDATE INFO 
       public function validar(){
        if(!$this->nombre){
            self::$errores[] = 'Debes añadir un Nombre';
        }

        if(!$this->apellido){
            self::$errores[] = 'Debes añadir un apellido';
        }

        if(!$this->telefono){
            self::$errores[] = 'Debes añadir un telefono';
        }

        if(!preg_match('/[0-9]{10}/', $this->telefono)){
            self::$errores[] = 'Formato de telefono incorrecto';
        }

            return self::$errores;
       
        }
}