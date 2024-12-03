<?php

session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL & ~E_NOTICE);

if (empty($_SESSION) || !isset($_SESSION)){
    header("Location:/src/view/login.php");
    die();
}

$titulo="Recuperar Pass";

require_once '../view/Templates/inicio.inc.php';

?>
<title>Recuperación de contraseña:</title>
</head>

<body>

    <!-- Modal de Confirmación envio de correo -->
    <div class="modal fade" id="reset_ok" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="confirmacion_header" class="modal-title" id="exampleModalLongTitle">Recuperacion de contraseña</h5>
                </div>
                <div class="modal-body">
                    <label id="confirmacion_body">Contraseña modificada con exito.</label>
                </div>
                <div class="modal-footer">
                    <button id="btn_cerrar_confirmacion" type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal de Confirmación envio de correo -->

    <div class="col p-3">
        <div class="d-flex justify-content-center">
            <img class="DonDigitalLogo" style="width: 13%;" src='/assets/IMG/Logo_padel.jpg'>
            <img src="../../../assets/IMG/Logo_DonDigital_principal.svg" style="width: 25%;" alt="">
        </div>
        <h2>Recuperación de contraseña</h2><br><br>

        <a href="login.php?vuelta=1"><button>← Volver</button></a>

        <div id="comprobacion_codigo" class="d-flex flex-column m-4">
            <div class>
                <p>Indique el código que ha recibido por email.</p><br>
                <label for="codigo">Indique el código:</label><br>
                <input id="codigo" class="form-control" style="width: 20%;" type="password" name="codigo" required>
                <input id="correo" type="hidden" name="correo" value="<?php echo $_GET['correo'] ?>">
            </div><br>
            <button id="btn_comprueba_codigo" class="btn btn-outline-primary" style="width: 10%;">Comprobar</button>
        </div>

        <div id="nueva_pass" class="oculto d-flex flex-column m-4">
            <div>
                <label for="pass">Nueva Contraseña:</label><br>
                <input class="form-control" style="width: 20%;" type="password" name="pass" id="pass">
            </div>
            <br>
            <div>
                <label for="confirm_pass">Confirmación Contraseña:</label><br>
                <input class="form-control" style="width: 20%;" type="password" name="confirm_pass" id="confirm">
            </div>
            <br>
            <button id="btn_cambio_pass" class="btn btn-outline-primary" style="width: 20%;">Cambiar contraseña</button>
        </div>
    </div>
    </div> <!-- Div que cierra la barra lateral para que se mantenga en su lugar -->

    <script>
        let correo;
        $(document).ready(function() {
            $("#btn_comprueba_codigo").click(function() {
                let codigo_usuario = $("#codigo").val();
                correo = $("#correo").val();

                $.ajax({
                    url: "/src/controller/AJAX.php",
                    method: "POST",
                    data: {
                        mode: "comprobar_codigo_cambio_pass",
                        codigo: codigo_usuario,
                        correo: correo
                    },
                    success: function(data) {
                        if (data == 'Código correcto') {
                            $("#comprobacion_codigo").addClass('oculto');
                            $("#nueva_pass").removeClass('oculto');
                        }else{
                            $("#codigo").after('<p style="color: red;">El codigo no es correcto</p>');
                        }
                    }
                })
            });

            $("#btn_cambio_pass").click(function() {
                let pass = $("#pass").val();
                let confirm = $("#confirm").val();
                if(pass==confirm){
                    $.ajax({
                        url: "/src/controller/AJAX.php",
                        method: "POST",
                        data: {
                            mode: "reset_pass",
                            pass: pass,
                            confirm: confirm,
                            correo: correo
                        },
                        success: function(data) {
                            if(data=="Todo correcto"){
                                Swal.fire({
                                title: "Contraseña Modificada",
                                text: "La contraseña se ha modificado con exito",
                                icon: "success"
                                }).then((result)=>{
                                    window.location.href = "login.php?vuelta=1";
                                });
                            }else{
                                Swal.fire({
                                title: "Error Servidor",
                                text: "Ha habido un error en el servidor y no se ha modificado la contraseña",
                                icon: "error"
                                }).then((result)=>{
                                    window.location.href = "login.php?vuelta=1";
                                });
                            }
                            
                        }
                    });
                }else{
                    $("#confirm").after('<p style="color: red;">Las contraseñas no coinciden</p>');
                }
                
            });

        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>