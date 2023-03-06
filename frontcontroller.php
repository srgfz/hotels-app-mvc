<?php

session_start();
//Incluyo todos los archivos necesarios:
include "./resources/functions/frontControllerFunctions.php";
include "./resources/functions/filterFunctions.php";
include "./resources/functions/printHtmlFunctions.php";
//Controladores:
include "./controllers/LoginController.php";
include "./controllers/HotelsController.php";
include "./controllers/BookingsController.php";
//Modelos:
include "./models/LoginModel.php";
include "./models/HotelslModel.php";
include "./models/BookingsModel.php";
//Vistas:
include "./views/LoginView.php";
include "./views/HotelsView.php";
include "./views/BookingsView.php";

//Defino la acción y el controlador por defecto por defecto:
if (isset($_SESSION["token"]) && isset($_SESSION["user"])) {//Si existe la sesión el controlador y la acción por defecto será listar hoteles
    if (isset($_GET["controller"]) && $_GET["controller"] == "Bookings") {//Acción por defecto de Bookings
        define("DEFAULT_ACTION", "listBookings");
    } else {//Acción por defecto principal si ha iniciado sesión
        define("DEFAULT_ACTION", "listHotels");
        define("DEFAULT_CONTROLLER", "Hotels");
    }
} else {//Si no existe la sesión será el login y le redirijo al index sin parámetros
    define("DEFAULT_ACTION", "showLogin");
    define("DEFAULT_CONTROLLER", "Login");
    if(isset($_GET["controller"]) || isset($_GET["action"])) {//Si no existe la sesión e intenta acceder con algún parámetro en la url le redirijo al index sin parámetros
        header("Location: ./index.php");
    }
}



//Cargamos y ejecutamos el controlador y su acción correspondiente:
if (isset($_GET["controller"])) {//Si recibe un controlador ejecuto su acción
    if(!isset($_SESSION["token"]) ){//Si no tiene sesión iniciada le redirijo al index sin controlador (será el Login)
        header("Location: ./index.php");
    }
    $controller = loadController($_GET["controller"]);
    executeAction($controller);
} else {//En caso contrario ejecuto el controlador y la acción por defecto
    $controller = loadController(DEFAULT_CONTROLLER);
    executeAction($controller);
}