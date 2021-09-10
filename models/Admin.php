<?php 

namespace Model;

class Admin extends ActiveRecord{
    
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'email', 'password'];

    public $id;
    public $email;
    public $password;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
    }

    public function validar(){
        if(!$this->email){
            self::$errores[] = "El email es Obligatorio";
        }
        if(!$this->password){
            self::$errores[] = "La Contraseña es Obligatoria";
        }

        return self::$errores;
    }

    public function verifyUser(){
        $query = "SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";

        $resultado = self::$db->query($query);

        if(!$resultado->num_rows){
            self::$errores[] = "No existe ninguna cuenta asociada al email";
            return;
        }

        return $resultado;
    }

    public function verifyPassword($resultado){
        $usuario = $resultado->fetch_object();

        $auth = password_verify($this->password, $usuario->password);

        if(!$auth){
            self::$errores[] = "Contraseña Incorrecta";
        }

        return $auth;
    }

    public function autenticado(){
        session_start();

        $_SESSION['usuario'] = $this->email;
        $_SESSION['login'] = true;

        header('Location: /admin');
    }   

}