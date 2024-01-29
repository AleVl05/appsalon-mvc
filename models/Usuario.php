<?php 

namespace Model;

class Usuario extends ActiveRecord{
    //base de datos
    protected static $tabla ='usuarios';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'email' , 'password', 'telefono', 'admin', 'confirmado', 'token'];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;
    
    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->admin = $args['admin'] ?? '0';
        $this->confirmado = $args['confirmado'] ?? '0';
        $this->token = $args['token'] ?? '';
        }


        //validar errores
        public function validarNuevaCuenta(){
            if(!$this->nombre){
                self::$alertas['error'][] = 'El nombre es obligatorio';
            }
            if(!$this->apellido){
                self::$alertas['error'][] = 'El apellido es obligatorio';
            }
            if(!$this->telefono){
                self::$alertas['error'][] = 'El telefono es obligatorio';
            }
            if(!$this->email){
                self::$alertas['error'][] = 'El email es obligatorio';
            }
            if(!$this->password){
                self::$alertas['error'][] = 'La contraseña es obligatoria';
            }

            if(strlen($this->password) < 6){
                self::$alertas['error'][] = 'Tu contraseña es muy corta';
            }

            return self::$alertas;

        }

        public function validarLogin(){
            if(!$this->email){
                self::$alertas['error'][] = 'El email es obligatorio';
            }
            if(!$this->password){
                self::$alertas['error'][] = 'La contraseña es obligatoria';
            }
            return self::$alertas;
        }

        public function validarEmail(){
            if(!$this->email){
                self::$alertas['error'][] = 'El email es obligatorio';
            }
        }

        public function validarPassword(){
            if(!$this->password){
                self::$alertas['error'][] = 'La contraseña es obligatoria';
            }

            if(strlen($this->password) < 6){
                self::$alertas['error'][] = 'Tu contraseña es muy corta';
            }

            return self::$alertas;
        }

        public function existeUsuario(){
            $query = " SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";

            $resultado = self::$db->query($query); //va a retornar todo un objeto

            if($resultado->num_rows) { //osea, si el select retorna una linea es que encontro un usuario que solo puede ser el tuyo porque esta con el mismo email jaja
                self::$alertas['error'][] = 'El usuario ya esta registrado';
            }

            return $resultado;
        }

        public function hashPassword() {
            $this->password = password_hash($this->password, PASSWORD_BCRYPT);
        }

        public function crearToken(){
            $this->token = uniqid(); // apenas se cree un token se asigna a la varible y despues se manda al constructur del email para que asi te mande el mismo token que esta en esta variable :)
            
        }

        public function comprobarPasswordAndVerificado($passwordUsuario){
            $resultado = password_verify($passwordUsuario, $this->password);
            
            if(!$resultado || !$this->confirmado){
                
                self::$alertas['error'][] = 'Password incorrecto o cuenta no confirmada';
            }
            else {
                return true;
            }
        }
}