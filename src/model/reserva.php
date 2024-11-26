<?php

class reserva{

    public static function insertReserva(mysqli $connection, $id_profesor, $id_cliente, $id_horario, $fecha){
        $result=$connection->query("INSERT INTO reservas (id_profesor, id_cliente, id_horario, fecha) VALUES ('".$id_profesor."', '".$id_cliente."', '".$id_horario."', '".$fecha."');");

        if($result!=false){
            return true;
        }else{
            return false;
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
                $reserva=["id_profesor"=>$linea->id_profesor, "id_cliente"=>$linea->id_cliente, "id_horario"=>$linea->id_horario, "fecha"=>$linea->fecha, "id_reserva"=>$linea->id_reserva];

                array_push($lista_reservas, $reserva);

                $linea=$result->fetch_object();
            }

            return $lista_reservas;
        }else{
            return false;
        }
    }

    public static function updateReserva(mysqli $connection, $id_reserva, $id_cliente=null, $id_horario=null, $id_profesor=null, $fecha=null){
        $result=$connection->query("UPDATE reservas SET id_horario=".$id_horario.", fecha='".$fecha."' WHERE id_reserva=".$id_reserva.";");

        if($result!=false){
            return true;
        }else{
            return false;
        }
    }

}