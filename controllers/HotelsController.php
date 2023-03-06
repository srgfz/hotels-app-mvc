<?php

class HotelsController {

    //Instanciia del modelo y de la vista correspondiente:
    private $model;
    private $view;

    public function __construct() {
        $this->model = new HotelsModel();
        $this->view = new HotelsView();
    }

    //Funciones del controlador Hotels:
    /**
     * listHotels() --> Función que controla el listado de hoteles
     */
    public function listHotels() {
        $this->view->showHeader();
        $hotels = $this->model->getHotels();
        $this->view->showTitleListHotels();
        $this->view->showListHotels($hotels);
    }

    /**
     * listRooms() --> Función que controla el listado de habitaciones
     */
    public function listRooms() {
        $this->view->showHeader();
        //Guarardo el id del hotel a mostrar
        $idHotel = filtrarInput("hotel", "GET");
        $rooms = $this->model->getRooms($idHotel);
        if ($rooms) {//Si las habitaciones consultadas existen en la DB
            //Lo añado a un array aunque sea solo un elemento para poder usar la misma función de listar hoteles y así mostrar también los detalles del hotel
            $hotel [] = $this->model->getHotel($idHotel);
            $this->view->showListHotels($hotel, "col-12 bg-secondary text-light");
            $this->view->showListRooms($hotel[0]["nombre"], $rooms);
        } else {//Si no hay habitaciones para el hotel consultado
            $this->view->showAlert("<i class='bi bi-exclamation-diamond'></i> <strong>Hotel inexistente:</strong> "
                    . "no tenemos ningún registro del hotel al que intenta acceder", "alert-warning");
            $this->listHotels();
        }
    }
}
