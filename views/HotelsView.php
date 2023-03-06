<?php

class HotelsView {

    //MÉTODOS DE LA VISTA:
    
    /**
     * showHeader() --> Función para mostrar el header
     */
    public function showHeader() {
        include_once "./resources/templates/header.php";
    }
    
    /**
     * showListHotels() --> Función para mostrar los hoteles listados
     * @param type $hotels --> array bidimensional de los hoteles que deseamos mostarar con sus campos
     * @param type $classNames --> classes a incluir en el hotel para destacarlo de los demás elementos. Por defecto estará en blanco.
     */
    public function showListHotels($hotels, $classNames = "") {
        listHotels($hotels, $classNames);
    }
    
    /**
     * showListRooms() --> Función para mostrar el hotel al que ha selecionado y todas sus habitaciones disponibles
     * @param type $hotelName --> Nombre del hotel del que vamos a mostrar sus habitaciones que imprimiremos como título
     * @param type $rooms --> Array multidimensioonal con las habitaciones que queremos listar
     */
    public function showListRooms($hotelName, $rooms) {
        echo"<h2 class='mx-5 ps-4'>Habitaciones disponibles del $hotelName:</h2>";
        listRooms($rooms);
    }

    /**
     * showAlert() --> Función para mostrar un alert indicando de alguna información al usuario
     * @param type $textContent --> Texto del alert
     * @param type $typeAlert --> Tipo de alert
     */
    public function showAlert($textContent, $typeAlert) {
        printAlert($textContent, $typeAlert);
    }
    
    /**
     * showTitleListHotels() --> Función para mostrar el título de Hoteles en su listado
     */
    public function showTitleListHotels(){
        echo "<h2 class='mx-5 mt-3'>Hoteles:</h2>";
    }

}
