<?php
session_start();
require_once '../model/usuario.php';
require_once '../model/cliente.php';
require_once '../model/horario.php';
require_once '../model/profesor.php';
require_once '../model/BuscadorDB.php';
require_once '../model/reserva.php';

switch($_GET["action"]){
    case 'botones':
        $puntos=cliente::selectCliente($connection,"Puntos", $_SESSION['id']); // El id del cliente se recogerá por Session.

        include '../view/botones_alumno.php';
    break;

    case 'reserva_clase':
        $puntos=cliente::selectCliente($connection,"Puntos", $_SESSION['id']); // El id del cliente se recogerá por Session.
        $lista_profesores=profesor::selectAllProfesores($connection);

        include '../view/reservar_clase_alumno.php';
    break;
    case "reservas":
        $lista_reservas=reserva::selectReservasAlumno($connection, $_SESSION['id']);
        $puntos=cliente::selectCliente($connection,"Puntos", $_SESSION['id']); // El id del cliente se recogerá por Session.
            
        include '../view/reservas_alumno.php';
    break;
}