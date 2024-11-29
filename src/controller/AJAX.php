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
                    echo '<span id="btn_horario_'.$horario["id"].'" style="height: fit-content;" class="btn btn-outline-primary btn_hora w-100">'.$horario["hora_inicio"].'/'.$horario["hora_final"].'</span>';
                }else{
                    echo '<span class="btn btn-secondary btn_hora w-100" style="height: fit-content;" disabled>'.$horario["hora_inicio"].'/'.$horario["hora_final"].'</span>';
                }
            }
        break;

        case "muestra_horas_profesor":

            $lista_horarios=horario::selectHorarioProfesorFecha($connection, $_SESSION["id"], $_POST["dia"]);

            foreach($lista_horarios as $horario){
                if(horario::compruebaDia($connection, $_POST["fecha"], $horario["id"])){
                    echo '<span id="btn_horario_'.$horario["id"].'" style="height: fit-content;" class="btn btn-outline-primary btn_hora w-100">'.$horario["hora_inicio"].'/'.$horario["hora_final"].'</span>';
                }else{
                    echo '<span class="btn btn-secondary btn_hora w-100" style="height: fit-content;" disabled>'.$horario["hora_inicio"].'/'.$horario["hora_final"].'</span>';
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

        case "creacion_horario_profe":

            $inserccion=horario::insertHorario($connection, $_SESSION['id'], $_POST['dia'], $_POST['hora_inicio'], $_POST['hora_final']);
            
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

        case "pagar_reserva_admin":

            $pago=cliente::updateCliente($connection, "Puntos_reserva", $_POST['id_alumno'], puntos:$_POST['puntos']);

            if($pago){
                $reserva=reserva::insertReserva($connection, $_POST["id_profesor"], $_POST['id_alumno'], $_POST["id_horario"], $_POST['fecha']);

                if($reserva){
                    echo "Update Correcto";
                }else{
                    echo "Fallo al hacer reserva";
                }
                    
            }else{
                echo "Fallo update";    
            }

        break;

        case "modificacion_reserva":
            $reserva=reserva::updateReserva($connection, $_POST["tipo_update"], $_POST['id_reserva'], id_horario:$_POST['id_horario'], fecha:$_POST['fecha']);

            if($reserva){
                echo "Modificación Correcta";
            }else{
                echo "Fallo de Modificación";
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

        case "update_profesor":
            $update=profesor::updateProfesor($connection, "todo-pass", $_POST['id_profesor'], $_POST['nombre_profesor'], $_POST['apellidos_profesor'], $_POST['DNI_profesor'], $_POST["correo_profesor"]);

            if($update){
                echo "Update Correcto";
            }else{
                echo "Fallo en Update";
            }
        break;

        case "update_alumno":
            $update=cliente::updateCliente($connection, 'todo-pass', $_POST['id_alumno'], $_POST['nombre_alumno'], $_POST["apellidos_alumno"], $_POST["puntos_alumno"], $_POST["correo_alumno"], DNI:$_POST["DNI_alumno"]);
            
            if($update){
                echo "Update Correcto";
            }else{
                echo "Fallo en Update";
            }
        break;

        case "buscador_alumnos":
            $lista_alumnos=cliente::selectClientesBuscador($connection, $_POST["buscador"]);

            if($lista_alumnos!=false){

                foreach($lista_alumnos as $alumno){
                    echo '<tr>
                    <td>'.$alumno->nombre.'</td>
                    <td>'.$alumno->apellidos.'</td>
                    <td>'.$alumno->DNI.'</td>
                    <td>'.$alumno->puntos.'</td>
                    <td>'.$alumno->getCorreo().'</td>
                    <td><button data-datos="'.$alumno->nombre.'_'.$alumno->apellidos.'_'.$alumno->DNI.'" class="btn btn-outline-primary btn-seleccionar">Seleccionar</button></td>

                </tr>';
                }
            }else{
                echo "<tr></tr>";
            }
        break;

        case "puntos_alumno_reserva_admin":

            echo $puntos=cliente::selectCliente($connection, "Puntos_DNI", DNI:$_POST['DNI_alumno']);

        break;

        case "recoger_id_alumno_admin":

            echo $id=cliente::selectCliente($connection, "id_DNI", DNI:$_POST['DNI_alumno']);


        break;

        case "cambiar_pass_alumno":

            if($_POST["nueva_pass"]==$_POST["nueva_confirm"]){
                $cambiar_pass=cliente::updateCliente($connection, "cambiar_pass", id_cliente:$_POST["id_alumno"], password:password_hash($_POST["nueva_pass"], PASSWORD_DEFAULT));

                if($cambiar_pass){
                    echo "Update Correcto";
                }else{
                    echo "Fallo en Update";
                }
            }else{
                echo "No coinciden";
            }
            
        break;

        case "cambiar_pass_profesor":

            if($_POST["nueva_pass"]==$_POST["nueva_confirm"]){
                $cambiar_pass=profesor::updateProfesor($connection, "cambiar_pass", id_profesor:$_POST["id_profesor"], password:password_hash($_POST["nueva_pass"], PASSWORD_DEFAULT));

                if($cambiar_pass){
                    echo "Update Correcto";
                }else{
                    echo "Fallo en Update";
                }
            }else{
                echo "No coinciden";
            }
            
        break;
    }
}

