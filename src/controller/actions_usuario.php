<?php
session_start();
require_once '../model/usuario.php';
require_once '../model/cliente.php';
require_once '../model/horario.php';
require_once '../model/profesor.php';
require_once '../model/BuscadorDB.php';
require_once '../model/reserva.php';

if(isset($_POST["register"])){
    $registro=usuario::registrarUsuario($connection, $_POST["correo"], $_POST["pass"], $_POST["confirm"], $_POST["nombre"], $_POST['apellidos'], $_POST["tipo"], DNI:$_POST['DNI']);
    if(!is_string($registro)){
        header('Location: ../view/login.php?action=register');
    }else{
        header('Location: ../view/login.php?action=error&error='.$registro.'');
    }
}

if(isset($_POST['login'])){
    $login=usuario::LogIn($_POST['correo'], $_POST['pass'], $connection);

    if($login){
        if($_SESSION['tipo_usuario']=="Alumno"){//Login Alumno

            $puntos=cliente::selectCliente($connection, $_SESSION['id'], "Puntos"); // El id del cliente se recogerá por Session.
            $lista_profesores=profesor::selectAllProfesores($connection);
            
            include '../view/inicio_clientes.php';

        }elseif($_SESSION['tipo_usuario']=="Profesor"){//Login Profesor

            $puntos=cliente::selectCliente($connection, 1, "Puntos"); // El id del cliente se recogerá por Session.
            $lista_profesores=profesor::selectAllProfesores($connection);

            include '../view/inicio_profesores.php';

        }elseif($_SESSION['tipo_usuario']=="Administrador"){//Login Administrador

            $puntos=cliente::selectCliente($connection, 1,  "Puntos"); // El id del cliente se recogerá por Session.
            $lista_profesores=profesor::selectAllProfesores($connection);
            $lista_alumnos=cliente::selectAllClientes($connection);
            $lista_reservas=reserva::selectReservasAll($connection);

            include '../view/panel_admin.php';

        }else{
            header('Location: ../view/login.php?hola=1');
        }
    }else{
        header('Location: ../view/login.php?action=1');
    }
}

switch($_GET["action"]){
    case "cerrar":
        usuario::logOut();
    
        header("Location: ../view/login.php");
    break;
}