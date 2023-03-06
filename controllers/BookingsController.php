<?php

class BookingsController {

    //Instanciia del modelo y de la vista correspondiente:
    private $model;
    private $view;

    public function __construct() {
        $this->model = new BookingsModel();
        $this->view = new BookingsView();
    }

    //Funciones del controlador Hotels:

    /**
     * listBookings() --> Función para controlar el listado de las reservas del usuario
     */
    public function listBookings() {
        $this->view->showHeader();
        $idUser = $_SESSION["idUser"]; //Guardo el id del usuario
        $errorDate = filtrarInput("errorDate", "GET");
        if (isset($errorDate) && $errorDate == 1) {//Si ha habido un error en la reserva muestro un alert indicando el error
            $this->view->showAlert("<i class='bi bi-exclamation-diamond'></i> <strong>Error al realizar la reserva:</strong> "
                    . "las fechas de entrada y de salida deben estar rellenas y la fecha de salida no puede ser anterior a la fecha de entrada", "alert-warning");
        } else if (isset($errorDate) && $errorDate == 0) {//Si la reserva se ha realizado correctamente
            $this->view->showAlert("<i class='bi bi-info-circle'></i> <strong>Reserva realizada correctamente</strong>", "alert-info");
        } else if (isset($errorDate) && $errorDate == 2) {//Si la habitación no estaba disponible para las fechas indicadas
            $this->view->showAlert("<i class='bi bi-exclamation-diamond'></i> <strong>Error al realizar la reserva:</strong> "
                    . " la habitación no está disponible para las fechas indicadas, por favor, indique otras fechas", "alert-warning");
        }
        $bookings = $this->model->getBookings($idUser);
        $this->view->showTitleListBookings();
        $this->view->listBookings($bookings);
    }

    /**
     * showBook() --> Función para controlar el listado de la información de una reserva concreta
     */
    public function showBook() {
        $this->view->showHeader();
        //Guarardo el id del hotel, el id del usuario y el id de la habitación
        $idBook = filtrarInput("book", "GET");
        $idUser = $_SESSION["idUser"];
        $bookSelected = $this->model->getBook($idBook, $idUser);
        if ($bookSelected) {//Si existe la reserva para el id introducido la muestro
            //Lo añado a un array aunque sea solo un elemento para poder usar la misma función de listar que ya tengo
            $book [] = $bookSelected;
            $this->view->listBookings($book, "col-12 bg-secondary text-light");
        } else {
            $this->view->showAlert("<i class='bi bi-exclamation-diamond'></i> <strong>Reserva inexistente:</strong> "
                    . "no tenemos ningún registro de la reserva que desea consultar", "alert-warning");
            $this->listBookings();
        }
    }

    /**
     * addBooking() --> Función que controla la acción de añadir una reserva por parte del usuario
     */
    public function addBooking() {
        //Guardo las variables de la reserva:
        $idRoom = filtrarInput("idRoom", "GET"); //Para diferenciar entre los form que hay en la misma página
        $booking["id_usuario"] = $_SESSION["idUser"];
        $booking["id_hotel"] = filtrarInput("id_hotel$idRoom", "POST");
        $booking["id_habitacion"] = filtrarInput("id_habitacion$idRoom", "POST");
        $booking["fecha_entrada"] = filtrarInput("fecha_entrada$idRoom", "POST");
        $booking["fecha_salida"] = filtrarInput("fecha_salida$idRoom", "POST");
        if ($booking["fecha_salida"] > $booking["fecha_entrada"]) {//Si la fecha de salida es posterior a la de entrada hago la inserción a la BD
            if ($this->model->checkBookings($booking)) {//Si la habitación SÍ está disponible para las fechas indicadas
                $this->model->insertBooking($booking);
                header("Location: ./index.php?controller=Bookings&action=listBookings&errorDate=0");
            } else {//Si la habitación NO está disponible para las fechas indicadas
                header("Location: ./index.php?controller=Bookings&action=listBookings&errorDate=2");
            }
        } else {//Si la fecha de entrada y la de salida son iguales o la de entrada es posterior no realizo la reserva e indico el error
            header("Location: ./index.php?controller=Bookings&action=listBookings&errorDate=1");
        }
    }
}
