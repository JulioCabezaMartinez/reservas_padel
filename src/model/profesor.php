<?php

class profesor extends usuario{
    private String $id_profesor;
    private String $nombre;
    private String $apellidos;

    public function __construct($nombre, $apellidos, $correo, $pass, $id_profesor=null){
        parent::__construct($correo, $pass);
        $this->nombre=$nombre;
        $this->apellidos=$apellidos;

        if(!is_null($id_profesor)){
            $this->id_profesor=$id_profesor;
        }else{
            $this->id_profesor=$this->getIdUsuario();
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
                $profesor=new profesor($linea->nombre, $linea->apellidos, $linea->correo, $linea->password, $linea->id_profesor);
                array_push($lista_profesores, $profesor);
                $linea=$result->fetch_object();
            }
            return $lista_profesores;
        }else{
            return mysqli_error($connection);
        }
    }

}