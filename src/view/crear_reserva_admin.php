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
        
        <div id="alumno">
            <label for="">Indique el nombre o el DNI del alumno: </label>
            <input id="alumnos">
            <br><br>
            <div class="w-25 dos_columnas"> <!-- Poner un Grid 2 columns -->
                <label>NOMBRE:</label>
                <input class="form-control" id="mostrar_seleccion_nombre" type="text" readonly>

                <label>APELLIDOS:</label>
                <input class="form-control" id="mostrar_seleccion_apellidos" type="text" readonly>

                <label>DNI:</label>
                <input class="form-control w-75" id="mostrar_seleccion_DNI" type="text" readonly>

                <label>Clases: <span id="alumno_puntos" class=""></span></label>
            </div>
            
            <br><br>
            <button id="btn_seleccionar_alumno" class="btn btn-success">Siguiente</button>

            <!-- Span ocultos para enviar los datos -->
            <span id="alumno_selected" class="d-none"></span>
            
        </div>
        <div id="profesor" class="d-none">
                <label style="font-weight: bold;" for="profesor_text">Indique su profesor de padel: </label>
                <select name="" id="profesor_select">
                    <?php
                        foreach($lista_profesores as $profesor){
                    ?>
                        <option data-img-label="<?php echo $profesor->nombre.' '.$profesor->apellidos ?>" data-img-src="../../assets/IMG/<?php echo $profesor->nombre.'_'.$profesor->apellidos.".jpg" ?>" value="<?php echo $profesor->id_profesor ?>"><?php echo $profesor->nombre ?></option>
                    <?php
                        }
                    ?>
                </select>
                <div id="imagen_profesor" style="width: 300px;"></div>
                <br>
                <br>
                <div>
                    <button id="btn_seleccionar_profesor" class="btn btn-success">Siguiente</button>
                    <button id="btn_atras_profesor" class="btn btn-secondary">Atras</button>
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
                    <p>Balance: <span class="puntos_prueba"></span><i class="fa-solid fa-table-tennis-paddle-ball mx-2"></i> -  1<i class="fa-solid fa-table-tennis-paddle-ball mx-2"></i></p>
                    <hr>
                    
                    <p>Total: <span class="puntos_prueba-1"><i class="fa-solid fa-table-tennis-paddle-ball mx-2"></i></p>
                    
                    <span id="puntos_final" class="d-none"><span class="puntos_prueba-1"></span>
                </div>
                <br>
                <button id="btn_pagar" class="btn btn-warning">Reservar</button>
                <br>
                <span id="error_pago" class="d-none" style="color: red;">No dispone de los bonos suficientes</span>
                <br><br>
                <button id="btn_atras_pagar" class="btn btn-secondary">Atras</button>
            </div>

            <?php
            include '../view/Templates/footer.inc.php';
        ?>
    </main>
        

    <script>
        $(document).ready(function(){
            //Autocomplete de JQuery
            let alumnos=<?php
                $nombres_alumnos=[];
                foreach($lista_alumnos as $alumno){
                   array_push($nombres_alumnos, $alumno->DNI."-".$alumno->nombre." ".$alumno->apellidos); 
                }
                echo json_encode($nombres_alumnos);
            ?>;

            $(function() {
                $( "#alumnos" ).autocomplete({
                source: alumnos,
                select:function(event, ui){

                    let DNI_alumno=ui.item.value.split("-")[0];

                    $("#mostrar_seleccion_nombre").val(ui.item.value.split("-")[1].split(" ")[0]);
                    $("#mostrar_seleccion_apellidos").val(ui.item.value.split("-")[1].split(" ")[1]);
                    $("#mostrar_seleccion_DNI").val(ui.item.value.split("-")[0]);
                    
                    $.ajax({
                    url: "AJAX.php",
                    method: "POST",
                    data:{
                        mode: "puntos_alumno_reserva_admin",
                        DNI_alumno:DNI_alumno
                    },
                    success:function(data){
                        let clases_alumno=data;
                        $("#alumno_puntos").text(clases_alumno);

                        $(".puntos_prueba").text(clases_alumno);
                        $(".puntos_prueba-1").text(parseInt($("#alumno_puntos").text())-1);

                        if((clases_alumno-1)<0){
                            $(".puntos_prueba-1").addClass("text-danger");
                            $("#btn_pagar").prop("disabled", true);
                            $("#error_pago").removeClass("d-none");
                        }else{
                            $(".puntos_prueba-1").removeClass("text-danger");
                            $("#btn_pagar").prop("disabled", false);
                            $("#error_pago").addClass("d-none");
                        }
                    }
                })
                }
                });
            } );

            //Image Picker
            $("#profesor_select").imagepicker({
                show_label: true
            });


            //DatePicker
            const daysOfWeek = ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"];
            var dayName;
            $("#datepicker").datepicker({
                onSelect: function(dateText, inst){
                    $("#fecha_selected").text(dateText);
                    $("#btn_select_horario").removeClass("d-none");
                    $("#hora_text").val("");

                    let dateParts = dateText.split("/");
                    let dateObject = new Date(dateParts[2], dateParts[1] - 1, dateParts[0]); // Año, Mes, Día
                    
                    // Obtener el nombre del día de la semana
                    dayName= daysOfWeek[dateObject.getDay()];
                    $("#dia_selected").text(dayName);
                    let id_profesor=$("#profesor_selected").text();

                    $.ajax({
                        url:"AJAX.php",
                        method: "POST",
                        data:{
                            mode: "muestra_horas",
                            id_profesor: id_profesor,
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

                $("#fecha_text").val($("#fecha_selected").text());
                $("#hora_text").val(hora);

                $("#id_horario").text($(this).attr("id").split("_")[2]); //Esto es mejorable debido a que puede generar un fallo humano. (Ponerse al pulsar el boton de siguiente)
            });

            $("#btn_select_horario").click(function(){
                $("#fecha_text").val($("#fecha_selected").text());
                $("#hora_text").val($("#hora_selected").text());
            });

            //Botones de seleccionar.

            //Tengo que poner restricciones en caso de que no se rellenen los datos.
            var id_alumno='';
            $("#btn_seleccionar_alumno").click(function(){
                $("#alumno_selected").text($("#alumnos").val());

                let DNI_alumno=$("#alumno_selected").text().split("-")[0];
                $.ajax({
                    url: "AJAX.php",
                    method: "POST",
                    data:{
                        mode: "recoger_id_alumno_admin",
                        DNI_alumno:DNI_alumno
                    },
                    success:function(data){
                        id_alumno=data;
                    }
                })

                $("#profesor").removeClass("d-none");
                $("#alumno").addClass("d-none");
            });

            $("#btn_seleccionar_profesor").click(function(){
                $("#profesor_selected").text($("#profesor_select").val());

                $("#reserva").removeClass("d-none");
                $("#profesor").addClass("d-none");
            });

            $("#btn_seleccionar_horario").click(function(){
                if($("#fecha_text").val()=="" || $("#hora_text").val()==""){
                    $("#text_horario").append('<p style="color: red;">Se necesita elegir un horario para la reserva</p>');
                }else{
                    $("#pago").removeClass("d-none");
                    $("#reserva").addClass("d-none");
                }
            });

            //Botones de ir hacía atras.
            $("#btn_atras_pagar").click(function(){
                $("#reserva").removeClass("d-none");
                $("#pago").addClass("d-none");
                
            });

            $("#btn_atras_horario").click(function(){
                $("#reserva").addClass("d-none");
                $("#profesor").removeClass("d-none");
            });

            $("#btn_atras_profesor").click(function(){
                $("#profesor").addClass("d-none");
                $("#alumno").removeClass("d-none");
                
            });

            // Boton de pagar
            $("#btn_pagar").click(function(){
                let puntos=$("#puntos_final").text();
                let id_horario=$("#id_horario").text();
                let id_profesor=$("#profesor_selected").text();
                let fecha=$("#fecha_selected").text();
                $.ajax({
                    url: "AJAX.php",
                    method: "POST",
                    data:{
                        mode: "pagar_reserva_admin",
                        puntos:puntos,
                        id_horario:id_horario,
                        id_profesor:id_profesor,
                        id_alumno:id_alumno,
                        fecha:fecha
                    },
                    success:function(data){
                        if(data=="Update Correcto"){
                            Swal.fire({
                            title: "Reserva Realizada",
                            text: "La reserva se ha realizado con exito",
                            icon: "success"
                            }).then((result)=>{
                                window.location.href = './actions_administrador.php?action=reservas';
                            });
                        }else{
                            Swal.fire({
                            title: "Error Servidor",
                            text: "Ha habido un error en el servidor y no se ha completado la reserva",
                            icon: "error"
                            }).then((result)=>{
                                location.reload();
                            });
                        }
                        
                    }
                });
            });
        });
    </script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
</body>
</html>