<?php 

namespace Model;

class ActiveRecord {
        //DATABASE;
        protected static $db;
        protected static $columnasDB = [];
        protected static $tabla = '';

        //Errores
        protected static $errores = [];
    

        //Save values
        public function Save(){
            if(!is_null($this->id)){
                $this->update();
            }else{
                $this->create();
            }
        }
    
        //----------------CRUD--------------
    
        //Update Values
        public function update(){
            $atributos = $this->sanitizeData();
    
            $values = [];
            foreach($atributos as $key => $value){
                $values[] = "{$key}='{$value}'";
            }
    
            $insertValues = join(',', $values);
    
            $query = "UPDATE " . static::$tabla .  " SET " . $insertValues . "WHERE id = '" . self::$db->escape_string($this->id) . "' LIMIT 1;";
    
            $resultado = self::$db->query($query);
    
            if($resultado){
                header('Location: /propiedades/admin?resultado=2');
            }
    
        }
    
        //Delete Values From DB
    
        public function Delete(){
            $query = "DELETE FROM " . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1;";
    
            $resultado = self::$db->query($query);
    
            if($resultado){
                $this->deleteImage();
                header('location: /propiedades/admin?resultado=3');
            }
    
        }
        //Create New VALUES IN DATABASE
        public function create(){
    
            $atributos = $this->sanitizeData();
    
            $stringInsert = join(', ', array_keys($atributos));
            $stringValues = join("', '", array_values($atributos));
    
            
    
            $query = "INSERT INTO " . static::$tabla . " ( ";
            $query .= $stringInsert;
            $query .= " ) VALUES (' ";
            $query .= $stringValues;
            $query .= " '); ";
    
            
            $resultado = self::$db->query($query);
    
            if($resultado){
                header('Location: /propiedades/admin?resultado=1');
            }
        }
    
        //------------Utilities----------------
    
        //SYNC VALUES
    
        public function sync( $args = []){
            foreach($args as $key => $value){
                if(property_exists($this, $key) && !is_null($value)){
                    $this->$key = $value;
                }
            }
        }
    
        //VALIDATE INFO 
        public function validar(){
            static::$errores = [];
            return static::$errores;
        }
    
        //Query Select ALL
        public static function all(){
            $query = "SELECT * FROM " . static::$tabla;
    
            $resultado = self::query($query);
    
            return $resultado;
            
        }

        public static function get($limit){
            $query = "SELECT * FROM " . static::$tabla . " LIMIT ${limit}" ;
    
            $resultado = self::query($query);
    
            return $resultado;
            
        }
        //Query Select ALL WHERE
        public static function find($id){
            $query = "SELECT * FROM " . static::$tabla . " WHERE id = ${id}";
    
            $resultado = self::query($query);
    
            return array_shift($resultado);
    
        }
        
    
        //Bring data from db
        public static function query($query){
            //Query to Database
            $resultado = self::$db->query($query);
    
            //Iterar
            $array = [];
            while($registro = $resultado->fetch_assoc()){
                $array[] = static::ConvertToObject($registro);
            }
    
            //free Memory
            $resultado->free();
            
            return $array;
    
        }
    
        //CONVERT FROM ARRAY TO OBJECT
        protected static function ConvertToObject($registro){
            $object = new static;
    
            foreach($registro as $key => $value){
                if(property_exists($object, $key)){
                    $object->$key = $value;
                }
            }
    
            return $object;
        }
    
        
        //MAP INFO
        public function atributos(){
            $atributos = [];
            foreach(static::$columnasDB as $columna){
                if($columna === 'id') continue;
                $atributos[$columna] = $this->$columna;
            }
            return $atributos;
        }
    
        //SANITIZE DATA
        public function sanitizeData(){
            $atributos = $this->atributos();
            $sanitizado = [];
            foreach($atributos as $key => $value){
                $sanitizado[$key] = self::$db->escape_string($value);  
            }
            return $sanitizado;
        }
    
        //Delete previous image 
        public function deleteImage(){
            $fileExist = file_exists(CARPETA_IMG . $this->imagen);
                if($fileExist){
                    unlink(CARPETA_IMG . $this->imagen);
                }
        }
    
        //---------------SETTERS-----------------
        public static function setDB($database){
            self::$db = $database;
        }
    
    
        public function setImg($imagen){
            if(!is_null($this->id)){
                $this->deleteImage();
            }
            if($imagen){
                $this->imagen = $imagen;
            }
        }
    
        //---------------GETTERS-----------------
        public static function getErrores(){
            return static::$errores;
        }
    
    
    
}

?>