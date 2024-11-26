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
    <!-- Modal MODIFICAR Horario -->
    <div class="modal fade" id="modal_modificar_horario" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog d-flex justify-content-center">
            <div class="modal-content w-100">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel3">Modificación de Reserva</h5>
                </div>
                <div class="modal-body p-4">
                    <form>
                        <div data-mdb-input-init class="form-outline mb-4">
                            <div id="reserva">
                                <div id="text_horario" class="d-flex flex-wrap">
                                    Fecha:
                                    <input id="fecha_text" class="w-100" type="text" readonly>
                                    Hora:
                                    <input id="hora_text" class="w-100" type="text" readonly>
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

        <h1>Bienvenid@, <span><?php echo $_SESSION['nombre'] ?></span></h1>

        <h3>Creación de horarios</h3>
        <div>
        <label class="form-label" for="dia">Dia:</label>
            <select name="dia" id="dia">
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
            <button id="btn_crear_horario" class="btn btn-success">Crear Horario</button>
        </div>
        <hr>
        <!-- Mis horarios -->
        <div> 
            <h3>Mis Horarios</h3>
            <table class="table">
                <tr>
                    <th scope="col">Dia</th>
                    <th>Hora Inicio</th>
                    <th>Hora Final</th>
                    <th>Acciones</th>
                </tr>
                <tbody>
                    <?php

                    foreach ($lista_horarios as $horario) {
                    ?>
                        <tr>
                            <td><?php echo $horario["dia"] ?></td>
                            <td><?php echo $horario["hora_inicio"] ?></td><!-- Deberia cambiar de array Dinamico a Objecto -->
                            <td><?php echo $horario["hora_final"] ?></td><!-- Deberia cambiar de array Dinamico a Objecto -->
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <hr>
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
        //DatePicker
        const daysOfWeek = ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"];
            var dayName;
            $("#datepicker").datepicker({
                onSelect: function(dateText, inst){
                    $("#fecha_selected").text(dateText);
                    $("#hora_text").val("");

                    let dateParts = dateText.split("/");
                    let dateObject = new Date(dateParts[2], dateParts[1] - 1, dateParts[0]); // Año, Mes, Día
                    
                    // Obtener el nombre del día de la semana
                    dayName= daysOfWeek[dateObject.getDay()];
                    $("#dia_selected").text(dayName);

                    $.ajax({
                        url:"AJAX.php",
                        method: "POST",
                        data:{
                            mode: "muestra_horas_profesor",
                            dia: dayName,
                            fecha:dateText
                        },
                        success:function(data){
                            $("#horas").html(data);
                        }
                    });
                }
            });

            $(document).on('click', '.btn_hora', function(){
                let hora=$(this).text();
                $("#hora_selected").text(hora);
                $("#id_horario").text($(this).attr("id").split("_")[2]); //Esto es mejorable debido a que puede generar un fallo humano. (Ponerse al pulsar el boton de siguiente)
            
                $("#fecha_text").val($("#fecha_selected").text());
                $("#hora_text").val($("#hora_selected").text());
            });
    </script>

    <script>
        $(document).ready(function(){

            //Crear Horario

            $("#btn_crear_horario").click(function(){
                let dia=$("#dia").val();
                let hora_inicio=$("#hora_inicio").val();
                let hora_final=$("#hora_final").val();

                $.ajax({
                    url:"AJAX.php",
                    method: "POST",
                    data:{
                        mode: "creacion_horario_profe",
                        dia: dia,
                        hora_inicio: hora_inicio,
                        hora_final: hora_final
                    },
                    success:function(data){
                        if(data=="Insercción Correcta"){
                            Swal.fire({
                            title: "Horario Creado",
                            text: "El horario se ha creado con exito",
                            icon: "success"
                            }).then((result)=>{
                                location.reload();
                            });
                        }else{
                            Swal.fire({
                            title: "Error Servidor",
                            text: "Ha habido un error en el servidor y no se ha creado el horario",
                            icon: "error"
                            }).then((result)=>{
                                location.reload();
                            });
                        }
                    }
                });
            });

            //Modal
            var id_reserva;
            $(document).on("click", ".btn_modificar_reserva", function(){
                $("#modal_modificar_horario").modal("show");
                id_reserva=$(this).attr("id").split('_')[1];
            });

            $("#btn_guardar_modificar_reserva").click(function(){
                if($("#fecha_text").val()=="" || $("#hora_text").val()==""){
                    $("#error_modal_text").removeClass('d-none');
                }else{
                    let id_horario_nuevo=$("#id_horario").text();
                    let fecha_nueva=$("#fecha_selected").text();

                    $.ajax({
                        url:"AJAX.php",
                        method: "POST",
                        data:{
                            mode: "modificacion_reserva",
                            id_reserva:id_reserva,
                            id_horario:id_horario_nuevo,
                            fecha:fecha_nueva
                        },
                        success:function(data){
                            if(data=="Modificación Correcta"){
                                Swal.fire({
                                title: "Reserva Modificada",
                                text: "La reserva se ha modificado con exito",
                                icon: "success"
                                }).then((result)=>{
                                    location.reload();
                                });
                            }else{
                                Swal.fire({
                                title: "Error Servidor",
                                text: "Ha habido un error en el servidor y no se ha creado el horario",
                                icon: "error"
                                }).then((result)=>{
                                    location.reload();
                                });
                            }
                        }
                    });
                }
                
            });

            //Cerrar Modales
            $("#btn_cerrar_modificar").click(function(){
                $("#modal_modificar_horario").modal("hide");
            });

        });
    </script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
</body>

</html>