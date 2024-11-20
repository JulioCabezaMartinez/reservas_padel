<?php

session_start();

    ini_set('display_errors', 1);
    error_reporting(E_ALL & ~E_NOTICE);

   

//Prueba antes de crear controllers
require_once '../model/usuario.php';
require '../model/profesor.php';
require '../model/cliente.php';
require '../model/BuscadorDB.php';
$puntos=cliente::selectPuntosCliente($connection, 1); // El id del cliente se recogerá por Session.
$lista_profesores=profesor::selectAllProfesores($connection);
//Prueba antes de crear controllers

$titulo="Inicio";
require_once "./Templates/inicio.inc.php";

?>

<body>

    <?php
        require_once "./Templates/barra_lateral.inc.php"; 
    ?>

    <main>
        <h1>Bienvenid@, <span></span></h1>
        <h3>Desde aqui puede reservar una clase de padel con alguno de nuestros profesores:</h3>

        <div id="profesor">
            <label for="profesor_text">Indique su profesor de padel: </label>
            <select name="" id="profesor_select">
                <?php
                    foreach($lista_profesores as $profesor){
                ?>
                    <option value="<?php echo $profesor->id_profesor ?>"><?php echo $profesor->nombre ?></option>
                <?php
                    }
                ?>
            </select>
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
            <button id="btn_select_horario" class="btn btn-primary d-none" style="width: fit-content; height:fit-content;">Seleccionar Fecha y Hora</button>
            <br>
            <br>
            <button id="btn_seleccionar_horario" class="btn btn-success">Siguiente</button>
            <button id="btn_atras_horario" class="btn btn-secondary">Atras</button>

            <!-- Span ocultos para enviar los datos -->
            <span id="hora_selected" class="d-none"></span>
            <span id="fecha_selected" class="d-none"></span>
            <span id="dia_selected" class="d-none"></span>
        </div>

        <div class="d-none w-25" id="pago">
            <div class="d-flex flex-column">
                <h3>Reserva de Pista</h3>
                <p>Balance: <?php echo $puntos ?><i class="fa-solid fa-table-tennis-paddle-ball mx-2"></i> -  1<i class="fa-solid fa-table-tennis-paddle-ball mx-2"></i></p>
                <hr>
                <p>Total: <?php echo $puntos-1 ?><i class="fa-solid fa-table-tennis-paddle-ball mx-2"></i></p>

            </div>
            <br>
            <button id="btn_pagar" class="btn btn-warning">Pagar</button>
            <br><br>
            <button id="btn_atras_pagar" class="btn btn-secondary">Atras</button>
        </div>
    </main>

    <script>
        

        $(document).ready(function(){
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

                    $.ajax({
                        url:"../controller/AJAX.php", //Esto debe cambiarse cuando se llame a las vistas por el controller.
                        method: "POST",
                        data:{
                            mode: "muestra_horas",
                            id_profesor: 1,
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
            });

            $("#btn_select_horario").click(function(){
                $("#fecha_text").val($("#fecha_selected").text());
                $("#hora_text").val($("#hora_selected").text());
            });

            //Botones de seleccionar.
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

        });
    </script>
</body>
</html>