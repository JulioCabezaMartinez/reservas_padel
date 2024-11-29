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

    <!-- Modal MODIFICAR Alumno -->
    <div class="modal fade" id="modal_modificar_alumno" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog d-flex justify-content-center">
                <div class="modal-content w-100">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel3">Modificación de Alumno</h5>
                    </div>
                    <div class="modal-body p-4">
                        <form>
                            <div data-mdb-input-init class="form-outline mb-4">
                                
                                <div>
                                    <label for="nombre_modal">Nombre:</label><br>
                                    <input class="form-control" type="text" name="nombre_modal" id="nombre_modal">
                                    <br><br>
                                    <label for="apellidos_modal">Apellidos:</label><br>
                                    <input class="form-control" type="text" name="apellidos_modal" id="apellidos_modal">
                                    <br><br>
                                    <label for="DNI_modal">DNI:</label><br>
                                    <input class="form-control w-25" type="text" name="DNI_modal" id="DNI_modal">
                                    <br><br>
                                    <label for="clases_modal">Clases:</label><br>
                                    <input class="form-control w-25" type="number" value="0" name="clases_modal" id="clases_modal" max="20" min="0">
                                    <br><br>
                                    <label for="correo_modal">Correo:</label><br>
                                    <input class="form-control" type="text" name="correo_modal" id="correo_modal">
                                </div>
                            </div>
                            <button id="btn_cerrar_modificar" type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button id="btn_guardar_modificar_alumno" type="button" class="btn btn-primary w-50" data-dismiss="modal">Modificar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal MODIFICAR alumno -->

        <!-- Modal CAMBIAR password -->
        <div class="modal fade" id="modal_modificar_password" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog d-flex justify-content-center">
                <div class="modal-content w-100">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel3">Modificación de Contraseña</h5>
                    </div>
                    <div class="modal-body p-4">
                        <form>
                            <div data-mdb-input-init class="form-outline mb-4">
                                <div>
                                   <label for="nueva_password">Introduce la nueva Contraseña:</label><br>
                                   <input type="password" class="form-control" name="nueva_password" id="nueva_password">
                                   <br>
                                   <label for="nueva_confirm">Confirme la nueva Contraseña: </label><br>
                                   <input type="password" class="form-control" name="nueva_confirm" id="nueva_confirm">
                                   <br>
                                   <span id="error_pass" class="d-none" style="color: red;">Las contraseñas no coinciden</span>
                                </div>
                            </div>
                            <button id="btn_cerrar_password" type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button id="btn_guardar_modificar_password" type="button" class="btn btn-primary w-50" data-dismiss="modal">Modificar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal CAMBIAR password -->

        <h2>Lista Alumnos</h2>
            <table class="table">
            <thead>
                <tr>
                    <th scope="col">Nombre</th>
                    <th>Apellidos</th>
                    <th>DNI</th>
                    <th>Clases</th>
                    <th>Correo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="body_reservas">
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
                        <button id="btn_<?php echo $alumno->id_cliente?>" data-nombre="<?php echo $alumno->nombre ?>" data-apellidos="<?php echo $alumno->apellidos ?>" data-DNI="<?php echo $alumno->DNI ?>" data-correo="<?php echo $alumno->getCorreo() ?>" data-puntos="<?php echo $alumno->puntos ?>" class="btn_modificar_alumno btn btn-primary m-1"><i class="fa-solid fa-pen me-2"></i>Modificar Alumno</button>
                        <br>
                        <button id="btn_<?php echo $alumno->id_cliente?>" class="btn_modificar_password_alumno btn btn-primary m-1"><i class="fa-solid fa-pen me-2"></i>Cambiar Contraseña</button>
                    </td>
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
        $(document).ready(function(){
            var id_alumno;
            $(document).on('click', '.btn_modificar_alumno', function(){
                id_alumno=$(this).attr("id").split('_')[1];
                $("#nombre_modal").val($(this).attr("data-nombre"));
                $("#apellidos_modal").val($(this).attr("data-apellidos"));
                $("#DNI_modal").val($(this).attr("data-DNI"));
                $("#correo_modal").val($(this).attr("data-correo"));
                $("#clases_modal").val($(this).attr("data-puntos"));

                $("#modal_modificar_alumno").modal("show");
            });

            $(document).on('click', '.btn_modificar_password_alumno', function(){
                id_alumno=$(this).attr("id").split('_')[1];

                $("#modal_modificar_password").modal("show");
            });

            $("#btn_guardar_modificar_alumno").click(function(){
                let nombre_alumno=$("#nombre_modal").val();
                let apellidos_alumno=$("#apellidos_modal").val();
                let DNI_alumno=$("#DNI_modal").val();
                let correo_alumno=$("#correo_modal").val();
                let puntos_alumno=$("#clases_modal").val();

                if(nombre_alumno=='' || apellidos_alumno=='' || DNI_alumno=='' || correo_alumno==''|| puntos_alumno==''){
                    $("#error_modal").removeClass("d-none");
                }else{
                    $.ajax({
                        url: "AJAX.php",
                        method: "POST",
                        data:{
                            mode: "update_alumno",
                            id_alumno:id_alumno,
                            nombre_alumno:nombre_alumno,
                            apellidos_alumno:apellidos_alumno,
                            DNI_alumno:DNI_alumno,
                            puntos_alumno:puntos_alumno,
                            correo_alumno:correo_alumno
                        },
                        success: function(data){
                            if(data=="Update Correcto"){
                                Swal.fire({
                                title: "Alumno modificado",
                                text: "El alumno"+ nombre_alumno + " "+ apellidos_alumno +" se ha modificado con exito",
                                icon: "success"
                                }).then((result)=>{
                                    location.reload();
                                });
                            }else{
                                Swal.fire({
                                title: "Error Servidor",
                                text: "Ha habido un error en el servidor y no se ha modificado el alumno",
                                icon: "error"
                                }).then((result)=>{
                                    location.reload();
                                });
                            }
                        }
                    })
                }
            });

            $("#btn_guardar_modificar_password").click(function(){
                let nueva_pass=$("#nueva_password").val();
                let nueva_confirm=$("#nueva_confirm").val();

                if(nueva_pass==nueva_confirm){
                    $.ajax({
                        url: "AJAX.php",
                        method: "POST",
                        data:{
                            mode: "cambiar_pass_alumno",
                            nueva_pass:nueva_pass,
                            nueva_confirm:nueva_confirm,
                            id_alumno:id_alumno
                        },
                        success:function(data){
                            if(data=="Update Correcto"){
                                Swal.fire({
                                title: "Contraseña Modificada",
                                text: "La contraseña se ha modificado con exito",
                                icon: "success"
                                }).then((result)=>{
                                    location.reload();
                                });
                            }else{
                                Swal.fire({
                                title: "Error Servidor",
                                text: "Ha habido un error en el servidor y no se ha modificado la contraseña",
                                icon: "error"
                                }).then((result)=>{
                                    location.reload();
                                });
                            }
                        }
                    })
                }else{
                    $("#error_pass").removeClass("d-none");
                }

                
            });

            //Cerrar Modal
            $("#btn_cerrar_modificar").click(function(){
                $("#modal_modificar_alumno").modal("hide");
            });

            $("#btn_cerrar_password").click(function(){
                $("#modal_modificar_password").modal("hide");
            });
        });
    </script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
</body>
</html>