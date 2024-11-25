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
        <h2>Panel de Administrador</h2>
        <hr>
        <div id="admin_butons">
            <a href="./actions_administrador.php?action=recarga">
                <button class="btn btn-outline-warning"><i class="fa-solid fa-plus"></i><i class="fa-solid fa-table-tennis-paddle-ball mx-2"></i> Recargar Clases</button>
            </a>

            <a href="./actions_administrador.php?action=mod_horarios">
                <button class="btn btn-outline-secondary"><i class="fa-solid fa-calendar-days"></i><i class="fa-solid fa-pen"></i> Modificar/Añadir Horarios</button>
            </a>

            <a href="./actions_administrador.php?action=reservas">
                <button class="btn btn-outline-primary"><i class="fa-solid fa-book-bookmark"></i> Gestionar Reservas</button>
            </a>

            <a href="./actions_administrador.php?action=dar_alta">
                <button class="btn btn-outline-success"><i class="fa-solid fa-user-plus"></i> Dar de alta Usuarios</button>
            </a>
        </div>
        <hr>
    </main>
        <hr>

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

    <script>
        $(document).ready(function(){

        });
    </script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
</body>
</html>