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

    

}