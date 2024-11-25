<?php


if (empty($_SESSION) || !isset($_SESSION)) {
    header("Location:../../../src/view/login.php");
    die();
}

$titulo = "Inicio";
require_once "../view/Templates/inicio.inc.php";

?>

<body>

    <?php
    require_once "../view/Templates/barra_lateral.inc.php";
    ?>

    <main>
        <h1>Bienvenid@, <span></span></h1>
        <p>Desde aqui puede gestionar sus clases y horarios:</h3>

        <h2>Creación de horarios</h2>
        <div>
        <label class="form-label" for="dia_modal">Dia:</label>
            <select name="dia_modal" id="dia_modal">
                <option value="Lunes">Lunes</option>
                <option value="Martes">Martes</option>
                <option value="Miercoles">Miercoles</option>
                <option value="Jueves">Jueves</option>
                <option value="Viernes">Viernes</option>
                <option value="Sabado">Sabado</option>
                <option value="Domingo">Domingo</option>
            </select>

            <label for="hora_inicio">Hora de inicio: </label>
            <input class="timepicker" id="hora_inicio" name="hora_inicio">

            <label for="hora_final">Hora final: </label>
            <input class="timepicker" name="hora_final" id="hora_final">
            <br><br>
            <button class="btn btn-success">Crear Horario</button>
        </div>

        <hr>
        <div>
            <h2>Ver Reservas</h2>
            <table class="table">
                <tr>
                    <th scope="col">Fecha</th>
                    <th>Hora Inicio</th>
                    <th>Hora Final</th>
                    <th>Alumno</th>
                    <!-- <th>Acciones</th> -->
                </tr>
                <tbody>
                    <?php

                    foreach ($lista_reservas as $reserva) {
                        $horario = horario::selectHorario($connection, $reserva["id_horario"]);
                        $cliente = cliente::selectCliente($connection, $reserva["id_cliente"], "Todo");
                    ?>
                        <tr>
                            <td><?php echo $reserva["fecha"] ?></td>
                            <td><?php echo $horario["hora_inicio"] ?></td><!-- Deberia cambiar de array Dinamico a Objecto -->
                            <td><?php echo $horario["hora_final"] ?></td><!-- Deberia cambiar de array Dinamico a Objecto -->
                            <td><?php echo $cliente->nombre . " " . $cliente->apellidos ?></td>
                            <!-- <td><button id="btn_<?php echo $reserva["id_reserva"] ?>" class="btn_modificar_reserva btn btn-primary"><i class="fa-solid fa-pen me-2"></i>Modificar reserva</button></td> -->
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>

    <script>
        //TimePicker
        $(document).ready(function() {
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