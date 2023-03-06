<?php

class BookingsView {

    //MÉTODOS DE LA VISTA:
    /**
     * showHeader() --> Función para mostrar el header
     */
    public function showHeader() {
        include_once "./resources/templates/header.php";
    }

    /**
     * listBookings() --> Función para mostrar el listado de las reservas
     * @param type $bookings
     */
    public function listBookings($bookings) {
        listBooking($bookings);
    }

    /**
     * showAlert() --> Función para mostrar mensajes de información al ususario en un alert
     * @param type $textContent --> Contenido que tendrá el alert
     * @param type $typeAlert --> Tipo de alert del que se trata. Por defecto será un alert de información.
     */
    public function showAlert($textContent, $typeAlert="alert-info") {
        printAlert($textContent, $typeAlert);
    }
    
    /**
     * showTitleListBookings() --> Función para mostrar el título de listar Reservas
     */
    public function showTitleListBookings(){
        echo "<h2 class='mx-5 mt-3'>Reservas:</h2>";
    }

}
