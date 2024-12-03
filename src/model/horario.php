<?php

// enum dia_semana:string{
//     case Lunes
// }
class horario{
    private int $id_horario;
    private int $id_profesor;
    private String $fecha;
    private String $hora_inicio;
    private String $hora_final;


    public function __construct($id_profesor, $fecha, $hora_inicio, $hora_final, $id_horario=null){
        $this->id_profesor=$id_profesor;
        $this->fecha=$fecha;
        $this->hora_inicio=$hora_inicio;
        $this->hora_final=$hora_final;

        if(!is_null($id_horario)){
            $this->id_horario=$id_horario;
        }

    }

    public function __get($name){
        if (property_exists($this, $name)) {
            return $this->$name;
        } else {
            return "Propiedad no definida";
        }
    }

    public static function compruebaDia(mysqli $connection, $fecha, $id_horario){
        $result=$connection->query("SELECT * from reservas where id_horario=".$id_horario." AND fecha='".$fecha."';");

        if($result!=false){
            $linea=$result->fetch_object();

            if($linea!=null){
                return false;
            }else{
                return true;
            }
        }
    }

    public static function selectHorarioProfesorFecha(mysqli $connection, $id_profesor, $fecha, $mes){
        $mes_escapado = $connection->real_escape_string($mes);
        $result = $connection->query("SELECT id_horario, hora_inicio, hora_final 
                                      FROM horarios 
                                      WHERE id_profesor='" . $id_profesor . "' 
                                      AND fecha='" . $fecha . "' 
                                      AND JSON_CONTAINS(mes, '\"$mes_escapado\"');");
        
        if($result!=false){
            $lista_horarios=[];
            $linea=$result->fetch_object();

            while($linea!=null){
                $horario=["hora_inicio"=>$linea->hora_inicio, "hora_final"=>$linea->hora_final, "id"=>$linea->id_horario];
                array_push($lista_horarios, $horario);

                $linea=$result->fetch_object();
            }

            return $lista_horarios;
        }else{
            return mysqli_error($connection);
        }
    }

    public static function selectHorarioProfesor(mysqli $connection, $id_profesor){
        $result=$connection->query("SELECT * from horarios where id_profesor='".$id_profesor."';");

        if($result!=false){
            $lista_horarios=[];
            $linea=$result->fetch_object();

            while($linea!=null){
                $horario=["hora_inicio"=>$linea->hora_inicio, "hora_final"=>$linea->hora_final, "id"=>$linea->id_horario, "dia"=>$linea->fecha, "mes"=>$linea->mes];
                array_push($lista_horarios, $horario);

                $linea=$result->fetch_object();
            }

            return $lista_horarios;
        }else{
            return mysqli_error($connection);
        }
    }

    public static function selectHorarioProfesorMes(mysqli $connection, $id_profesor, $mes){
        $result=$connection->query("SELECT * from horarios where id_profesor='".$id_profesor."' AND mes=".$mes.";");

        if($result!=false){
            $lista_horarios=[];
            $linea=$result->fetch_object();

            while($linea!=null){
                $horario=["hora_inicio"=>$linea->hora_inicio, "hora_final"=>$linea->hora_final, "id"=>$linea->id_horario, "dia"=>$linea->fecha, "mes"=>$linea->mes];
                array_push($lista_horarios, $horario);

                $linea=$result->fetch_object();
            }

            return $lista_horarios;
        }else{
            return mysqli_error($connection);
        }
    }

    public static function selectHorario(mysqli $connection, $id_horario){
        $result=$connection->query("SELECT * from horarios where id_horario=".$id_horario.";");

        if($result!=false){
            $linea=$result->fetch_object();
            $horario=["hora_inicio"=>$linea->hora_inicio, "hora_final"=>$linea->hora_final];

            return $horario;

        }else{
            return mysqli_error($connection);
        }
    }

    public static function updateHorario(mysqli $connection, $tipo_update, $id_horario, $id_profesor=null, $fecha=null, $hora_inicio=null, $hora_final=null){
        $query='';
        switch($tipo_update){
            case "historial":
                $query="UPDATE horarios SET fecha='".$fecha."', hora_inicio='".$hora_inicio."', hora_final='".$hora_final."' WHERE id_horario=".(int)$id_horario.";";
            break;
        }

        $result=$connection->query($query);

        if($result!=false){
            return $query;
        }else{
            return $query;
        }
    }

    public static function insertHorario(mysqli $connection, $id_profesor, $fecha, $hora_inicio, $hora_final, $meses){
        $result=$connection->query("INSERT INTO horarios (id_profesor, fecha, hora_inicio, hora_final, mes) VALUES ('".$id_profesor."', '".$fecha."', '".$hora_inicio."', '".$hora_final."', '".json_encode($meses)."');");

        if($result!=false){
            return true;
        }else{
            return mysqli_error($connection);
        }
    }

    public static function cuentaHorarioFecha(mysqli $connection, $fecha){
        $result=$connection->query("SELECT COUNT(*) as n_horario from horarios where fecha='".$fecha."'");

        if($result!=false){
            $linea=$result->fetch_object();
            
            return $linea->n_horario;
        }else{
            return mysqli_error($connection);
        }
    }
}