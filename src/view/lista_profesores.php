<?php

if (empty($_SESSION) || !isset($_SESSION)){
    header("Location:/src/view/login.php");
    die();
}

$titulo="Lista Profesores";
require_once "../view/Templates/inicio.inc.php";

?>

<body>

    <?php
        require_once "../view/Templates/barra_lateral.inc.php"; 
    ?>

    <main class="my-4">
        <!-- Modal MODIFICAR Profesor -->
        <div class="modal fade" id="modal_modificar_profesor" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog d-flex justify-content-center">
                <div class="modal-content w-100">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel3">Modificación de Profesor</h5>
                    </div>
                    <div class="modal-body p-4">
                        <form>
                            <div data-mdb-input-init class="form-outline mb-4">
                                <div>
                                    <label for="nombre_modal">Nombre:</label><br>
                                    <input class="form-control" type="text" name="nombre_modal" id="nombre_modal">
                                    <br>
                                    <label for="apellidos_modal">Apellidos:</label><br>
                                    <input class="form-control" type="text" name="apellidos_modal" id="apellidos_modal">
                                    <br>
                                    <label for="DNI_modal">DNI:</label><br>
                                    <input class="form-control" type="text" name="DNI_modal" id="DNI_modal">
                                    <br>
                                    <label for="correo_modal">Correo:</label><br>
                                    <input class="form-control" type="text" name="correo_modal" id="correo_modal">
                                    <br>
                                    <p id="error_modal" class="d-none" style="color: red;">Se deben de rellenar todos los campos</p>
                                </div>
                            </div>
                            <button id="btn_cerrar_modificar" type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button id="btn_guardar_modificar_profesor" type="button" class="btn btn-primary w-50" data-dismiss="modal">Modificar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal MODIFICAR Profesor -->

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

        <h2>Lista Profesores</h2>
            <table class="table">
            <thead>
                <tr>
                    <th scope="col">Nombre</th>
                    <th>Apellidos</th>
                    <th>DNI</th>
                    <th>Correo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="body_reservas">
            <?php
            foreach($lista_profesores as $profesor){
            ?>
                <tr>
                    <td><?php echo $profesor->nombre ?></td>
                    <td><?php echo $profesor->apellidos ?></td>
                    <td><?php echo $profesor->DNI ?></td>
                    <td><?php echo $profesor->getCorreo() ?></td>
                    <td>
                        <button id="btn_<?php echo $profesor->id_profesor?>" data-nombre="<?php echo $profesor->nombre ?>" data-apellidos="<?php echo $profesor->apellidos ?>" data-DNI="<?php echo $profesor->DNI ?>" data-correo="<?php echo $profesor->getCorreo() ?>" class="btn_modificar_profesor btn btn-primary m-1"><i class="fa-solid fa-pen me-2"></i>Modificar Profesor</button>
                        <br>
                        <button id="btn_<?php echo $profesor->id_profesor?>" class="btn_modificar_password_alumno btn btn-primary m-1"><i class="fa-solid fa-pen me-2"></i>Cambiar Contraseña</button>
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
            var id_profesor;
            $(document).on('click', '.btn_modificar_profesor', function(){
                id_profesor=$(this).attr("id").split('_')[1];
                $("#nombre_modal").val($(this).attr("data-nombre"));
                $("#apellidos_modal").val($(this).attr("data-apellidos"));
                $("#DNI_modal").val($(this).attr("data-DNI"));
                $("#correo_modal").val($(this).attr("data-correo"));

                $("#modal_modificar_profesor").modal("show");
            });

            $(document).on('click', '.btn_modificar_password_alumno', function(){
                id_profesor=$(this).attr("id").split('_')[1];

                $("#modal_modificar_password").modal("show");
            });

            $("#btn_guardar_modificar_profesor").click(function(){
                let nombre_profesor=$("#nombre_modal").val();
                let apellidos_profesor=$("#apellidos_modal").val();
                let DNI_profesor=$("#DNI_modal").val();
                let correo_profesor=$("#correo_modal").val();

                if(nombre_profesor=='' || apellidos_profesor=='' || DNI_profesor=='' || correo_profesor==''){
                    $("#error_modal").removeClass("d-none");
                }else{
                    $.ajax({
                        url: "AJAX.php",
                        method: "POST",
                        data:{
                            mode: "update_profesor",
                            id_profesor:id_profesor,
                            nombre_profesor:nombre_profesor,
                            apellidos_profesor:apellidos_profesor,
                            DNI_profesor:DNI_profesor,
                            correo_profesor:correo_profesor
                        },
                        success: function(data){
                            if(data=="Update Correcto"){
                                Swal.fire({
                                title: "Profesor modificado",
                                text: "El profesor"+ nombre_profesor + " "+ apellidos_profesor +" se ha modificado con exito",
                                icon: "success"
                                }).then((result)=>{
                                    location.reload();
                                });
                            }else{
                                Swal.fire({
                                title: "Error Servidor",
                                text: "Ha habido un error en el servidor y no se ha modificado el profesor",
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
                            mode: "cambiar_pass_profesor",
                            nueva_pass:nueva_pass,
                            nueva_confirm:nueva_confirm,
                            id_profesor:id_profesor
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
                $("#modal_modificar_profesor").modal("hide");
            });

            $("#btn_cerrar_password").click(function(){
                $("#modal_modificar_password").modal("hide");
            });
        });
    </script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
</body>
</html>