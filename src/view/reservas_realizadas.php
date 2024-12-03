<?php

if (empty($_SESSION) || !isset($_SESSION)) {
    header("Location:../../../src/view/login.php");
    die();
}

$titulo = "Inicio Admin";
require_once "../view/Templates/inicio.inc.php";

?>

<body>

    <!-- Modal MODIFICAR Reserva -->
    <div class="modal fade" id="modal_modificar_reserva" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-lg d-flex justify-content-center">
            <div class="modal-content w-100">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel3">Modificación de Reserva</h5>
                </div>
                <div class="modal-body p-4">
                    <form>
                        <div data-mdb-input-init class="form-outline mb-4">
                            <div id="alumno_profesor">
                                <label for="profesor_modal_creacion">Profesor: </label>
                                <select name="profesor" id="profesor_modal_creacion">
                                    <option value="" selected>--Elija un profesor--</option>
                                    <?php
                                    foreach ($lista_profesores as $profesor) {
                                    ?>
                                        <option value="<?php echo $profesor->id_profesor ?>"><?php echo $profesor->nombre . " " . $profesor->apellidos ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <br><br>
                                <label for="">Indique el nombre o el DNI del alumno: </label>
                                <input id="alumnos">
                                <br><br>
                            </div>
                            <div id="dia">

                                <div id="text_horario" class="d-flex flex-wrap">
                                    Fecha:
                                    <input id="fecha_text" class="w-25" type="text" readonly>
                                    Hora:
                                    <input id="hora_text" class="w-25" type="text" readonly>
                                    <p id="error_modal_text" class="d-none" style="color: red;">Se necesita elegir un horario para la reserva</p>
                                </div>

                                <div class="d-flex my-4 justify-content-between">
                                    <div id="datepicker" class="w-50"></div>
                                    <div class="row row-cols-3 m-4 flex-wrap w-25" id="horas" class="w-25"></div>
                                </div>

                                <!-- Span ocultos para enviar los datos -->
                                <span id="id_horario" class="d-none"></span> <!-- Recojo aqui el id del horario nuevo para modificarlo -->
                                <span id="hora_selected" class="d-none"></span>
                                <span id="fecha_selected" class="d-none"></span>
                                <span id="dia_selected" class="d-none"></span>
                            </div>

                        </div>
                        <button id="btn_cerrar_modificar" type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button id="btn_guardar_modificar_reserva" type="button" class="btn btn-primary w-50" data-dismiss="modal">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal MODIFICAR Horario -->

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

                foreach ($lista_reservas as $reserva) {
                    $horario = horario::selectHorario($connection, $reserva["id_horario"]);
                    $cliente = cliente::selectCliente($connection, "Todo", $reserva["id_cliente"]);
                    $profesor = profesor::selectProfesor($connection, $reserva["id_profesor"])

                ?>
                    <tr>
                        <td><?php echo $reserva["fecha"] ?></td>
                        <td><?php echo $profesor->nombre . " " . $profesor->apellidos ?></td>
                        <td><?php echo $cliente->nombre . " " . $cliente->apellidos ?></td>
                        <td><?php echo $horario["hora_inicio"] ?></td><!-- Deberia cambiar de array Dinamico a Objecto -->
                        <td><?php echo $horario["hora_final"] ?></td><!-- Deberia cambiar de array Dinamico a Objecto -->
                        <td><button id="btn_<?php echo $reserva["id_reserva"] ?>" class="btn_modificar_reserva btn btn-primary"><i class="fa-solid fa-pen me-2"></i>Modificar reserva</button></td>
                    </tr>
                <?php
                }

                ?>
            </tbody>
        </table>

        <?php
        include '../view/Templates/footer.inc.php';
        ?>
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

    <script>
        $(document).ready(function() {

            //Autocomplete de JQuery
            let alumnos = <?php
                            $nombres_alumnos = [];
                            foreach ($lista_alumnos as $alumno) {
                                array_push($nombres_alumnos, $alumno->DNI . "-" . $alumno->nombre . " " . $alumno->apellidos);
                            }
                            echo json_encode($nombres_alumnos);
                            ?>;

            
            $("#alumnos").autocomplete({
                source: alumnos
            });
            

            $(document).on("click", ".btn_modificar_reserva", function() {
                $("#modal_modificar_reserva").modal("show");
            });
        });
    </script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
</body>

</html>