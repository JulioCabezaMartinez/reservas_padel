<?php

session_start();

if (!empty($_SESSION)) {
    header("Location:../../../src/controller/actions_usuario.php?action=0");
    die();
}
$titulo="login";
require_once "../view/Templates/inicio.inc.php";

?>
<title>Login</title>
</head>

<body>
    <?php

    if (isset($_GET['action'])) {
        if ($_GET['action'] == 1) { //Fallo de Login.
            echo '<!-- Modal de Confirmación de fallo de login -->
                            <div class="modal fade" id="fallo_login" tabindex="-1" >
                                <div class="modal-dialog modal-dialog-centered" >
                                    <div class="modal-content">
                                        <div class="modal-header" >
                                            <h5 id="confirmacion_header" class="modal-title" id="exampleModalLongTitle">Fallo de incio de sesión</h5>
                                        </div>
                                        <div class="modal-body">
                                            <label id="confirmacion_body">Las credenciales no son correctas.</label>
                                        </div>
                                        <div class="modal-footer">
                                            <button id="btn_cerrar_confirmacion" type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <!-- Modal de Confirmación de fallo de login -->
                <script>
                    $(document).ready(function(){
                        $("#fallo_login").modal("show");
                        $("#btn_cerrar_confirmacion").on("click", function() {
                            $("#fallo_login").modal("hide");
                        });
                    });
                </script>';
        }

        if ($_GET['action'] == 3) { //Cambio de contraseña
            echo '<!-- Modal de Confirmación de cambio de pass -->
                            <div class="modal fade" id="cambio_pass" tabindex="-1" >
                                <div class="modal-dialog modal-dialog-centered" >
                                    <div class="modal-content">
                                        <div class="modal-header" >
                                            <h5 id="confirmacion_header" class="modal-title" id="exampleModalLongTitle">Cambio de contraseña</h5>
                                        </div>
                                        <div class="modal-body">
                                            <label id="confirmacion_body">Contraseña cambiada con exito.</label>
                                        </div>
                                        <div class="modal-footer">
                                            <button id="btn_cerrar_confirmacion" type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <!-- Modal de Confirmación de cambio de pass -->
                <script>
                    $(document).ready(function(){
                        $("#cambio_pass").modal("show");
                        $("#btn_cerrar_confirmacion").on("click", function() {
                            $("#cambio_pass").modal("hide");
                        });
                    });
                </script>';
        }
        if ($_GET['action'] == 'register') { //Registro completado
                echo 
                '<!-- Modal de Registro -->
                            <div class="modal fade" id="registro_ok" tabindex="-1" >
                                <div class="modal-dialog modal-dialog-centered" >
                                    <div class="modal-content">
                                        <div class="modal-header" >
                                            <h5 id="confirmacion_header" class="modal-title" id="exampleModalLongTitle">Registro</h5>
                                        </div>
                                        <div class="modal-body">
                                            <label id="confirmacion_body">Registro realizado con exito.</label>
                                        </div>
                                        <div class="modal-footer">
                                            <button id="btn_cerrar_confirmacion" type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <!-- Modal de Confirmación Registro -->
                <script>
                    $(window).on("load", function(){
                        $("#registro_ok").modal("show");
                        $("#btn_cerrar_confirmacion").on("click", function() {
                            $("#registro_ok").modal("hide");
                        });
                    });
                </script>';
        }

        if($_GET['action'] == 'error'){//Fallo de registro.
            echo '<!-- Modal de Confirmación de fallo de permisos -->
                    <div class="modal fade" id="fallo_usuario" tabindex="-1" >
                        <div class="modal-dialog modal-dialog-centered" >
                            <div class="modal-content">
                                <div class="modal-header" >
                                    <h5 id="confirmacion_header" class="modal-title" id="exampleModalLongTitle">Fallo de registro</h5>
                                </div>
                                <div class="modal-body">
                                    <label id="confirmacion_body">' . $_GET['error'] . '</label>
                                </div>
                                <div class="modal-footer">
                                    <button id="btn_cerrar_confirmacion" type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- Modal de Confirmación de fallo de permisos -->
        <script>
             $(window).on("load", function(){
                $("#fallo_usuario").modal("show");
                $("#btn_cerrar_confirmacion").on("click", function() {
                    $("#fallo_usuario").modal("hide");
                });
            });
        </script>';
        }
    }
    ?>

    <!-- Modal de Olvido Pass -->
    <div class="modal fade" id="modal_olvido_pass" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Recuperación de contraseña</h5>
                </div>
                <div class="modal-body">
                    <div class="form-outline">
                        <p>Indique su correo para enviarle un codigo de recuperación.</p><br>
                        <label class="form-label" for="correo_modal">Correo:</label><br>
                        <input class="form-control w-50" id="correo_modal" type="email" name="correo_modal" required>
                        <p id="error_correo" style="color: red;"></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="btn_cerrar_modal" type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button id="btn_enviar_correo" type="button" class="btn btn-primary w-50" data-dismiss="modal">Enviar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal de Olvido Pass -->

    <!-- Modal de Confirmación envio de correo -->
    <div class="modal fade" id="envio_ok" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="confirmacion_header" class="modal-title" id="exampleModalLongTitle">Recuperacion de contraseña</h5>
                </div>
                <div class="modal-body">
                    <label id="confirmacion_body">Correo enviado, compruebe su bandeja de entrada.</label>
                </div>
                <div class="modal-footer">
                    <button id="btn_cerrar_correo" type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal de Confirmación envio de correo -->

    <img class="DonDigitalLogo" src='../../assets/IMG/Imagotipo_Color_Negativo.webp'>
    <br><br>
    <label style="font-size: 150%;font-weight: bold;">LOGIN</label>
    <div class="registro_login">
        <form action="../controller/actions_usuario.php" method="post">
            <label for="tipo">Tipo de Usuario:</label><br><br>
            <input type="radio" name="tipo" value="Profesor"><label>Profesor</label>
            <input type="radio" name="tipo" value="Alumno" checked><label>Alumno</label>
            <br><br>
            <label for="correo">Correo:</label><br>
            <input type="email" name="correo" maxlength="60">
            <br><br>
            <label for="pass">Contraseña:</label><br>
            <input type="password" name="pass" maxlength="60" required>
            <br><br>
            <input type="submit" name="login" value="Iniciar Sesión">
            <br><br>
            <a style="font-size: 130%;" href="./register.php">Nuevo Usuario</a><br><br>
            <p>Si ha olvidado su contraseña pulse <span id="recuperar_pass" class="link_falso">aqui</span></p>
        </form>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script>
        let correo;
        $(document).ready(function() {
            $("#recuperar_pass").click(function() {
                $("#modal_olvido_pass").modal("show");
            });
            
            $("#btn_enviar_correo").click(function() {
                correo = $("#correo_modal").val();
                $.ajax({
                    url: "../controller/AJAX.php",
                    method: "POST",
                    data: {
                        mode: "recuperar_pass",
                        correo: correo
                    },
                    success: function(data) {
                        if(data=="Todo correcto"){
                            $("#modal_olvido_pass").modal("hide");
                            $("#envio_ok").modal("show");
                        }else if(data=="Correo no valido"){
                            $("#error_correo").text("Su correo no se encuentra en la base de datos");
                        }
                    }
                        
                });
            });

            $('#btn_cerrar_modal').on('click', function() {
                $('#envio_ok').modal('hide');
            });

            $('#btn_cerrar_correo').on('click', function() {
                window.location.href = "recuperar_pass.php?correo="+correo;
            });

        });
    </script>
</body>

</html>