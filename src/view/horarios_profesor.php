<?php


if (empty($_SESSION) || !isset($_SESSION)) {
    header("Location:../../../src/view/login.php");
    die();
}

$titulo = "Inicio";
require_once "../view/Templates/inicio.inc.php";

?>

<body>

    <?php
    require_once "../view/Templates/barra_lateral.inc.php";
    ?>

    <main>
        <h1>Bienvenid@, <span><?php echo $_SESSION['nombre'] ?></span></h1>

        <h3>Creación de horarios</h3>
        <div>
            <p>Mes/es:</p>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="enero" value="1">
                <label class="form-check-label" for="enero">Enero</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="febrero" value="2">
                <label class="form-check-label" for="febrero">Febrero</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="marzo" value="3">
                <label class="form-check-label" for="marzo">Marzo</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="abril" value="4">
                <label class="form-check-label" for="abril">Abril</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="mayo" value="5">
                <label class="form-check-label" for="mayo">Mayo</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="junio" value="6">
                <label class="form-check-label" for="junio">Junio</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="julio" value="7">
                <label class="form-check-label" for="julio">Julio</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="agosto" value="8">
                <label class="form-check-label" for="agosto">Agosto</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="septiembre" value="9">
                <label class="form-check-label" for="septiembre">Septiembre</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="octubre" value="10">
                <label class="form-check-label" for="octubre">Octubre</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="noviembre" value="11">
                <label class="form-check-label" for="noviembre">Noviembre</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="diciembre" value="12">
                <label class="form-check-label" for="diciembre">Diciembre</label>
            </div>
            <br><br>
            <label class="form-label" for="dia">Dia:</label>
            <select name="dia" id="dia">
                <option value="Lunes">Lunes</option>
                <option value="Martes">Martes</option>
                <option value="Miercoles">Miercoles</option>
                <option value="Jueves">Jueves</option>
                <option value="Viernes">Viernes</option>
                <option value="Sabado">Sabado</option>
                <option value="Domingo">Domingo</option>
            </select>

            <label for="hora_inicio">Hora de inicio: </label>
            <input class="timepicker" id="hora_inicio" name="hora_inicio">

            <label for="hora_final">Hora final: </label>
            <input class="timepicker" name="hora_final" id="hora_final">
            <br><br>
            <button id="btn_crear_horario" class="btn btn-success">Crear Horario</button>
        </div>
        <hr>
        <!-- Mis horarios -->
        <div>
            <h3>Mis Horarios</h3>
            <table class="table">
                <tr>
                    <th scope="col">Dia</th>
                    <th>Hora Inicio</th>
                    <th>Hora Final</th>
                    <th>Meses</th>
                    <!-- <th>Acciones</th> -->
                </tr>
                <tbody>
                    <?php
                    $meses = [
                        1 => "Enero",
                        2 => "Febrero",
                        3 => "Marzo",
                        4 => "Abril",
                        5 => "Mayo",
                        6 => "Junio",
                        7 => "Julio",
                        8 => "Agosto",
                        9 => "Septiembre",
                        10 => "Octubre",
                        11 => "Noviembre",
                        12 => "Diciembre"
                    ];

                    foreach ($lista_horarios as $horario) {
                    ?>
                        <tr>
                            <td><?php echo $horario["dia"] ?></td>
                            <td><?php echo $horario["hora_inicio"] ?></td><!-- Deberia cambiar de array Dinamico a Objecto -->
                            <td><?php echo $horario["hora_final"] ?></td><!-- Deberia cambiar de array Dinamico a Objecto -->
                            <td>
                                <?php
                                    $meses_DB=json_decode($horario["mes"], true);
                                    $fila='';
                                    for($i=0; $i<count($meses_DB); $i++){
                                        $fila.=$meses[$meses_DB[$i]]." ";
                                    }

                                    echo $fila;

                                    
                                ?>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <hr>

        <?php
        include '../view/Templates/footer.inc.php';
        ?>
    </main>

    <script>
        //TimePicker
        $(document).ready(function() {
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
        $(document).ready(function() {
            //Crear Horario
            $("#btn_crear_horario").click(function() {
                let dia = $("#dia").val();
                let hora_inicio = $("#hora_inicio").val();
                let hora_final = $("#hora_final").val();
                let meses=$(".form-check-input:checked").map(function() {
                    return $(this).val();
                }).get();

                $.ajax({
                    url: "AJAX.php",
                    method: "POST",
                    data: {
                        mode: "creacion_horario_profe",
                        dia: dia,
                        hora_inicio: hora_inicio,
                        hora_final: hora_final,
                        meses: meses
                    },
                    success: function(data) {
                        
                        if (data == "Insercción Correcta") {
                            Swal.fire({
                                title: "Horario Creado",
                                text: "El horario se ha creado con exito",
                                icon: "success"
                            }).then((result) => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: "Error Servidor",
                                text: "Ha habido un error en el servidor y no se ha creado el horario",
                                icon: "error"
                            }).then((result) => {
                                location.reload();
                            });
                        }
                    }
                });
            });
        });
    </script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
</body>

</html>