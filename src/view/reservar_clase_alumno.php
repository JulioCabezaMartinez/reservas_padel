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
        <div>
            <h3>Desde aqui puede reservar una clase de padel con alguno de nuestros profesores:</h3>

            <div id="profesor">
                <label style="font-weight: bold;" for="profesor_text">Indique su profesor de padel: </label>
                <select name="" id="profesor_select">
                    <?php
                    foreach ($lista_profesores as $profesor) {
                    ?>
                        <option data-img-label="<?php echo $profesor->nombre . ' ' . $profesor->apellidos ?>" data-img-src="../../assets/IMG/<?php echo $profesor->nombre . '_' . $profesor->apellidos . ".jpg" ?>" value="<?php echo $profesor->id_profesor ?>"><?php echo $profesor->nombre ?></option>
                    <?php
                    }
                    ?>
                </select>
                <div id="imagen_profesor" style="width: 300px;"></div>
                <br>
                <br>
                <div>
                    <button id="btn_seleccionar_profesor" class="btn btn-success">Siguiente</button>
                </div>


                <!-- Span ocultos para enviar los datos -->
                <span id="profesor_selected" class="d-none"></span>
            </div>

            <div id="reserva" class="d-none">
                <div id="text_horario" class="d-flex">
                    Fecha:
                    <input id="fecha_text" type="text" readonly>
                    Hora:
                    <input id="hora_text" type="text" readonly>
                </div>

                <div class="d-flex m-4">
                    <div id="datepicker"></div>
                    <div class="row row-cols-3 m-4" id="horas"></div>
                </div>
                <!-- <button id="btn_select_horario" class="btn btn-primary d-none" style="width: fit-content; height:fit-content;">Seleccionar Fecha y Hora</button> -->
                <br>
                <br>
                <button id="btn_seleccionar_horario" class="btn btn-success">Siguiente</button>
                <button id="btn_atras_horario" class="btn btn-secondary">Atras</button>

                <!-- Span ocultos para enviar los datos -->
                <span id="id_horario" class="d-none"></span>
                <span id="hora_selected" class="d-none"></span>
                <span id="fecha_selected" class="d-none"></span>
                <span id="dia_selected" class="d-none"></span>
            </div>

            <div class="d-none w-25" id="pago">
                <div class="d-flex flex-column">
                    <h3>Reserva de Pista</h3>
                    <p>Balance: <?php echo $puntos ?><i class="fa-solid fa-table-tennis-paddle-ball mx-2"></i> - 1<i class="fa-solid fa-table-tennis-paddle-ball mx-2"></i></p>
                    <hr>
                    <?php
                    if (($puntos - 1) < 0) {
                    ?>
                        <p>Total: <span style="color: red;"><?php echo $puntos - 1 ?></span><i class="fa-solid fa-table-tennis-paddle-ball mx-2"></i></p>
                    <?php
                    } else {
                    ?>
                        <p>Total: <?php echo $puntos - 1 ?><i class="fa-solid fa-table-tennis-paddle-ball mx-2"></i></p>
                    <?php
                    }
                    ?>
                    <span id="puntos_final" class="d-none"><?php echo $puntos - 1 ?></span>
                </div>
                <br>
                <?php
                if (($puntos - 1) < 0) {
                ?>
                    <button id="btn_pagar" class="btn btn-warning" disabled>Pagar</button> <span style="color: red;">No dispone de los bonos suficientes</span>
                <?php
                } else {
                ?>
                    <button id="btn_pagar" class="btn btn-warning">Reservas</button>
                <?php
                }
                ?>
                <br><br>
                <button id="btn_atras_pagar" class="btn btn-secondary">Atras</button>
            </div>
        </div>
        <hr>

        <?php
        include '../view/Templates/footer.inc.php';
        ?>
    </main>
    <script>
        $(document).ready(function() {

            //Image Picker
            $("#profesor_select").imagepicker({
                show_label: true
            });


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
                    let id_profesor = $("#profesor_selected").text();

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


            $(document).on('click', '.btn_hora', function() {
                let hora = $(this).text();
                $("#hora_selected").text(hora);
                $("#id_horario").text($(this).attr("id").split("_")[2]); //Esto es mejorable debido a que puede generar un fallo humano. (Ponerse al pulsar el boton de siguiente)

                $("#fecha_text").val($("#fecha_selected").text());
                $("#hora_text").val($("#hora_selected").text());

            });

            $("#btn_select_horario").click(function() {
                $("#fecha_text").val($("#fecha_selected").text());
                $("#hora_text").val($("#hora_selected").text());
            });

            //Botones de seleccionar.
            $("#btn_seleccionar_profesor").click(function() {
                $("#profesor_selected").text($("#profesor_select").val());

                // AL SELECCIONAR EL PROFESOR SE AJUSTA LA PRIMERA ENTRADA DE LA BUSQUEDA DE CLASE.
                let targetDate = new Date();
                $("#datepicker").datepicker("setDate", targetDate);

                let formattedDate = $.datepicker.formatDate("dd/mm/yy", targetDate);
                let mes = targetDate.getMonth() + 1;
                dayName = daysOfWeek[targetDate.getDay()];
                $("#datepicker").datepicker("option", "onSelect")(formattedDate, null);

                let id_profesor = $("#profesor_selected").text();

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
                let meses_horario=[];
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
                            let mesIndex = parseInt(mesesArray[0]); // Toma el primer elemento y conviértelo a número
                            if (!isNaN(mesIndex)) {
                                meses_horario[mesIndex] = true; // Marca el mes como válido
                            }
                            console.log(meses_horario);
                            if (dayIndex !== undefined){
                                dias_horario[dayIndex]=true;
                            }
                        });

                        // Actualizamos la configuración del datepicker con los nuevos datos de horarios

                        // Objeto para almacenar los días completos
                        let diasCompletos = {};
                        $("#datepicker").datepicker("option", "beforeShowDay", function(date, inst) {
                            const dayOfWeek = date.getDay();
                            let monthOftheYear=date.getMonth();

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

                            if (dias_horario[dayOfWeek] && meses_horario[monthOftheYear+1]) {
                                return [true, "has-schedule", "Día con horario asignado"];
                            } else {
                                return [true, "", "Día sin horario asignado"];
                            }

                        });

                        // Inicializar el DatePicker después de cargar los datos
                        $("#datepicker").datepicker("refresh");
                    }
                });

                $("#reserva").removeClass("d-none");
                $("#profesor").addClass("d-none");
            });

            $("#btn_seleccionar_horario").click(function() {
                if ($("#fecha_text").val() == "" || $("#hora_text").val() == "") {
                    $("#text_horario").append('<p style="color: red;">Se necesita elegir un horario para la reserva</p>');
                } else {
                    $("#pago").removeClass("d-none");
                    $("#reserva").addClass("d-none");
                }
            });

            //Botones de ir hacía atras.
            $("#btn_atras_pagar").click(function() {
                $("#reserva").removeClass("d-none");
                $("#pago").addClass("d-none");

            });

            $("#btn_atras_horario").click(function() {
                $("#reserva").addClass("d-none");
                $("#profesor").removeClass("d-none");
            });


            $("#btn_pagar").click(function() {
                let puntos = $("#puntos_final").text();
                let id_horario = $("#id_horario").text();
                let id_profesor = $("#profesor_selected").text();
                let fecha = $("#fecha_selected").text();
                $.ajax({
                    url: "AJAX.php",
                    method: "POST",
                    data: {
                        mode: "pagar_reserva",
                        puntos: puntos,
                        id_horario: id_horario,
                        id_profesor: id_profesor,
                        fecha: fecha
                    },
                    success: function(data) {
                        if (data == "Update Correcto") {
                            Swal.fire({
                                title: "Reserva Realizada",
                                text: "La reserva se ha realizado con exito",
                                icon: "success"
                            }).then((result) => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: "Error Servidor",
                                text: "Ha habido un error en el servidor y no se ha completado la reserva",
                                icon: "error"
                            }).then((result) => {
                                location.reload();
                            });
                        }

                    }
                });
            });

        });
    </script>
</body>

</html>