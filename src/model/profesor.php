<?php

class profesor{
    private int $id_profesor;
    private String $nombre;
    private String $apellidos;
    private int $edad;

    public function __construct($nombre, $apellidos, $edad, $id_profesor=null){
        $this->nombre=$nombre;
        $this->apellidos=$apellidos;
        $this->edad=$edad;

        if(!is_null($id_profesor)){
            $this->id_profesor=$id_profesor;
        }
    }

    public function __get($name){
        if (property_exists($this, $name)) {
            return $this->$name;
        } else {
            return "Propiedad no definida";
        }
    }

    public static function selectAllProfesores(mysqli $connection){
        $result=$connection->query("SELECT * from profesores;");

        if($result!=false){
            $lista_profesores=[];

            $linea=$result->fetch_object();

            while($linea!=null){
                $profesor=new profesor($linea->nombre, $linea->apellidos, $linea->edad, $linea->id_profesor);
                array_push($lista_profesores, $profesor);
                $linea=$result->fetch_object();
            }
            return $lista_profesores;
        }else{
            return mysqli_error($connection);
        }
    }

}