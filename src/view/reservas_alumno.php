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

        <h1>Bienvenid@, <span><?php echo $_SESSION['nombre'] ?></span></h1>

        <!-- Ver Reservas -->
        <div>
            <h2>Ver Clases</h2>
            <table class="table">
                <thead>
                    <th scope="col">Dia</th>
                    <th>Hora Inicio</th>
                    <th>Hora Final</th>
                    <th>Profesor</th>
                    <th>Acciones</th>
                </thead>
                <tbody>
                <?php

                    foreach ($lista_reservas as $reserva) {
                        $horario = horario::selectHorario($connection, $reserva["id_horario"]);
                        $profesor=profesor::selectProfesor($connection, $reserva["id_profesor"]);
                ?>
                        <tr>
                            <td><?php echo $reserva["fecha"] ?></td>
                            <td><?php echo $horario["hora_inicio"] ?></td><!-- Deberia cambiar de array Dinamico a Objecto -->
                            <td><?php echo $horario["hora_final"] ?></td><!-- Deberia cambiar de array Dinamico a Objecto -->
                            <td><?php echo $profesor->nombre . " " . $profesor->apellidos ?></td>
                            <!-- <td><button id="btn_<?php echo $reserva["id_reserva"] ?>" class="btn_modificar_reserva btn btn-primary"><i class="fa-solid fa-pen me-2"></i>Modificar reserva</button></td> -->
                        </tr>
                <?php
                    }
                ?>
                </tbody>
            </table>
        </div>
        
    </main>
</body>

</html>