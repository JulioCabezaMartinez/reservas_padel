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
        <h2>Panel de Profesor</h2>
        <hr>
        <div id="admin_butons">
            <a href="./actions_profesor.php?action=horarios">
                <button class="btn btn-outline-primary"><i class="fa-solid fa-calendar-days"></i></i> Mis Horarios</button>
            </a>

            <a href="./actions_profesor.php?action=reservas">
                <button class="btn btn-outline-success"><i class="fa-regular fa-calendar-plus"></i> Crear Horario</button>
            </a>
        </div>
        <hr>
        <?php
            include '../view/Templates/footer.inc.php';
        ?>
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

    <script>
        $(document).ready(function(){

        });
    </script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
</body>
</html>