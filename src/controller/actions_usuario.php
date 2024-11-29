<?php
session_start();
require_once '../model/usuario.php';
require_once '../model/cliente.php';
require_once '../model/horario.php';
require_once '../model/profesor.php';
require_once '../model/BuscadorDB.php';
require_once '../model/reserva.php';

// Validar conexión antes de usarla
if (!isset($connection)) {
    die("Error: Conexión no inicializada.");
}

if(!isset($_POST["register"]) && !isset($_POST['login']) && !isset($_GET["action"])){
    header("Location:/src/view/login.php");
    die();
}

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
            $lista_reservas=reserva::selectReservasAlumno($connection, $_SESSION['id']);
            $puntos=cliente::selectCliente($connection, "Puntos", $_SESSION['id']);
            $lista_profesores=profesor::selectAllProfesores($connection);
            
            include '../view/botones_alumno.php';

        }elseif($_SESSION['tipo_usuario']=="Profesor"){//Login Profesor
            $lista_horarios=horario::selectHorarioProfesor($connection, $_SESSION["id"]);
            $lista_reservas=reserva::selectReservasProfe($connection, $_SESSION['id']);

            include '../view/botones_profesor.php';

        }elseif($_SESSION['tipo_usuario']=="Administrador"){//Login Administrador
  
            $lista_profesores=profesor::selectAllProfesores($connection);
            $lista_alumnos=cliente::selectAllClientes($connection);

            include '../view/botones_admin.php';

        }else{
            header('Location: ../view/login.php');
        }
    }else{
        header('Location: ../view/login.php?action=1');
    }
}

if(isset($_GET["action"])){
    switch($_GET["action"]){
        case "cerrar":
            usuario::logOut();
        
            header("Location: ../view/login.php");
        break;
    }
}

