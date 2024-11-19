<?php

require "../model/BuscadorDB.php";
require "../model/profesor.php";
require "../model/horario.php";

if(isset($_POST["mode"])){
    switch($_POST["mode"]){
        case "muestra_horas":

            $lista_horarios=horario::selectHorarioProfesorFecha($connection, $_POST["id_profesor"], $_POST["dia"]);

            foreach($lista_horarios as $horario){
                if(horario::compruebaDia($connection, $_POST["fecha"], $horario["id"])){
                    echo '<button class="btn btn-outline-primary btn_hora">'.$horario["hora_inicio"].'/'.$horario["hora_final"].'</button>';
                }else{
                    echo '<button class="btn btn-secondary btn_hora" disabled>'.$horario["hora_inicio"].'/'.$horario["hora_final"].'</button>';
                }
                
            }

        break;
    }
}