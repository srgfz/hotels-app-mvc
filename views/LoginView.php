<?php

class LoginView {
    /**
     * showLogin() --> Función de la vista general del login, que mostrará unos u otros elementos según sus parámetros
     * @param type $user --> usuario a rellenar en caso de que se haya seleccionado la casilla de Recuerdame. Por defecto estará en blanco
     * @param type $pass --> contraseña a rellenar en caso de que se haya seleccionado la casilla de Recuerdame. Por defecto estará en blanco
     * @param type $saveLogin --> Bool que indica si se ha guardado las credenciales anteriormente o no. Por defecto será false
     * @param type $loginError --> Bool que indica si el inicio de sesión ha sido exitoso o no
     */
    public function showLogin($user = "", $pass = "", $saveLogin = false, $loginError = false) {//Por defecto no muestro nada en los inputs
        printLogin($user , $pass , $saveLogin , $loginError );
    }

}
