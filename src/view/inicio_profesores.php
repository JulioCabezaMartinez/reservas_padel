<?php

session_start();

    ini_set('display_errors', 1);
    error_reporting(E_ALL & ~E_NOTICE);

    // if (empty($_SESSION)){
    //     header("Location:../../../src/view/login.php");
    //     die();
    // }


//Prueba antes de crear controllers
require '../model/usuario.php';
require '../model/profesor.php';
require '../model/cliente.php';
require '../model/BuscadorDB.php';
$puntos=cliente::selectPuntosCliente($connection, 1); // El id del cliente se recogerá por Session.
$lista_profesores=profesor::selectAllProfesores($connection);
//Prueba antes de crear controllers

$titulo="Inicio";
require_once "./Templates/inicio.inc.php";

?>

<body>

    <?php
        require_once "./Templates/barra_lateral.inc.php"; 
    ?>

    <main>
        <h1>Bienvenid@, <span></span></h1>
        <p>Desde aqui puede gestionar sus clases y horarios:</h3>

        <h2>Creación de horarios</h2>
        <div>
            <label for="hora_inicio">Hora de inicio: </label>
            <input class="timepicker" id="hora_inicio" name="hora_inicio"> 
            
            <label for="hora_final">Hora final: </label>
            <input class="timepicker" name="hora_final" id="hora_final">
        </div>

    </main>

    <script>
        //TimePicker
        $(document).ready(function () {
            $('.timepicker').timepicker({
                timeFormat: 'HH:mm',
                interval: 60,
                minTime: '10:00am',
                maxTime: '18:00',
                defaultTime: '11:00am',
                startTime: '10:00am',
                dynamic: false,
                dropdown: true,
                scrollbar: false
            });
        });

    </script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
</body>
</html>