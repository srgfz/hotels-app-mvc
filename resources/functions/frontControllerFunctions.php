<?php

/*** FUNCIONES DEL FRONTCONTROLLER***/
    /**
     * loadController() --> función para cargamos el controlador de la acción y devolver su instancia
     * @param type $controllerName -->Nombre del controlador que obtendremos del GET
     * @return \controller
     */
    function loadController($controllerName) {
        $controller = $controllerName . 'Controller';
        if (class_exists($controller)) {
            return new $controller();
        } else {
            // Si no existe la clase del controlador le redirecciono directamente al index con la acción por defecto
            header("Location: ./index.php");
        }
    }

    /**
     * executeAction() --> Función para comprobar la acción a realizar de un controlador dado
     * @param type $controller --> instancia del controlador creada anteriormente
     */
    function executeAction($controller) {
        if (isset($_GET["action"]) && method_exists($controller, $_GET["action"])) {
            loadAction($controller, $_GET["action"]);
        } else {
            loadAction($controller, DEFAULT_ACTION);
        }
    }

    /**
     * loadAction() --> Función para ejecutar un método de un controlador
     * @param type $controller --> Controlador que contiene la acción a ejecutar
     * @param type $action --> acción o método a ejecutar
     */
    function loadAction($controller, $action) {
        $controller->$action();
    }
