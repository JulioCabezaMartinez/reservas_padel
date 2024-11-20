<?php

require "../model/usuario.php";
require "../model/BuscadorDB.php";
require "../model/profesor.php";
require "../model/cliente.php";
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

        case "recarga_bonos":
            $recarga=cliente::updateCliente($connection, "Puntos", id_cliente:$_POST['alumno'], puntos:$_POST['bonos']);

            if($recarga){
                echo "Recarga realizada con exito";
            }else{
                echo "Fallo en la recarga";
            }
        break;

        case "tabla_profesor":
            if(!$_POST["id_profesor"]==""){
                $lista_horarios=horario::selectHorarioProfesor($connection, $_POST["id_profesor"]);

                foreach($lista_horarios as $horario){
                    echo '<tr>
                            <td>'.$horario["dia"].'</td>
                            <td>'.$horario["hora_inicio"].'</td>
                            <td>'.$horario["hora_final"].'</td>
                            <td><button id="btn_'.$horario["id"].'" class="btn_modificar_horario btn btn-primary"><i class="fa-solid fa-pen me-2"></i>Modificar horario</button></td>
                        </tr>';
                }
            }else{
                echo '<tr>
                            
                        </tr>';
            }
        break;

        case "modificar_horario":

            $modificacion=horario::updateHorario(connection: $connection, tipo_update: "historial", id_horario: $_POST['id_horario'], fecha:$_POST['dia'], hora_inicio:$_POST['hora_inicio'], hora_final:$_POST['hora_final']);
            if($modificacion){
                echo "Modificación Correcta";
            }else{
                echo "Fallo en la modificación";
            }

        break;
            
    }
}

