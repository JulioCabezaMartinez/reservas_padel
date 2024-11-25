<?php

if (empty($_SESSION) || !isset($_SESSION)){
    header("Location:../../../src/view/login.php");
    die();
}

$titulo="Inicio Admin";
require_once "../view/Templates/inicio.inc.php";

?>

<body>

    <?php
        require_once "../view/Templates/barra_lateral.inc.php"; 
    ?>

    <main class="my-4">
        <h2>Reservas realizadas</h2>
            <table class="table">
            <thead>
                <tr>
                    <th scope="col">Fecha</th>
                    <th>Profesor</th>
                    <th>Alumno</th>
                    <th>Hora de Inicio</th>
                    <th>Hora de Finalizacion</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="body_reservas">
            <?php

            foreach($lista_reservas as $reserva){
                $horario=horario::selectHorario($connection, $reserva["id_horario"]);
                $cliente=cliente::selectCliente($connection, $reserva["id_cliente"], "Todo");
                $profesor=profesor::selectProfesor($connection, $reserva["id_profesor"])

            ?>
                <tr>
                    <td><?php echo $reserva["fecha"] ?></td>
                    <td><?php echo $profesor->nombre." ".$profesor->apellidos ?></td>
                    <td><?php echo $cliente->nombre." ".$cliente->apellidos ?></td>
                    <td><?php echo $horario["hora_inicio"] ?></td><!-- Deberia cambiar de array Dinamico a Objecto -->
                    <td><?php echo $horario["hora_final"] ?></td><!-- Deberia cambiar de array Dinamico a Objecto -->
                    <td><button id="btn_<?php echo $reserva["id_reserva"]?>" class="btn_modificar_reserva btn btn-primary"><i class="fa-solid fa-pen me-2"></i>Modificar reserva</button></td>
                </tr>
            <?php
            }

            ?>
            </tbody>
            </table>
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