<?php
session_start();
require_once '../model/usuario.php';
require_once '../model/cliente.php';
require_once '../model/horario.php';
require_once '../model/profesor.php';
require_once '../model/BuscadorDB.php';

if(isset($_POST["register"])){
    $registro=usuario::registrarUsuario($connection, $_POST["correo"], $_POST["pass"], $_POST["confirm"], $_POST["nombre"], $_POST['apellidos'], $_POST["tipo"]);
    if(!is_string($registro)){
        header('Location: ../view/login.php?action=register');
    }else{
        header('Location: ../view/login.php?action=error&error='.$registro.'');
    }
}

if(isset($_POST['login'])){
    $login=usuario::LogIn($_POST['correo'], $_POST['pass'], $_POST['tipo'], $connection);

    if($login){
        if($_POST['tipo']=="Alumno"){
            header('Location: ../view/inicio_clientes.php');
        }elseif($_POST['tipo']=="Profesor"){
            header('Location: ../view/inicio_profesores.php');
        }
    }else{
        header('Location: ../view/login.php?action=1');
    }
}