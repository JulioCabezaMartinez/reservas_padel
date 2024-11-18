<?php

    //Requiere de utilizar composer para poder utilizar variables de entorno.

    $servername = "localhost"; //Ip de la base de datos
    $username = "root"; //Usuario que vamos a utilizar para entrar en la base de datos.
    $password = ""; //Password del usuario elegido.
    $dbname = "padel"; //Nombre de la base de datos.
    // Create connection
    $connection = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    // Para poder utilizar la base de datos en un servidor web se puede realizar desde el CPanel del hosting.
?>
