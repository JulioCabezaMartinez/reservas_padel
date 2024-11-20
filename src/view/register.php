<?php

    session_start();
    $titulo="Registro";

require_once "../view/Templates/inicio.inc.php";

?>
<title>Register</title>
</head>
<body>
    <img class="DonDigitalLogo" src='../../assets/IMG/Imagotipo_Color_Negativo.webp'>
    <br><br>
    <label style="font-size: 150%;font-weight: bold;">REGISTRO</label>
    <div id="registro_login" class="registro_login">
        <form action="../controller/actions_usuario.php" enctype="multipart/form-data" method="post">

            <label for="nombre">*Nombre:</label><br>
            <input class="form-control" type="text" name="nombre" placeholder="Nombre" maxlength="45" required >
            <br><br>
            <label for="apellidos">*Apellidos:</label><br>
            <input class="form-control" type="text" name="apellidos" placeholder="Apellidos" maxlength="60" required>
            <br><br>
            <label for="correo">*Correo:</label><br>
            <input class="form-control" type="email" name="correo" maxlength="60" required>
            <br><br>
            <label for="pass">*Contraseña:</label><br>
            <input class="form-control" type="password" name="pass" maxlength="60" required>
            <br><br>
            <label for="confirm_pass">*Confirmar Contraseña:</label><br>
            <input class="form-control" type="password" name="confirm" maxlength="60" required>
            <br><br>
            <label for="tipo">Tipo de Usuario:</label><br><br>
            <input type="radio" name="tipo" value="Profesor"><label>Profesor</label>
            <input type="radio" name="tipo" value="Alumno" checked><label>Alumno</label>
            <br><br>
            <div class="submit">
                <input class="btn btn-primary" type="submit" name="register" value="Registrarse">
                <br>
                <a class="btn btn-secondary" href="./login.php">Volver</a>
            </div>
        </form>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>