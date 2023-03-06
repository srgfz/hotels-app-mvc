<?php

class LoginController {

    //Instanciia del modelo y de la vista correspondiente:
    private $model;
    private $view;

    public function __construct() {
        $this->model = new LoginModel();
        $this->view = new LoginView();
    }

    //Funciones del controlador Login:

    /**
     * showLogin()--> Función que controla la acción de mostrar el login
     */
    public function showLogin() {
        //Compruebo si el usuario ha guardado su registro anteriormente:
        $userSaved = isset($_COOKIE["userLogin"]) ? $_COOKIE["userLogin"] : null;
        $passSaved = isset($_COOKIE["passLogin"]) ? $_COOKIE["passLogin"] : null;
        //Muestro la vista de Login
        $loginError = filtrarInput("loginError", "GET");
        $errorDB = filtrarInput("errorDB", "GET");
        if ($userSaved && $passSaved) {//Si había guardado el login
            $this->view->showLogin($userSaved, $passSaved, true, $loginError);
        } else {//Si no lo había guardado
            $this->view->showLogin("", "", false, $loginError);
        }
    }

    /**
     * processUserLogin() --> Función que controla el procesamiento de los datos introducidos por el usuario en el login
     */
    public function processUserLogin() {
        //Obtengo las credenciales introducidas por el usuario
        $user = filtrarInput("userLogin", "POST");
        $pass = filtrarInput("passLogin", "POST");
        try {//Si la DB está disponible
        } catch (Exception $ex) {//Si la DB no está disponible
            $this->view->showLogin($loginSaved[0], $loginSaved[1], true, $loginError);
        }
        //Compruebo las credenciales y redirijo al usuario dependiendo de si son correctas o no
        $userLogin = $this->model->getUserLogin($user, $pass);
        if ($userLogin) {//Si las credenciales son correctas
            //Compruebo si el usuario desea guardar la contraseña
            if (filtrarInput("saveLogin", "POST")) {//Si quiere guardar sus credenciales las almaceno en cookies
                $this->model->saveLogin($user, $pass);
            } else {//Si no marca la casilla eliminamos las cookies en caso de que las hubiera guardado anteriormente
                $this->model->removeUserSaved();
            }
            //Guardo la sesión:
            $this->model->addSessionData($user, $userLogin["id"]);
            header("Location: index.php"); //Redirijo directamente al index, ya que al haber iniciado sesión automáticamente mostrará la acción por defecto de iniciar sesión
        } else {//Si las credenciales no son correctas
            header("Location: index.php?loginError=1");
        }
    }

    /**
     * logOut() --> Función que controla el cierre de sesión
     */
    public function logOut() {
        $this->model->logOut();
    }

}
