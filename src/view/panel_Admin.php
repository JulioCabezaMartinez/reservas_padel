<?php

if (empty($_SESSION) || !isset($_SESSION)){
    header("Location:../../../src/view/login.php");
    die();
}

$titulo="Inicio Admin";
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
                                foreach($lista_profesores as $profesor){
                            ?>
                                <option value="<?php echo $profesor->id_profesor?>"><?php echo $profesor->nombre." ".$profesor->apellidos ?></option>
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
        <h2>Asignar Bonos a Alumnos</h2><br>

        <label>Indique a que alumno quiere añadir bonos (Puede buscar por DNI o por Nombre):</label>
        <input id="alumnos">
        <br>
        <br>
        <label>Indique la cantidad de bonos que va a modificar: </label>
        <input type="number" value="0" name="" id="bonos" max="10" min="0">
        <br>
        <button id="btn_recargar_bonos" class="btn btn-warning">Recargar</button>
        <br>
        <hr>
        <br><!-- -------------------------------------------------------------------- -->
        <h2>Modificar/Añadir Horarios</h2>
        <h4>Tabla de Horarios</h4>
        <button id="btn_añadir_horario" class="btn btn-primary"><i class="fa-regular fa-calendar-plus me-2"></i>Añadir Horario</button><br>
        <label>Indique a que profesor quiere ver el horario: </label>
        <select name="profesor" id="profesor">
            <option value="" selected>--Elija un profesor--</option>
        <?php
            foreach($lista_profesores as $profesor){
        ?>
            <option value="<?php echo $profesor->id_profesor?>"><?php echo $profesor->nombre." ".$profesor->apellidos ?></option>
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
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="body_profesores">
            
        </tbody>
        </table>
        <hr>
        <br><!-- -------------------------------------------------------------------- -->

        <h2>Crear Alumno</h2>
        <label for="nombre">*Nombre:</label><br>
        <input id="nombre_alumno" class="form-control w-25" type="text" name="nombre" placeholder="Nombre" maxlength="45" required >
        <br>
        <label for="apellidos">*Apellidos:</label><br>
        <input id="apellidos_alumno" class="form-control w-25" type="text" name="apellidos" placeholder="Apellidos" maxlength="60" required>
        <br>
        <label for="DNI">*DNI:</label><br>
        <input id="DNI_alumno" class="form-control w-25" type="text" name="DNI" placeholder="12345678A" maxlength="9" pattern="(\d{8})([A-Z]{1})" required> <!-- Poner para el NIE -->
        <br>
        <label for="correo">*Correo:</label><br>
        <input id="correo_alumno" class="form-control w-25" type="email" name="correo" maxlength="60" required>
        <br>
        <label for="pass">*Contraseña:</label><br>
        <input id="pass_alumno" class="form-control w-25" type="password" name="pass" maxlength="60" required>
        <br>
        <label for="confirm_pass">*Confirmar Contraseña:</label><br>
        <input id="confirm_alumno" class="form-control w-25" type="password" name="confirm" maxlength="60" required>
        <br>
        <button id="btn_dar_alta_alumno" class="btn btn-primary">Dar de Alta</button>
        <hr>
        <br><!-- -------------------------------------------------------------------- -->

        <h2>Crear Profesor</h2>
        <label for="nombre">*Nombre:</label><br>
        <input id="nombre_profesor" class="form-control w-25" type="text" name="nombre" placeholder="Nombre" maxlength="45" required >
        <br>
        <label for="apellidos">*Apellidos:</label><br>
        <input id="apellidos_profesor" class="form-control w-25" type="text" name="apellidos" placeholder="Apellidos" maxlength="60" required>
        <br>
        <label for="correo">*Correo:</label><br>
        <input id="correo_profesor" class="form-control w-25" type="email" name="correo" maxlength="60" required>
        <br>
        <label for="imagen_profesor">Inserte una imagen del profesor: </label>
        <input type="file" name="imagen_profesor" id="imagen_profesor">
        <br>
        <label for="pass">*Contraseña:</label><br>
        <input id="pass_profesor" class="form-control w-25" type="password" name="pass" maxlength="60" required>
        <br>
        <label for="confirm_pass">*Confirmar Contraseña:</label><br>
        <input id="confirm_profesor" class="form-control w-25" type="password" name="confirm" maxlength="60" required>
        <br>
        <button id="btn_dar_alta_profesor" class="btn btn-primary">Dar de Alta</button>
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

            $( function() {
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
            });

            $("#btn_recargar_bonos").click(function(){
                let alumno=$("#alumno").val();
                let bonos=$("#bonos").val();

                $.ajax({
                    url:"AJAX.php", //Esto debe cambiarse cuando se llame a las vistas por el controller.
                    method: "POST",
                    data:{
                        mode: "recarga_bonos",
                        alumno:alumno,
                        bonos:bonos
                    },
                    success:function(data){
                        console.log(data);
                    }
                });
            });

            $("#profesor").change(function(){
                id_profesor=$("#profesor").val();
                $.ajax({
                    url:"AJAX.php", //Esto debe cambiarse cuando se llame a las vistas por el controller.
                    method: "POST",
                    data:{
                        mode: "tabla_profesor",
                        id_profesor:id_profesor 
                    },
                    success:function(data){
                        $("#body_profesores").html(data);
                    }
                });
            });

            //Modales

            var id_horario;
            $(document).on("click", ".btn_modificar_horario", function(){
                $("#modal_modificar_horario").modal("show");
                id_horario=$(this).attr("id").split('_')[1];
            });

            $("#btn_guardar_modificar_horario").click(function(){
                let dia=$("#dia_modal").val();
                let hora_inicio=$("#hora_inicio_modal").val();
                let hora_final=$("#hora_final_modal").val();
                $.ajax({
                    url:"AJAX.php", //Esto debe cambiarse cuando se llame a las vistas por el controller.
                    method: "POST",
                    data:{
                        mode: "modificar_horario",
                        id_horario: id_horario,
                        dia: dia,
                        hora_inicio: hora_inicio,
                        hora_final: hora_final
                    },
                    success:function(data){
                        location.reload();
                    }
                });
            });

            $("#btn_añadir_horario").click(function(){
                $("#modal_añadir_horario").modal("show");
            });

            $("#btn_guardar_crear_horario").click(function(){
                let profesor_añadir=$("#profesor_modal_creacion").val();
                let dia_añadir=$("#dia_modal_creacion").val();
                let hora_inicio_añadir=$("#hora_inicio_modal_creacion").val();
                let hora_final_añadir=$("#hora_final_modal_creacion").val();

                $.ajax({
                    url: "AJAX.php",
                    method: "POST",
                    data:{
                        mode: "creacion_horario",
                        profesor:profesor_añadir,
                        dia:dia_añadir,
                        hora_inicio:hora_inicio_añadir,
                        hora_final:hora_final_añadir
                    },
                    success:function(data){
                        location.reload();
                    }
                });
            });

            //Cerrar Modales
            $("#btn_cerrar_modificar").click(function(){
                $("#modal_modificar_horario").modal("hide");
            });

            $("#btn_cerrar_crear").click(function(){
                $("#modal_añadir_horario").modal("hide");
            });

            //Dar de alta
            $("#btn_dar_alta_alumno").click(function(){
                let nombre_alumno=$("#nombre_alumno").val();
                let apellidos_alumno=$("#apellidos_alumno").val();
                let DNI_alumno=$("#DNI_alumno").val();
                let correo_alumno=$("#correo_alumno").val();
                let pass_alumno=$("#pass_alumno").val();
                let confirm_alumno=$("#confirm_alumno").val();

                $.ajax({
                    url: "AJAX.php",
                    method: "POST",
                    data:{
                        mode: "alta",
                        nombre:nombre_alumno,
                        apellidos:apellidos_alumno,
                        DNI:DNI_alumno,
                        correo:correo_alumno,
                        pass:pass_alumno,
                        confirm:confirm_alumno,
                        tipo:"Alumno"
                    },
                    success:function(data){
                        location.reload();
                    }
                })
            });

            $("#btn_dar_alta_profesor").click(function(){
                let nombre_profesor=$("#nombre_profesor").val();
                let apellidos_profesor=$("#apellidos_profesor").val();
                let correo_profesor=$("#correo_profesor").val();
                let imagen_profesor=$("#imagen_profesor")[0].files[0];
                let pass_profesor=$("#pass_profesor").val();
                let confirm_profesor=$("#confirm_profesor").val();

                let formData= new FormData();
                formData.append("mode", "alta");
                formData.append("nombre", nombre_profesor);
                formData.append("apellidos", apellidos_profesor);
                formData.append("correo", correo_profesor);
                formData.append("imagen", imagen_profesor);
                formData.append("pass", pass_profesor);
                formData.append("confirm", confirm_profesor);
                formData.append("tipo", "Profesor");

                $.ajax({
                    url: "AJAX.php",
                    method: "POST",
                    data:formData,
                    processData: false, // Impide que jQuery procese los datos, necesario para FormData
                    contentType: false, // Evita que jQuery defina el tipo de contenido
                    success:function(data){
                       console.log(data);
                    }
                })
            });
        });
    </script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
</body>
</html>