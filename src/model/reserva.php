<?php

class reserva{

    public static function insertReserva(mysqli $connection, $id_profesor, $id_cliente, $id_horario, $fecha){
        $result=$connection->query("INSERT INTO reservas (id_profesor, id_cliente, id_horario, fecha) VALUES ('".$id_profesor."', '".$id_cliente."', '".$id_horario."', '".$fecha."');");

        if($result!=false){
            return true;
        }else{
            return mysqli_error($connection);
        }
    }

    public static function selectReservasAll(mysqli $connection){
        $lista_reservas=[];

        $result=$connection->query("SELECT * from reservas;");

        if($result!=false){
            $linea=$result->fetch_object();

            while($linea!=null){
                $reserva=["id_profesor"=>$linea->id_profesor, "id_cliente"=>$linea->id_cliente, "id_horario"=>$linea->id_horario, "fecha"=>$linea->fecha, "id_reserva"=>$linea->id_reserva];

                array_push($lista_reservas, $reserva);

                $linea=$result->fetch_object();
            }

            return $lista_reservas;
        }else{
            return false;
        }
    }

    public static function selectReservasProfe(mysqli $connection, $id_profesor){
        $lista_reservas=[];

        $result=$connection->query("SELECT * from reservas where id_profesor='".$id_profesor."';");

        if($result!=false){
            $linea=$result->fetch_object();

            while($linea!=null){
                $reserva=["id_profesor"=>$linea->id_profesor, "id_cliente"=>$linea->id_cliente, "id_horario"=>$linea->id_horario, "fecha"=>$linea->fecha, "id_reserva"=>$linea->id_reserva];

                array_push($lista_reservas, $reserva);

                $linea=$result->fetch_object();
            }

            return $lista_reservas;
        }else{
            return false;
        }
    }

    public static function selectReservasAlumno(mysqli $connection, $id_alumno){
        $lista_reservas=[];

        $result=$connection->query("SELECT * from reservas where id_cliente='".$id_alumno."';");

        if($result!=false){
            $linea=$result->fetch_object();

            while($linea!=null){
                if($linea->cambio_profesor==1){
                    $reserva=["id_profesor"=>$linea->id_profesor, "id_cliente"=>$linea->id_cliente, "id_horario"=>$linea->id_horario, "fecha"=>$linea->fecha, "id_reserva"=>$linea->id_reserva, "cambio_profesor"=>1];
                }else{
                    $reserva=["id_profesor"=>$linea->id_profesor, "id_cliente"=>$linea->id_cliente, "id_horario"=>$linea->id_horario, "fecha"=>$linea->fecha, "id_reserva"=>$linea->id_reserva, "cambio_profesor"=>0];
                }

                array_push($lista_reservas, $reserva);

                $linea=$result->fetch_object();
            }

            return $lista_reservas;
        }else{
            return false;
        }
    }

    public static function detectaModificacion(mysqli $connection, $tipo_busqueda, $id_cliente=null, $id_profesor=null){
        $query="";

        switch($tipo_busqueda){
            case "profesor":
                $query="SELECT cliente_acepta from reservas where id_profesor='".$id_profesor."';";
            break;

            case "alumno":
                $query="SELECT cambio_profesor from reservas where id_cliente='".$id_cliente."';";
            break;
        }

        $result=$connection->query($query);

        if($result!=false){
            $linea=$result->fetch_object();
            while($linea!=null){
                switch($tipo_busqueda){
                    case "profesor":
                        if($linea->cliente_acepta==1){
                            return true;
                        }
                    break;
        
                    case "alumno":
                        if($linea->cambio_profesor==1){
                            return true;
                        }
                    break;
                }
                $linea=$result->fetch_object();
            }
            return false;
        }else{
            return "Error de SQL";
        }
    }

    public static function updateReserva(mysqli $connection, $tipo_update, $id_reserva, $id_cliente=null, $id_horario=null, $id_profesor=null, $fecha=null){
        $query="";

        switch($tipo_update){
            case "profesor_modifica":
                $query="UPDATE reservas SET id_horario=".$id_horario.", fecha='".$fecha."', cambio_profesor=1 WHERE id_reserva=".$id_reserva.";";
            break;

            case "alumno_modifica":
                $query= "UPDATE reservas SET id_horario=".$id_horario.", fecha='".$fecha."', acepta_alumno=1 WHERE id_reserva=".$id_reserva.";";
            break;
        }

        $result=$connection->query($query);

        if($result!=false){
            return true;
        }else{
            return false;
        }
    }

}