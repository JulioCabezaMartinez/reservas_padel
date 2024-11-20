<?php
session_start();
//Prueba antes de crear controllers
require_once "../model/usuario.php";
require_once '../model/profesor.php';
require_once '../model/cliente.php';
require_once '../model/BuscadorDB.php';
$puntos=cliente::selectPuntosCliente($connection, 1); // El id del cliente se recogerá por Session.
$lista_profesores=profesor::selectAllProfesores($connection);
$lista_alumnos=cliente::selectAllClientes($connection);
//Prueba antes de crear controllers

$titulo="Inicio Admin";
require_once "./Templates/inicio.inc.php";

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
                        <!-- Motivo de Estado input -->
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
                        <!-- Motivo de Estado input -->
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
                            <br>
                            <label class="form-label" for="dia_modal">Dia:</label>
                            <select name="dia_modal_creacion" id="dia_modal">
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
        require_once "./Templates/barra_lateral.inc.php"; 
    ?>

    <main>
        <h2>Asignar Bonos a clientes</h2><br>

        <label>Indique a que alumno quiere añadir bonos:</label>
        <select name="" id="alumno">
        <?php
            foreach($lista_alumnos as $alumno){
        ?>
            <option value="<?php echo $alumno->id_cliente ?>"><?php echo $alumno->nombre." ".$alumno->apellidos ?></option>
        <?php
            }
        ?>    
        </select><br>
        <br>
        <label>Indique la cantidad de bonos que va a modificar: </label>
        <input type="number" value="0" name="" id="bonos" max="10" min="0">
        <br>
        <button id="btn_recargar_bonos" class="btn btn-warning">Recargar</button>
        <br>
        <hr>
        <br><!-- -------------------------------------------------------------------- -->
        <h2>Modificar Añadir Horarios</h2>
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
                    url:"../controller/AJAX.php", //Esto debe cambiarse cuando se llame a las vistas por el controller.
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
                    url:"../controller/AJAX.php", //Esto debe cambiarse cuando se llame a las vistas por el controller.
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
                    url:"../controller/AJAX.php", //Esto debe cambiarse cuando se llame a las vistas por el controller.
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
            })
        });
    </script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
</body>
</html>