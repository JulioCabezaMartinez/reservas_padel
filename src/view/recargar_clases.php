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
        <h2>Asignar Clases a Alumnos</h2><br>

        <label>Indique a que alumno quiere añadir bonos (Puede buscar por DNI o por Nombre):</label>
        <input id="alumnos">
        <span id="error_alumnos" class="d-none" style="color: red;">Debe seleccionar un alumno al que recargar las clases</span>
        <br><br>
        <label>Indique la cantidad de bonos que va a modificar: </label>
        <input type="number" value="0" name="" id="bonos" max="20" min="0" step="5">
        <br><br>
        <button id="btn_recargar_bonos" class="btn btn-warning">Recargar</button>
        <br>
        <hr>

    <script>
        //TimePicker
        $(document).ready(function () {
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
                source: alumnos
                });
            } );

            //Restricción número de bonos.
            $("#bonos").change(function () {
                if (this.value > 10) {
                    this.value = 10; // Si es mayor a 10, se ajusta a 10
                } else if (this.value < 0) {
                    this.value = 0; // Si es menor a 0, se ajusta a 0
                }

                //Aqui se puede indicar si exclusivamente quiere multiplos de 5 o no para poner ifs de "Redondeo".
            });

            $("#btn_recargar_bonos").click(function(){
                let alumno=$("#alumnos").val();
                if(alumno==""){
                    $("#error_alumnos").removeClass("d-none");
                }else{
                    let DNI_alumno=alumno.split("-")[0];
                    let bonos=$("#bonos").val();

                    $.ajax({
                        url:"AJAX.php", //Esto debe cambiarse cuando se llame a las vistas por el controller.
                        method: "POST",
                        data:{
                            mode: "recarga_bonos",
                            alumno:DNI_alumno,
                            bonos:bonos
                        },
                        success:function(data){
                            if(data=="Recarga realizada con exito"){
                                Swal.fire({
                                title: "Recarga Realizada",
                                text: "La recarga se ha realizado con exito",
                                icon: "success"
                                }).then((result)=>{
                                    location.reload();
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
                }
                
            });
        });
    </script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
</body>
</html>