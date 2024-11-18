<?php

require "../model/BuscadorDB.php";
require "../model/profesor.php";
require "../model/horario.php";

if(isset($_POST["mode"])){
    switch($_POST["mode"]){
        case "muestra_horas":

            $lista_horarios=horario::selectHorarioProfesorFecha($connection, $_POST["id_profesor"], $_POST["fecha"]);

            foreach($lista_horarios as $horario){
                //Falta enviar los botones con las horas
            }

        break;
    }
}