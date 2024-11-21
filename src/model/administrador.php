<?php

class administrador extends usuario{
    private String $id_administrador;
    private String $nombre;
    private String $apellidos;

    public function __construct($nombre, $apellidos, $correo, $pass, $id_administrador=null){
        parent::__construct($correo, $pass);
        $this->nombre=$nombre;
        $this->apellidos=$apellidos;

        if(!is_null($id_administrador)){
            $this->id_administrador=$id_administrador;
        }else{
            $this->id_administrador=$this->getIdUsuario();
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