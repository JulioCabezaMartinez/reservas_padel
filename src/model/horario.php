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

    public static function selectHorarioProfesorFecha(mysqli $connection, $id_profesor, $fecha){
        $result=$connection->query("SELECT hora_inicio, hora_final from horarios where id_profesor=".$id_profesor." AND fecha='".$fecha."';");

        if($result!=false){
            $lista_horarios=[];
            $linea=$result->fetch_object();

            while($linea!=null){
                $horario=["hora_inicio"=>$linea->hora_inicio, "hora_final"=>$linea->hora_final];
                array_push($lista_horarios, $horario);

                $linea=$result->fetch_object();
            }

            return $lista_horarios;
        }else{
            return mysqli_error($connection);
        }
    }
}