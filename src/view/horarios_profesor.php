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

        <footer>
            <h1>Aplicación web desarrollada por <a style="text-decoration: none; color: #1A73E8" href="https://dondigital.es">DonDigital.es</a></h1>
            <img id="logo_barra" src="../../../assets/IMG/Logo_DonDigital_barra2.svg">
        </footer>
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
        });
        
    </script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
</body>

</html>