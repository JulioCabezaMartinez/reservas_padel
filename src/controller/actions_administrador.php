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

        include '../view/botones_admin.php';
    break;
    case "recarga":
        $lista_alumnos=cliente::selectAllClientes($connection);

        include '../view/recargar_clases.php';
    break;

    case 'mod_horarios':
        $lista_profesores=profesor::selectAllProfesores($connection);

        include '../view/modificar_add_horarios.php';
    break;

    case 'reservas':
        $lista_reservas=reserva::selectReservasAll($connection);

        include '../view/reservas_realizadas.php';
    break;

    case 'crear_reserva':
        $lista_alumnos=cliente::selectAllClientes($connection);
        $lista_profesores=profesor::selectAllProfesores($connection);

        include '../view/crear_reserva_admin.php';
    break;

    case 'dar_alta_profesor':

        include '../view/dar_alta_profesor.php';

    break;

    case 'dar_alta_alumno':

        include '../view/dar_alta_alumno.php';

    break;

    case 'ver_alumnos':
        $lista_alumnos=cliente::selectAllClientes($connection);
        
        include '../view/lista_alumnos.php';
    break;

    case 'ver_profesores':
        $lista_profesores=profesor::selectAllProfesores($connection);
        
        include '../view/lista_profesores.php';
    break;
}