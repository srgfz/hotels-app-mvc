<?php

/*** FUNCIONES PARA MOSTRAR INFORMACIÓN EN HTML***/
    /**
     * listArray() --> Función para listar un array dado. La uso para listar los campos de un registro
     * @param type $array --> array del que deseamos listar sus elementos
     */
    function listArray($array) {
        foreach ($array as $key => $value) {
            echo "<div class='d-flex flex-column justify-content-center'><span class='fw-bold'>" . ucfirst($key) . " </span>";
            echo "<span class='ps-2'>" . ucfirst($value) . "</span></div>";
        }
    }

    /**
     * listRooms() --> Función para listar las habitaciones junto a su botón modal para realizar la reserva de dicha habitación
     * @param type $array --> Array bidimensional con todas las habitaciones que deseamos listar y en ellas sus respectivos campos
     */
    function listRooms($array) {
        echo '<ul class="list-group col-10 mx-auto gap-4 my-5">';
        foreach ($array as $item) {
            echo '<li class="shadow-sm list-group-item d-flex flex-row justify-content-around align-items-center rounded py-3">';
            listArray(filterArray($item, "id", false)); //Que no muestre los ids
            showModalToBook($item);
            echo "</li>";
        }
        echo '</ul>';
    }

    /**
     * filterArray() --> Función que filtra los elementos de un array según el nombre de su $key
     * @param type $array --> Array que deseamos filtrar
     * @param type $keyToFilter --> string determinará qué variables se filtran según si sus $key lo contienen o no
     * @param type $show --> Bool que será true si queremos que el $key SÍ contenta $keyToFilter y será false si queremos que filtre las que no contienen $keyToFilter
     * @return type --> devuelve el array filtrado
     */
    function filterArray($array, $keyToFilter, $show = true) {
        $filteredArray = [];
        foreach ($array as $key => $value) {
            if ($show && str_contains($key, $keyToFilter)) {//Si quiero filtrar los que SÍ tengan $keyToFilter
                $filteredArray[$key] = $value;
            } else if (!$show && !str_contains($key, $keyToFilter)) {//Si quiero filtrar los que NO tengan $keyToFilter
                $filteredArray[$key] = $value;
            }
        }
        return $filteredArray;
    }

    /**
     * listHotels() --> Función para listar los hoteles
     * @param type $array --> Array bidimensional de los hoteles con sus respectivos campos
     * @param type $classNames --> Clases para distinguir elementos en caso de destacar algún hotel. Por defecto estará vacío
     */
    function listHotels($array, $classNames = "") {
        echo '<ul class="list-group col-11 mx-auto gap-4 my-5">';
        foreach ($array as $item) {
            echo '<li>';
            echo '<a href="' . $_SERVER["PHP_SELF"] . '?controller=Hotels&action=listRooms&hotel=' . $item["id"] . '" '
            . 'class="shadow list-group-item d-flex flex-row justify-content-around align-items-center rounded py-3 ' . $classNames . '">';
            listArray(filterArray($item, "id", false)); //Que no muestre los ids
            echo "</a>";
            echo "</li>";
        }
        echo '</ul>';
    }

    /**
     * listBooking() --> Función para listar las reservas
     * @param type $bookings --> Array bidimensional de las reservas con sus respectivos campos
     */
    function listBooking($bookings) {
        echo '<ul class="list-group col-11 mx-auto gap-4 my-5">';
        foreach ($bookings as $item) {
            echo '<li>';
            echo '<a href="' . $_SERVER["PHP_SELF"] . '?controller=Bookings&action=showBook&book=' . $item["IdReserva"] . '" '
            . 'class="shadow list-group-item d-flex flex-row justify-content-around align-items-center rounded py-3">';
            listArray(filterArray($item, "IdReserva", false)); //Que no muestre los ids IdReserva
            echo "</a>";

            echo "</li>";
        }
        echo '</ul>';
    }

    /**
     * showModalToBook() --> Función para imprimir los botones modales y la ventana modal de un elemento dado, en este caso una reserva
     * @param type $roomToBook --> Array con los campos de la reserva de la que queremos hacer su modal
     */
    function showModalToBook($roomToBook) {
        echo '<!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#' . $roomToBook["tipo"] . $roomToBook["id"] . $roomToBook["id_hotel"] . '">
      Reservar
    </button>

    <!-- Modal -->
    <div class="modal fade" id="' . $roomToBook["tipo"] . $roomToBook["id"] . $roomToBook["id_hotel"] . '" tabindex="-1" aria-labelledby="' . $roomToBook["tipo"] . $roomToBook["id"] . $roomToBook["id_hotel"] . 'Label" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="' . $roomToBook["tipo"] . $roomToBook["id"] . $roomToBook["id_hotel"] . 'Label">Selecciona las fechas de tu reserva</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form class="p-3" method="POST" action="' . $_SERVER["PHP_SELF"] . '?controller=Bookings&action=addBooking&idRoom=' . $roomToBook["id"] . '">
           <div class="modal-body col-11 mx-auto d-flex justify-content-evenly">
            <input type="hidden" name="id_hotel' . $roomToBook["id"] . '" value="' . $roomToBook["id_hotel"] . '">
            <input type="hidden" name="id_habitacion' . $roomToBook["id"] . '" value="' . $roomToBook["id"] . '">
          <div class="d-flex flex-column">
            <label class="fw-bold">Fecha de Entrada</label>
            <input class="ms-3" type="date" name="fecha_entrada' . $roomToBook["id"] . '" min="' . date("Y-m-d") . '" required>
          </div>
          <div class="d-flex flex-column">
            <label class="fw-bold">Fecha de Entrada</label>
            <input class="ms-3" type="date" name="fecha_salida' . $roomToBook["id"] . '" min="' . date("Y-m-d") . '" required>
          </div>
          </div>
          <div class="modal-footer d-flex justify-content-center my-3">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Hacer Reserva</button>
          </div>
          </form>
        </div>
      </div>
    </div>';
    }

    /**
     * printAlert() --> Función para mostrar un alert para mostrar distintos mensajes de información al usuario
     * @param type $textContent --> Contenido del alert
     * @param type $alertType --> Tipo de alert
     */
    function printAlert($textContent, $alertType) {
        echo '<div class="alert ' . $alertType . ' alert-dismissible fade show col-11 mx-auto mt-3" role="alert">
        ' . $textContent . '
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    }
    
    function printLogin($user = "", $pass = "", $saveLogin = false, $loginError = false){
               echo '<div class="row col-5 border border-3 rounded position-absolute top-50 start-50 translate-middle p-5 login">
            <h1 class=" row fs-3 mb-5 justify-content-center login__header">Ejercicio Reservas Hoteles</h1>
            <ul class="nav nav-pills mb-3 justify-content-center" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home"
                            type="button" role="tab" aria-controls="pills-home" aria-selected="true">Iniciar Sesión</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link " id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile"
                            type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Regístrate</button>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab"
                     tabindex="0">
                    <!-- Form de Inicio de sesión -->
                    <form action="' . $_SERVER["PHP_SELF"] . '?controller=Login&action=processUserLogin" method="POST" class="form text-dark">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control bg-light opacity-75" id="floatingInput" placeholder="User" name="userLogin" value="' . $user . '">
                            <label for="floatingInput" class="ps-4"><i class="bi bi-person-circle"></i> Usuario</label>
                        </div>
                        <div class="form-floating">
                            <input type="password" class="form-control bg-light opacity-75" id="floatingPassword"
                                   placeholder="Password" name="passLogin" value="' . $pass . '">
                            <label for="floatingPassword" class="ps-4"> <i class="bi bi-key-fill"></i> Contraseña</label>
                        </div>';
                            if (isset($loginError) && $loginError) {//Credenciales incorrectas
                                echo '<div class="row p-2">
                                                                <p class="text-danger m-0"> * Usuario y/o contraseña incorrecta</p>
                                                              </div>';
                            }
                            echo '<div class="mb-3 form-check py-2 mt-1 color-white">
                                                <input type="checkbox" class="form-check-input" id="exampleCheck1" name="saveLogin" ';
                            if ($saveLogin) {
                                echo "checked";
                            }
                            echo ' value="1">
                            <label class="form-check-label text-light" for="exampleCheck1">Recuérdame</label>
                        </div>
                        <div class="row">
                            <button type="submit" class="btn btn-outline-light m-auto mt-2 mx-auto col-5 fs-5 py-2">Iniciar
                                Sesión</button>
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
                    <!-- Form de Registro -->
                    <form class="form text-dark" method="POST" action="' . $_SERVER["PHP_SELF"] . '">
                        <div class="row justify-content-between mb-3">
                            <div class="col-5 form-floating px-1">
                                <input type="text" class="form-control bg-light opacity-75" id="inputName" placeholder="Nombre"
                                       required>
                                <label class="ps-4" for="inputName">Nombre</label>
                            </div>
                            <div class="col-7 form-floating px-1">
                                <input type="text" class="form-control bg-light opacity-75" id="inputApellidos" placeholder="Apellidos"
                                       required>
                                <label class="ps-4" for="inputApellidos">Apellidos</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12 form-floating px-1">
                                <input type="email" class="form-control bg-light opacity-75" id="inputEmail" placeholder="Email"
                                       required>
                                <label class="ps-4" for="inputEmail"><i class="bi bi-envelope fs-5"></i>
                                    Email</label>
                            </div>
                        </div>
                        <div class="row justify-content-between mb-3">
                            <div class="col-6 form-floating px-1">
                                <input type="text" class="form-control bg-light opacity-75" id="exampleInputUser2" placeholder="Usuario"
                                       required>
                                <label class="ps-4" for="exampleInputUser2"><i class="bi bi-person fs-5"></i>
                                    Usuario</label>
                            </div>
                            <div class="col-6 form-floating px-1">
                                <input type="password" class="form-control bg-light opacity-75" id="exampleInputPassword2"
                                       placeholder="Contraseña" required>
                                <label class="ps-4" for="exampleInputPassword2"><i class="bi bi-key fs-5"></i>
                                    Contraseña</label>
                            </div>
                        </div>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                            <label class="form-check-label text-light" for="flexSwitchCheckDefault">Quiero recibir newsletters semanales con
                                todas las ofertas</label>
                        </div>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckCheckedDisabled" checked
                                   disabled required>
                            <label class="form-check-label text-light" for="flexSwitchCheckCheckedDisabled">He leído y acepto la <a
                                    href="#">Política de Privacidad</a> de la empresa</label>
                        </div>
                        <div class="border-0 mx-auto d-flex justify-content-center p-3 pb-4">
                            <button type="submit"
                                    class="btn btn-outline-light m-auto mt-2 mx-auto col-5 fs-5 py-2">Regístrate</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>';
    }