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
            <h2>Ver Reservas</h2>
            <table class="table">
                <tr>
                    <th scope="col">Fecha</th>
                    <th>Hora Inicio</th>
                    <th>Hora Final</th>
                    <th>Alumno</th>
                    <th>Acciones</th>
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

                            <!-- Recojo aqui el id del cliente y de la reserva para modificarlo -->
                            <td><button id="btn_<?php echo $reserva["id_reserva"] ?>" class="btn_modificar_reserva btn btn-primary"><i class="fa-solid fa-pen me-2"></i>Modificar reserva</button></td>
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