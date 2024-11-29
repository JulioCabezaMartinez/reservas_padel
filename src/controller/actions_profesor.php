<?php
session_start();
require_once '../model/usuario.php';
require_once '../model/cliente.php';
require_once '../model/horario.php';
require_once '../model/profesor.php';
require_once '../model/BuscadorDB.php';
require_once '../model/reserva.php';

if(isset($_GET["action"])){
    switch($_GET["action"]){
        case 'botones':
    
            include '../view/botones_profesor.php';
        break;
    
        case 'horarios':
            $lista_horarios=horario::selectHorarioProfesor($connection, $_SESSION["id"]);
    
            include '../view/horarios_profesor.php';
        break;
        case "reservas":
            $lista_reservas=reserva::selectReservasProfe($connection, $_SESSION['id']);
    
            include '../view/reservas_profesor.php';
        break;
    }
}else{
    header("Location:/src/view/login.php");
    die();
}
