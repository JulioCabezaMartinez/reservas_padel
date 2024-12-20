<?php

    session_start();
    $titulo="Registro";

require_once "../view/Templates/inicio.inc.php";

?>
<title>Register</title>
</head>
<body>
    <div class="d-flex justify-content-center">
        <img class="DonDigitalLogo" style="width: 13%;" src='../../../assets/IMG/Logo_padel.jpg'>
        <img src="../../../assets/IMG/Logo_DonDigital_principal.svg" style="width: 25%;" alt="">
    </div>
    <div class="d-flex justify-content-center">
        <h1>Aplicación web desarrollada por <a style="text-decoration: none; color: #1A73E8" href="https://dondigital.es">DonDigital.es</a></h1>
    </div>
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
            <label for="DNI">*DNI:</label><br>
            <input class="form-control w-50" type="text" name="DNI" placeholder="12345678A" maxlength="9" pattern="(\d{8})([A-Z]{1})" required> <!-- Poner para el NIE -->
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