<?php

//Añado la base de datos
require_once __DIR__ . '/../db/DB.php';

class BookingsModel {

    //Atributos
    private $db;

    //Constructor
    public function __construct() {
        $this->db = new DB();
    }

    //Métodos de la clase

    /**
     * getBookings() --> Función para obtener las reservas de un usuario concreto
     * @param type $idUser --> id del usuario del que queremos obtener sus reservas
     * @return type --> devuelve un array multidimensional con todas las reservas de dicho usuario y los campos incluidos en el SELECT
     */
    public function getBookings($idUser) {
        $query = $this->db->query('SELECT reservas.id as "IdReserva", CONCAT(hoteles.nombre," (",hoteles.direccion, ", ",hoteles.pais,")") as "Hotel", '
                . 'CONCAT(habitaciones.tipo,", número ",habitaciones.num_habitacion) as "Habitación", fecha_entrada as "Fecha de entrada", '
                . 'fecha_salida as "Fecha de salida" FROM reservas INNER JOIN hoteles ON hoteles.id=reservas.id_hotel INNER JOIN habitaciones ON'
                . ' habitaciones.id=reservas.id_habitacion WHERE reservas.id_usuario = :id_usuario GROUP BY reservas.id', ["id_usuario" => $idUser]);
        //Cierro la BD
        unset($his->db);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * insertBooking() --> Función para insertar una nueva reserva
     * @param type $arrayInsert --> Array con los datos que queremos insertar en reservas. Sus claves deberan llamarse exatamente igual que los campos de la tabla
     */
    public function insertBooking($arrayInsert) {
        //Concateno los valores y las claves para la inserción a la DB:
        $values = "";
        $keys = "";
        foreach ($arrayInsert as $key => $value) {//Concatenamos el nombre de los campos (su clave) y los valores de dichas variables
            if (is_string($value)) {
                $values .= "'$value'";
            } else if (is_numeric($value)) {
                $values .= "$value";
            }
            $keys .= "$key";
            if ($key !== array_key_last($arrayInsert)) {//Si no es el último valor del array pongo la coma
                $values .= ", ";
                $keys .= ", ";
            }
        }
        $query = $this->db->query('INSERT INTO reservas (' . $keys . ') values (' . $values . ')');
        //Cierro la BD
        unset($his->db);
    }

    /**
     * getBook() --> Función para obtener una reserva concreta de la tabla reservas con todos los campos incluidos en el SELECT
     * @param type $idBook --> identificador de la reserva que queremos obtener
     * @param type $idUser --> identificador del usuario propietario de la reserva a obtener
     * @return type --> Array de la reserva con todos los campos incluidos en el SELECT
     */
    public function getBook($idBook, $idUser) {
        $query = $this->db->query('SELECT reservas.id as "IdReserva", CONCAT(hoteles.nombre," (",hoteles.direccion, ", ",hoteles.pais,")") as "Hotel", '
                . 'CONCAT(habitaciones.tipo,", número ",habitaciones.num_habitacion) as "Habitación", fecha_entrada as "Fecha de entrada", '
                . 'fecha_salida as "Fecha de salida" FROM reservas INNER JOIN hoteles ON hoteles.id=reservas.id_hotel INNER JOIN habitaciones ON'
                . ' habitaciones.id=reservas.id_habitacion WHERE reservas.id = :idBook AND reservas.id_usuario = :idUser GROUP BY reservas.id', [':idBook' => $idBook, ':idUser' => $idUser]);
        //Cierro la BD
        unset($his->db);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * checkBook() --> Función para comprobar si ya exite una habitación
     * @param type $arrayToInsert
     * @return type
     */
    public function getBookingsOfRoom($id_hotel, $id_habitacion) {
        $query = $this->db->query("SELECT * FROM reservas WHERE id_hotel = :id_hotel AND id_habitacion = :id_habitacion;",
                [':id_hotel' => $id_hotel, ':id_habitacion' => $id_habitacion]);
        //Cierro la BD
        unset($his->db);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * filterBookings() --> función para comprobar si la habitación ya está reservada para las fechas solicitadas
     * @param type $newBooking --> Array con los datos de l anueva reserva
     * @return boolean --> bool que será true si la habitación no está reservada para las fechas indicadas y false en caso contrario
     */
    public function checkBookings($newBooking) {
        $bookings = $this->getBookingsOfRoom($newBooking["id_hotel"], $newBooking["id_habitacion"]);
        $addBook = true;
        print_r($bookings);

        foreach ($bookings as $row) {
            if (($newBooking["fecha_entrada"] > $row["fecha_entrada"] && $newBooking["fecha_entrada"] < $row["fecha_salida"]) ||
                    ($newBooking["fecha_salida"] > $row["fecha_entrada"] && $newBooking["fecha_salida"] < $row["fecha_salida"])) {//Si la habitación ya está reservada para esas fechas
                $addBook = false;
            }
        }
        return $addBook;
    }

}
