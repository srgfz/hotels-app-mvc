<?php

//Añado la base de datos
require_once __DIR__ . '/../db/DB.php';


class HotelsModel {
    //Atributos
    private $db;
    
    //Constructores
    public function __construct() {
        $this->db = new DB();
    }
    
    //Métodos de la clase
    /**
     * getHotels() --> Método para obtener todos los hoteles con los campos introducdos en el SELECT
     * @return --> devuelve un array multidimensional con todos los registros de ejecutar la consulta $query, en este caso con todos los hoteles
     */
    public function getHotels() {
        $query = $this->db->query('SELECT hoteles.id, nombre, direccion as "Dirección", ciudad, pais as "País", num_habitaciones as "Número de Habitaciones", hoteles.descripcion as "Descripción", COUNT(habitaciones.id) as "Habitaciones Disponibles" FROM hoteles'
                . ' INNER JOIN habitaciones ON hoteles.id=habitaciones.id_hotel GROUP BY hoteles.id');
        //Cierro la BD
        unset($his->db);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    
    //Métodos de la clase
    /**
     * getAll() --> Método para obtener todas las habitaciones con todos sus respectivos campos
     * @return --> devuelve un array multidimensional con todos los registros de ejecutar la consulta $query, en este caso con todas las habitaciones
     */
    public function getAllRooms() {
        $query = $this->db->query('SELECT * FROM habitaciones');
        //Cierro la BD
        unset($his->db);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * getHotel() --> Función para obtener el hotel correspondiente al id $hotelId con los campos incluidos en el SELECT
     * @param type $hotelId --> id del hotel que queremos consultar a la DB
     * @return type --> devuelve un array con todos los campos del hotel $hotelId
     */
    public function getHotel($hotelId) {
        $query = $this->db->query('SELECT hoteles.id, nombre, direccion as "Dirección", ciudad, pais as "País", num_habitaciones as "Número de Habitaciones", hoteles.descripcion as "Descripción" FROM hoteles WHERE id = :idHotel', [':idHotel' => $hotelId]);
        //Cierro la BD
        unset($his->db);
        return $query->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * getRooms() --> Función para obtener todas las habitaciones correspondientes al hotel con el id $idHotel
     * @param type $hotelId --> id del hotel del que queremos consultar sus habitaciones
     * @return type --> devuelve un array multidimensional con todos los registros de ejecutar la consulta $query, en este caso con todas las habitaciones del hotel
     */
    public function getRooms($idHotel) {
        $query = $this->db->query('SELECT id, id_hotel, num_habitacion as "Número de Habitación", tipo, CONCAT(precio, " €") as "Precio", descripcion as "Descripción" FROM habitaciones WHERE id_hotel = :idHotel', [':idHotel' => $idHotel]);
        //Cierro la BD
        unset($his->db);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
