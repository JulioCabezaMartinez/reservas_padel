<?php

if (empty($_SESSION) || !isset($_SESSION)){
    header("Location:../../../src/view/login.php");
    die();
}

$titulo="Panel Admin";
require_once "../view/Templates/inicio.inc.php";

?>

<body>

    <?php
        require_once "../view/Templates/barra_lateral.inc.php"; 
    ?>

    <main class="my-4">
        <h2>Panel de Alumno</h2>
        <hr>
        <div id="admin_butons">
            <a href="./actions_alumno.php?action=reserva_clase">
                <button class="btn btn-outline-success"><i class="fa-solid fa-calendar-days"></i><i class="fa-solid fa-pen"></i> Reservar Clases</button>
            </a>

            <a href="./actions_alumno.php?action=reservas">
                <button class="btn btn-outline-primary"><i class="fa-solid fa-calendar-days"></i> Mis Clases</button>
            </a>
        </div>
        <hr>

        <footer>
            <h1>Aplicación web desarrollada por <a style="text-decoration: none; color: #1A73E8" href="https://dondigital.es">DonDigital.es</a></h1>
            <img id="logo_barra" src="../../../assets/IMG/Logo_DonDigital_barra2.svg">
        </footer>
    </main>
       
    <script>
        $(document).ready(function(){

        });
    </script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
</body>
</html>