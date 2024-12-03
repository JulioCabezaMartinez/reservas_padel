<?php

if (empty($_SESSION) || !isset($_SESSION)) {
    header("Location:../../../src/view/login.php");
    die();
}

$titulo = "Inicio Admin";
require_once "../view/Templates/inicio.inc.php";

?>

<body>

    <!-- Modales -->

    <!-- Modal MODIFICAR Horario -->
    <div class="modal fade" id="modal_modificar_horario" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog d-flex justify-content-center">
            <div class="modal-content w-75">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel3">Modificación de Horario</h5>
                </div>
                <div class="modal-body p-4">
                    <form>
                        <div data-mdb-input-init class="form-outline mb-4">
                            <p>Mes/es:</p>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="enero" value="1">
                                <label class="form-check-label" for="enero">Enero</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="febrero" value="2">
                                <label class="form-check-label" for="febrero">Febrero</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="marzo" value="3">
                                <label class="form-check-label" for="marzo">Marzo</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="abril" value="4">
                                <label class="form-check-label" for="abril">Abril</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="mayo" value="5">
                                <label class="form-check-label" for="mayo">Mayo</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="junio" value="6">
                                <label class="form-check-label" for="junio">Junio</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="julio" value="7">
                                <label class="form-check-label" for="julio">Julio</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="agosto" value="8">
                                <label class="form-check-label" for="agosto">Agosto</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="septiembre" value="9">
                                <label class="form-check-label" for="septiembre">Septiembre</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="octubre" value="10">
                                <label class="form-check-label" for="octubre">Octubre</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="noviembre" value="11">
                                <label class="form-check-label" for="noviembre">Noviembre</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="diciembre" value="12">
                                <label class="form-check-label" for="diciembre">Diciembre</label>
                            </div>
                            <br><br>
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
                            <br>
                            <label for="hora_inicio_modal">Hora Inicio: </label>
                            <input class="timepicker" id="hora_inicio_modal" name="hora_inicio-modal">
                            <br><br>
                            <label for="hora_final">Hora final: </label>
                            <input class="timepicker" name="hora_final_modal" id="hora_final_modal">
                        </div>
                        <button id="btn_cerrar_modificar" type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button id="btn_guardar_modificar_horario" type="button" class="btn btn-primary w-50" data-dismiss="modal">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal MODIFICAR Horario -->

    <!-- Modal Añadir Horario -->
    <div class="modal fade" id="modal_añadir_horario" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog d-flex justify-content-center">
            <div class="modal-content w-75">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel3">Creación de Horario</h5>
                </div>
                <div class="modal-body p-4">
                    <form>
                        <div data-mdb-input-init class="form-outline mb-4">
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
                            <label class="form-label" for="dia_modal_creacion">Dia:</label>
                            <select name="dia_modal_creacion" id="dia_modal_creacion">
                                <option value="Lunes">Lunes</option>
                                <option value="Martes">Martes</option>
                                <option value="Miercoles">Miercoles</option>
                                <option value="Jueves">Jueves</option>
                                <option value="Viernes">Viernes</option>
                                <option value="Sabado">Sabado</option>
                                <option value="Domingo">Domingo</option>
                            </select>
                            <br><br>
                            <p>Mes/es:</p>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="enero" value="1">
                                <label class="form-check-label" for="enero">Enero</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="febrero" value="2">
                                <label class="form-check-label" for="febrero">Febrero</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="marzo" value="3">
                                <label class="form-check-label" for="marzo">Marzo</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="abril" value="4">
                                <label class="form-check-label" for="abril">Abril</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="mayo" value="5">
                                <label class="form-check-label" for="mayo">Mayo</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="junio" value="6">
                                <label class="form-check-label" for="junio">Junio</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="julio" value="7">
                                <label class="form-check-label" for="julio">Julio</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="agosto" value="8">
                                <label class="form-check-label" for="agosto">Agosto</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="septiembre" value="9">
                                <label class="form-check-label" for="septiembre">Septiembre</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="octubre" value="10">
                                <label class="form-check-label" for="octubre">Octubre</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="noviembre" value="11">
                                <label class="form-check-label" for="noviembre">Noviembre</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="diciembre" value="12">
                                <label class="form-check-label" for="diciembre">Diciembre</label>
                            </div>
                            <br><br>
                            <label for="hora_inicio_modal">Hora Inicio: </label>
                            <input class="timepicker" id="hora_inicio_modal_creacion" name="hora_inicio_modal_creacion">
                            <br><br>
                            <label for="hora_final">Hora final: </label>
                            <input class="timepicker" name="hora_final_modal_creacion" id="hora_final_modal_creacion">
                        </div>
                        <button id="btn_cerrar_crear" type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button id="btn_guardar_crear_horario" type="button" class="btn btn-primary w-50" data-dismiss="modal">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Añadir Horario -->

    <?php
    require_once "../view/Templates/barra_lateral.inc.php";
    ?>

    <main class="my-4">
        <h2>Modificar/Añadir Horarios</h2>
        <h4>Tabla de Horarios</h4>
        <button id="btn_añadir_horario" class="btn btn-primary btn-diez"><i class="fa-regular fa-calendar-plus me-2"></i>Añadir Horario</button><br>
        <label>Indique a que profesor quiere ver el horario: </label>
        <select name="profesor" id="profesor">
            <option value="" selected>--Elija un profesor--</option>
            <?php
            foreach ($lista_profesores as $profesor) {
            ?>
                <option value="<?php echo $profesor->id_profesor ?>"><?php echo $profesor->nombre . " " . $profesor->apellidos ?></option>
            <?php
            }
            ?>
        </select>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Dia</th>
                    <th>Hora de Inicio</th>
                    <th>Hora de Finalizacion</th>
                    <th>Meses</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="body_profesores">

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

            $("#profesor").change(function() {
                id_profesor = $("#profesor").val();
                $.ajax({
                    url: "AJAX.php", //Esto debe cambiarse cuando se llame a las vistas por el controller.
                    method: "POST",
                    data: {
                        mode: "tabla_profesor",
                        id_profesor: id_profesor
                    },
                    success: function(data) {
                        $("#body_profesores").html(data);
                    }
                });
            });

            //Modales

            var id_horario;
            $(document).on("click", ".btn_modificar_horario", function() {
                $("#modal_modificar_horario").modal("show");
                id_horario = $(this).attr("id").split('_')[1];
            });

            $("#btn_guardar_modificar_horario").click(function() {
                let dia = $("#dia_modal").val();
                let hora_inicio = $("#hora_inicio_modal").val();
                let hora_final = $("#hora_final_modal").val();
                $.ajax({
                    url: "AJAX.php", //Esto debe cambiarse cuando se llame a las vistas por el controller.
                    method: "POST",
                    data: {
                        mode: "modificar_horario",
                        id_horario: id_horario,
                        dia: dia,
                        hora_inicio: hora_inicio,
                        hora_final: hora_final
                    },
                    success: function(data) {
                        location.reload();
                    }
                });
            });

            $("#btn_añadir_horario").click(function() {
                $("#modal_añadir_horario").modal("show");
            });

            $("#btn_guardar_crear_horario").click(function() {
                let profesor_añadir = $("#profesor_modal_creacion").val();
                let dia_añadir = $("#dia_modal_creacion").val();
                let hora_inicio_añadir = $("#hora_inicio_modal_creacion").val();
                let hora_final_añadir = $("#hora_final_modal_creacion").val();
                let meses = $(".form-check-input:checked").map(function() {
                    return $(this).val();
                }).get();

                $.ajax({
                    url: "AJAX.php",
                    method: "POST",
                    data: {
                        mode: "creacion_horario",
                        profesor: profesor_añadir,
                        dia: dia_añadir,
                        hora_inicio: hora_inicio_añadir,
                        hora_final: hora_final_añadir,
                        meses: meses
                    },
                    success: function(data) {
                        console.log(data);
                    }
                });
            });

            //Cerrar Modales
            $("#btn_cerrar_modificar").click(function() {
                $("#modal_modificar_horario").modal("hide");
            });

            $("#btn_cerrar_crear").click(function() {
                $("#modal_añadir_horario").modal("hide");
            });
        });
    </script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
</body>

</html>