<?php

//Prueba antes de crear controllers
    

    // $lista_horarios=[];
    // $result=$connection->query("Select * from horarios where id_profesor=1;");

    // if($result!=false){
    //     $linea=$result->fetch_object();
        
    //     while($linea!=null){
    //         $horario=new horario(id_profesor: $linea->id_profesor, fecha: $linea->fecha, hora_inicio: $linea->hora_inicio, hora_final: $linea->hora_final, id_horario: $linea->id_horario);
    //         array_push($lista_horarios, $horario);
    //         $linea=$result->fetch_object();
    //     }
    // }
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
            <select name="" id="">
                <?php
                    //foreach($lista_profesores as $profesor){
                ?>
                    <!-- <option value="<?php //echo $profesor->nombre ?>"><?php //echo $profesor->nombre ?></option> -->
                <?php
                    //}
                ?>
            </select>
        </div>

        <div class="d-flex " id="reserva">
            Fecha:
            <input id="fecha_text" type="text" readonly>
            Hora:
            <input id="hora_text" type="text" readonly>
        </div>

        <div class="d-flex m-4">
            <div id="datepicker"></div>
            <div class="row row-cols-3 m-4" id="horas">
                <?php
                    //foreach($lista_horarios as $horario){
                ?>
                    <!-- <button class="btn btn-outline-primary btn_hora"><?php //echo $horario->hora_inicio." / ".$horario->hora_final ?> </button> -->
                <?php
                    //}
                ?>
                <!-- <button class="btn btn-outline-primary btn_hora">16:00</button>
                <button class="btn btn-outline-primary btn_hora">17:00</button>
                <button class="btn btn-outline-primary btn_hora">18:00</button>
                <button class="btn btn-outline-primary btn_hora">19:00</button>
                <button class="btn btn-outline-primary btn_hora">20:00</button> -->
                <span id="hora_selected" class="d-none"></span>
                <span id="fecha_selected" class="d-none"></span>
                <span id="dia_selected" class="d-none"></span>
            </div>
        </div>
        <button id="btn_seleccionar" class="btn btn-success">Seleccionar</button>

    </main>

    <script>
        

        $(document).ready(function(){
            const daysOfWeek = ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"];
            var dayName;
            $("#datepicker").datepicker({
                onSelect: function(dateText, inst){
                    $("#fecha_selected").text(dateText);

                    let dateParts = dateText.split("/");
                    let dateObject = new Date(dateParts[2], dateParts[1] - 1, dateParts[0]); // Año, Mes, Día
                    
                    // Obtener el nombre del día de la semana
                    dayName= daysOfWeek[dateObject.getDay()];
                    console.log(dayName);
                    $("#dia_selected").text(dayName);
                }
            });

            $(".btn_hora").click(function(){
                let hora=$(this).text();
                $("#hora_selected").text(hora);
            });

            $("#btn_seleccionar").click(function(){
                $("#fecha_text").val($("#fecha_selected").text());
                $("#hora_text").val($("#hora_selected").text());

                $.ajax({
                    url:"../controller/AJAX.php", //Esto debe cambiarse cuando se llame a las vistas por el controller.
                    method: "POST",
                    data:{
                        mode: "muestra_horas",
                        id_profesor: 1,
                        dia: dayName
                    },
                    success:function(){
                        
                    }
                });
            });
        });
    </script>
</body>
</html>