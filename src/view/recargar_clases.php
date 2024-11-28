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
        
        <div class="w-25 dos_columnas"> <!-- Poner un Grid 2 columns -->
                <label>NOMBRE:</label>
                <input class="form-control" id="mostrar_seleccion_nombre" type="text" readonly>

                <label>APELLIDOS:</label>
                <input class="form-control" id="mostrar_seleccion_apellidos" type="text" readonly>

                <label>DNI:</label>
                <input class="form-control w-75" id="mostrar_seleccion_DNI" type="text" readonly>
        </div>

        <span id="error_alumnos" class="d-none" style="color: red;">Debe seleccionar un alumno al que recargar las clases</span>
        <br><br>
        <label>INDIQUE LA CANTIDAD DE BONOS QUE VA AÑADIR: </label>
        <input class="border rounded" type="number" value="0" name="" id="bonos" max="20" min="0">
        <br><br>
        <button id="btn_recargar_bonos" class="btn btn-warning">Recargar</button>
        <br>
        <hr>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Nombre</th>
                    <th>Apellidos</th>
                    <th>DNI</th>
                    <th>Puntos</th>
                    <th>Correo</th>
                    <!-- <th>Acciones</th> -->
                    <th>
                        <div class="input-group flex-nowrap">
                            <input id="buscador_tabla" type="text" class="w-50 border"  aria-label="Username" aria-describedby="addon-wrapping">
                            <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-magnifying-glass"></i></span>
                        </div>
                    </th>
                </tr>
                
            </thead>
            <tbody id="body_alumnos">
            <?php

            foreach($lista_alumnos as $alumno){
            ?>
                <tr>
                    
                    <td><?php echo $alumno->nombre ?></td>
                    <td><?php echo $alumno->apellidos ?></td>
                    <td><?php echo $alumno->DNI ?></td>
                    <td><?php echo $alumno->puntos ?></td>
                    <td><?php echo $alumno->getCorreo() ?></td>
                    <td>
                        <button data-datos="<?php echo $alumno->nombre ?>_<?php echo $alumno->apellidos ?>_<?php echo $alumno->DNI?>" class="btn btn-outline-primary btn-seleccionar">Seleccionar</button>
                        <!-- <button id="btn_<?php echo $alumno->id_cliente?>" data-nombre="<?php echo $alumno->nombre ?>" data-apellidos="<?php echo $alumno->apellidos ?>" data-DNI="<?php echo $alumno->DNI ?>" data-correo="<?php echo $alumno->getCorreo() ?>" data-puntos="<?php echo $alumno->puntos ?>" class="btn_modificar_alumno btn btn-primary m-1"><i class="fa-solid fa-pen me-2"></i>Modificar Alumno</button> -->
                        <!-- <br>
                        <button id="btn_<?php echo $alumno->id_cliente?>" class="btn_modificar_password_alumno btn btn-primary m-1"><i class="fa-solid fa-pen me-2"></i>Cambiar Contraseña</button> -->
                    </td>
                </tr>
            <?php
            }

            ?>
            </tbody>
            </table>

            <footer>
                <h1>Aplicación web desarrollada por <a style="text-decoration: none; color: #1A73E8" href="https://dondigital.es">DonDigital.es</a></h1>
                <img id="logo_barra" src="../../../assets/IMG/Logo_DonDigital_barra2.svg">
            </footer>
        </main>

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

            //Seleccionar Alumno

            var DNI_alumno="";
            $(document).on("click", ".btn-seleccionar", function(){
                let nombre_alumno=$(this).attr("data-datos").split("_")[0];
                let apellidos_alumno=$(this).attr("data-datos").split("_")[1];
                DNI_alumno=$(this).attr("data-datos").split("_")[2];

                $("#mostrar_seleccion_nombre").val(nombre_alumno);
                $("#mostrar_seleccion_apellidos").val(apellidos_alumno);
                $("#mostrar_seleccion_DNI").val(DNI_alumno);
            });

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
                if(DNI_alumno==""){
                    $("#error_alumnos").removeClass("d-none");
                }else{
                    
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
            let tabla_entera=$("#body_alumnos").html();
            $("#buscador_tabla").on('keyup', function(){
                let buscador=$(this).val();

                if(buscador==""){
                    $("#body_alumnos").html(tabla_entera);
                }else{
                    $.ajax({
                        url: "AJAX.php",
                        method: "POST",
                        data:{
                            mode: "buscador_alumnos",
                            buscador:buscador
                        },
                        success:function(data){
                            $("#body_alumnos").html(data);
                        }
                    })
                }
            });
        });
    </script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
</body>
</html>