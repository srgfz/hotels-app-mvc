<?php

//Añado la base de datos
require_once __DIR__ . '/../db/DB.php';

class LoginModel {

    //Atributos
    private $db;

    //Constructor
    public function __construct() {
        $this->db = new DB();
    }

    //Métodos de la clase

    /**
     * getAll() --> Método para obtener todos los usuarios con todos sus campos de la tabla usuarios
     * @return --> devuelve un array multidimensional con todos los registros de ejecutar la consulta $query
     */
    public function getAll() {
        $query = $this->db->query('SELECT * FROM usuarios');
        //Cierro la BD
        unset($his->db);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * getUserLogin()--> Método para obtener todos los campos del usuario $user y contraseña $pass
     * @param type $user --> usuario introducido
     * @param type $pass --> contraseña introducida
     * @return type --> devuelve el array asociativo/objeto del usuario correspondiente a $user y $pass
     */
    public function getUserLogin($user, $pass) {
        $query = $this->db->query('SELECT * FROM usuarios WHERE nombre = :user AND contraseña = :pass', [':user' => $user, ':pass' => $pass]);
        //Cierro la BD
        unset($his->db);
        return $query->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * addSessionData() --> Función para guardar en sesión el user, el idUser y el token de sesión
     * @param type $user --> Nombre de usuario que ha iniciado sesión
     * @param type $idUser --> Id del usuario que ha iniciado sesión
     */
    public function addSessionData($user, $idUser) {
        $_SESSION["user"] = $user;
        $_SESSION["idUser"] = $idUser;
        $_SESSION["token"] = hash("sha256", session_id() . date("Y-n-j H:i:s")); //Guardo el token de la sesión
    }
    
    /**
     * saveLogin() --> Función para guardar en cookies la contraseña y el usuario en caso de que se haya selecionado la casilla Recuerdame
     * @param type $user --> usuario a guardar
     * @param type $pass --> contraseña a guardar
     */
    public function saveLogin($user, $pass) {
        setcookie("userLogin", $user, time() + 3600 * 24, "/");
        setcookie("passLogin", $pass, time() + 3600 * 24, "/");
    }

    /*
     * removeUserSaved)= --> Función para eliminar el usuario y la contraseña guardadas en caso de que desmarque la casilla de Recuerdame
     */
    public function removeUserSaved() {
        setcookie("userLogin", 123, time() - 1000, "/");
        setcookie("passLogin", 123, time() - 1000, "/");
    }

    /**
     * logOut() --> Función para cerrar sesión
     */
    public function logOut() {
        //Borramos el array de sesión y la destruimos
        $_SESSION = array();
        session_destroy();
        //Eliminamos las cookies de la sesión
        setcookie(session_name(), 123, time() - 1000, "/");
        //Le redirigimos al Login
        header("Location: ./index.php");
    }

}
