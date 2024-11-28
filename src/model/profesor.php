<?php

class profesor extends usuario{
    private String $id_profesor;
    private String $nombre;
    private String $apellidos;
    private String $DNI;

    public function __construct($nombre, $apellidos, $correo, $pass, $DNI, $id_profesor=null){
        parent::__construct($correo, $pass);
        $this->nombre=$nombre;
        $this->apellidos=$apellidos;
        $this->DNI=$DNI;

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
                $profesor=new profesor($linea->nombre, $linea->apellidos, $linea->correo, $linea->password,$linea->DNI, $linea->id_profesor);
                array_push($lista_profesores, $profesor);
                $linea=$result->fetch_object();
            }
            return $lista_profesores;
        }else{
            return mysqli_error($connection);
        }
    }

    public static function selectProfesor(mysqli $connection, $id_profesor){
        $result=$connection->query("SELECT * from profesores where id_profesor='".$id_profesor."';");

        if($result!=false){
            $linea=$result->fetch_object();
            $profesor=new profesor($linea->nombre, $linea->apellidos, $linea->correo, $linea->password, $linea->id_profesor);

            return $profesor;
        
        }else{
            return mysqli_error($connection);
        }
    }

    public static function updateProfesor(mysqli $connection, $tipo_update, $id_profesor, $nombre_profesor=null, $apellidos_profesor=null, $DNI_profesor=null, $correo_profesor=null){
        $query='';

        switch($tipo_update){
            case "todo-pass":
                $query="UPDATE profesores set nombre='".$nombre_profesor."', apellidos='".$apellidos_profesor."', DNI='".$DNI_profesor."', correo='".$correo_profesor."' WHERE id_profesor='".$id_profesor."';";
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