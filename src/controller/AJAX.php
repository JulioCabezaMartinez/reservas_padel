<?php

session_start();

require "../model/usuario.php";
require "../model/BuscadorDB.php";
require "../model/profesor.php";
require "../model/cliente.php";
require "../model/horario.php";
require "../model/reserva.php";

if(isset($_POST["mode"])){
    switch($_POST["mode"]){
        case "muestra_horas":

            $lista_horarios=horario::selectHorarioProfesorFecha($connection, $_POST["id_profesor"], $_POST["dia"]);

            foreach($lista_horarios as $horario){
                if(horario::compruebaDia($connection, $_POST["fecha"], $horario["id"])){
                    echo '<button id="btn_horario_'.$horario["id"].'" class="btn btn-outline-primary btn_hora">'.$horario["hora_inicio"].'/'.$horario["hora_final"].'</button>';
                }else{
                    echo '<button class="btn btn-secondary btn_hora" disabled>'.$horario["hora_inicio"].'/'.$horario["hora_final"].'</button>';
                }
            }
        break;

        case "recarga_bonos":
            $recarga=cliente::updateCliente($connection, "Puntos", DNI:$_POST['alumno'], puntos:$_POST['bonos']);

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
            
        case "creacion_horario":
            $inserccion=horario::insertHorario($connection, $_POST['profesor'], $_POST['dia'], $_POST['hora_inicio'], $_POST['hora_final']);
            
            if($inserccion){
                echo "Insercción Correcta";
            }else{
                echo "Fallo en la insercción";
            }
        break;

        case "pagar_reserva":
            $pago=cliente::updateCliente($connection, "Puntos_reserva", $_SESSION['id'], puntos:$_POST['puntos']);

            if($pago){
                $reserva=reserva::insertReserva($connection, $_POST["id_profesor"], $_SESSION["id"], $_POST["id_horario"], $_POST['fecha']);
                
                if($reserva){
                    echo "Update Correcto";
                }else{
                    echo "Fallo al hacer reserva";
                }
                    
            }else{
                echo "Fallo update";    
            }
        break;
        
        case "alta":
            $pago;
            if($_POST["tipo"]=="Profesor"){
                $pago=usuario::registrarUsuario($connection, $_POST['correo'], $_POST['pass'], $_POST['confirm'], $_POST['nombre'], $_POST['apellidos'], $_POST['tipo'], image:$_FILES['imagen']);
            }elseif($_POST["tipo"]=="Alumno"){
                $pago=usuario::registrarUsuario(connection: $connection, correo: $_POST['correo'], pass: $_POST['pass'], confirmPass: $_POST['confirm'], nombre: $_POST['nombre'], apellidos: $_POST['apellidos'], tipo: $_POST['tipo'], DNI: $_POST['DNI']);
            }else{
                echo "Error de tipo";
            }

            if($pago){
                echo "Registro ok";
            }else{
                echo "Fallo de Registro";
            }

        break;
    }
}

