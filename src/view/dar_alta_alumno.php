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
        <button id="btn_dar_alta_alumno" class="btn btn-primary btn-diez">Dar de Alta</button>

        <?php
            include '../view/Templates/footer.inc.php';
        ?>
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
                        Swal.fire({
                                title: "Alumno creado",
                                text: "El alumno"+ nombre_alumno + " "+ apellidos_alumno +"se ha creado con exito",
                                icon: "success"
                                }).then((result)=>{
                                    location.reload();
                                });
                    }
                })
            });
        });
    </script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
</body>
</html>