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
                                <select name="profesor" id="profesor_modal">
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
                                <input type="hidden" id="id_alumno_hidden">
                                <br><br>
                            </div>
                            <div id="dia" class="d-none">

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

                            <span id="error_modal" class="d-none" style="color: red;">Se deben rellenar todos los campos</span>

                        </div>
                        <button id="btn_cerrar_modificar_reserva" type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
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

            // Profesor

            $("#profesor_modal").change(function(){
                //DatePicker
                const daysOfWeek = ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"];
                var dayName;
                $("#datepicker").datepicker({
                    onSelect: function(dateText, inst) {
                        $("#fecha_selected").text(dateText);

                        $("#hora_text").val("");

                        let dateParts = dateText.split("/");
                        let dateObject = new Date(dateParts[2], dateParts[1] - 1, dateParts[0]); // Año, Mes, Día

                        // Obtener el nombre del día de la semana
                        dayName = daysOfWeek[dateObject.getDay()];
                        let mes = dateObject.getMonth() + 1;
                        $("#dia_selected").text(dayName);
                        let id_profesor = $("#profesor_modal").val();

                        $.ajax({
                            url: "AJAX.php",
                            method: "POST",
                            data: {
                                mode: "muestra_horas",
                                id_profesor: id_profesor,
                                dia: dayName,
                                mes: mes,
                                fecha: dateText
                            },
                            success: function(data) {
                                $("#horas").html(data);
                            }
                        });
                    }
                });

                // AL SELECCIONAR EL PROFESOR SE AJUSTA LA PRIMERA ENTRADA DE LA BUSQUEDA DE CLASE.
                let targetDate = new Date();
                $("#datepicker").datepicker("setDate", targetDate);

                let formattedDate = $.datepicker.formatDate("dd/mm/yy", targetDate);
                let mes = targetDate.getMonth() + 1;
                dayName = daysOfWeek[targetDate.getDay()];
                $("#datepicker").datepicker("option", "onSelect")(formattedDate, null);

                let id_profesor = $("#profesor_modal").val();

                $.ajax({
                    url: "AJAX.php",
                    method: "POST",
                    data: {
                        mode: "muestra_horas",
                        id_profesor: id_profesor,
                        dia: dayName,
                        mes: mes,
                        fecha: formattedDate
                    },
                    success: function(data) {
                        $("#horas").html(data);
                    }
                });

                // COLOREAR CASILLAS
                let dias_horario=[];

                for(i=1; i<13; i++){
                    dias_horario[i]=[];
                    for(j=0; j<7; j++){
                        dias_horario[i][j]=false;
                    }
                }
                
                const daysOfWeekMap = {
                    "Domingo": 0,
                    "Lunes": 1,
                    "Martes": 2,
                    "Miercoles": 3,
                    "Jueves": 4,
                    "Viernes": 5,
                    "Sábado": 6
                };

                $.ajax({
                    url: "AJAX.php",
                    method: "POST",
                    data:{
                        mode: "colores_dias",
                        id_profesor: id_profesor
                    },
                    success:function(data){
                        const horarios = JSON.parse(data);


                        horarios.forEach(horario=>{
                            const dayIndex = daysOfWeekMap[horario.dia];
                            let mesesArray = JSON.parse(horario.mes); // Convierte la cadena en un array
                            
                            mesesArray.forEach(mesIndex=>{
                                dias_horario[mesIndex][dayIndex]=true;
                            });
                        });

                        // Actualizamos la configuración del datepicker con los nuevos datos de horarios

                        // Objeto para almacenar los días completos
                        let diasCompletos = {};
                        $("#datepicker").datepicker("option", "beforeShowDay", function(date, inst) {
                            const dayOfWeek = date.getDay();
                            let monthOftheYear=(date.getMonth() + 1);

                            let dateObject = new Date(date.getFullYear(), date.getMonth() - 1, date.getDay()); // Año, Mes, Día

                            // Obtener el día, mes y año
                            let day = dateObject.getDate();  // Día del mes (1-31)
                            let month = dateObject.getMonth() + 1;  // Mes (0-11, por lo que sumamos 1)
                            let year = dateObject.getFullYear();  // Año completo (e.g. 2024)

                            // Formatear en día/mes/año
                            let formattedDate = `${day < 10 ? '0' + day : day}/${month < 10 ? '0' + month : month}/${year}`;

                            // // Obtener el nombre del día de la semana
                            // let dayName = daysOfWeek[dateObject.getDay()];

                            // let diaCompleto;
                            // $.ajax({
                            //     url: "AJAX.php",
                            //     method: "POST",
                            //     data:{
                            //         mode: "contar_reservas",
                            //         nombre_dia: dayName,
                            //         fecha: formattedDate
                            //     },
                            //     success:function(data){
                            //         if(data){
                            //             diaCompleto=true;
                            //         }else{
                            //             diaCompleto=false;
                            //         }
                            //     }
                            // });

                            // Comprobar si el día tiene horario

                            if (dias_horario[monthOftheYear][dayOfWeek]) {
                                return [true, "has-schedule", "Día con horario asignado"];
                            } else {
                                return [true, "", "Día sin horario asignado"];
                            }
                            

                        });

                        // Inicializar el DatePicker después de cargar los datos
                        $("#datepicker").datepicker("refresh");
                    }
                });

                $("#dia").removeClass("d-none");
            });

            $(document).on('click', '.btn_hora', function() {
                let hora = $(this).text();
                $("#hora_selected").text(hora);
                $("#id_horario").text($(this).attr("id").split("_")[2]);

                $("#fecha_text").val($("#fecha_selected").text());
                $("#hora_text").val($("#hora_selected").text());

            });

            // Alumno
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

            $("#alumnos").change(function(){
                let DNI_alumno=$(this).val().split("-")[0];
                $.ajax({
                    url: "AJAX.php",
                    method: "POST",
                    data:{
                        mode: "recoger_id_alumno_admin",
                        DNI_alumno:DNI_alumno
                    },
                    success:function(data){
                        $("#id_alumno_hidden").val(data);
                    }
                })
                
            });

            var id_reserva;
            // Boton Guardar
            $("#btn_guardar_modificar_reserva").click(function(){
                let id_profesor=$("#profesor_modal").val();
                let id_alumno=$("#id_alumno_hidden").val();
                let id_horario=$("#id_horario").text();
                let fecha=$("#fecha_selected").text();

                if(id_profesor=="" || id_alumno=="" || id_horario=="" || fecha==""){
                    $("#error_modal").removeClass("d-none");
                }else{
                    $.ajax({
                        url: "AJAX.php",
                        method: "POST",
                        data:{
                            mode: "modificacion_reserva",
                            tipo_update: "todo",
                            id_profesor:id_profesor,
                            id_alumno:id_alumno,
                            id_horario:id_horario,
                            fecha:fecha,
                            id_reserva:id_reserva
                        },
                        success:function(data){
                            if(data=='Modificación Correcta'){
                                Swal.fire({
                                title: "Reserva Realizada",
                                text: "La modificación se ha realizado con exito",
                                icon: "success"
                                }).then((result) => {
                                    location.reload();
                                });
                            }else{
                                Swal.fire({
                                title: "Error Servidor",
                                text: "Ha habido un error en el servidor y no se ha completado la modificación",
                                icon: "error"
                                }).then((result) => {
                                    location.reload();
                                });
                            }
                        }
                    })
                }
            });

            //Mostrar Modal
            $(document).on("click", ".btn_modificar_reserva", function() {
                id_reserva=$(this).attr("id").split("_")[1];
                $("#modal_modificar_reserva").modal("show");
            });

            //Cerrar Modal
            $("#btn_cerrar_modificar_reserva").click(function(){
                $("#modal_modificar_reserva").modal("hide");
            });
        });
    </script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
</body>

</html>