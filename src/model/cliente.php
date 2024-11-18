<?php

class cliente{
    private int $id_cliente;
    private String $nombre;
    private String $apellidos;
    private int $edad;

    public function __construct($nombre, $apellidos, $edad, $id_cliente=null){
        $this->nombre=$nombre;
        $this->apellidos=$apellidos;
        $this->edad=$edad;

        if(!is_null($id_cliente)){
            $this->id_cliente=$id_cliente;
        }
    }

    public function __get($name){
        if (property_exists($this, $name)) {
            return $this->$name;
        } else {
            return "Propiedad no definida";
        }
    }

    /**
     * Método que permite la insercción en la tabla clientes de la base de datos. La variable adicional (tipo_insert) indica el tipo de insercción que se va a realizar.
     * 0. Insercción completa. 
     * @param mixed $nombre
     * @param mixed $apellidos
     * @param mixed $edad
     * @param mixed $puntos
     * @param mixed $tipo_insert
     * @return void
     */
    public static function insertCliente(mysqli $connection, $nombre, $apellidos, $edad, $puntos=0, $tipo_insert=0): bool|string{
        $query='';
        switch($tipo_insert){
            case 0: //0. Insercción completa.
                $query='INSERT into clientes (nombre, apellidos, edad, puntos) VALUES ("'.$nombre.'", "'.$apellidos.'", '.$edad.', '.$puntos.');';
            break;
        }
        $result=$connection->query($query);

        if($result!=false){
            return true;
        }else{
            return mysqli_error($connection);
        }
    }

    public static function selectAllClientes(mysqli $connection){
        $result=$connection->query("SELECT * from clientes;");

        if($result!=false){
            $lista_clientes=[];

            $linea=$result->fetch_object();

            while($linea!=null){
                $cliente=new cliente($linea->nombre, $linea->apellidos, $linea->edad, $linea->id_cliente);
                array_push($lista_clientes, $cliente);
                $linea=$result->fetch_object();
            }
            return $lista_clientes;
        }else{
            return mysqli_error($connection);
        }
    }

    public static function selectPuntosCliente(mysqli $connection, $id_cliente){
        $result=$connection->query("SELECT puntos from clientes where id_cliente=".$id_cliente.";");

        if($result!=false){
            $linea=$result->fetch_object();
            $puntos=$linea->puntos;

            return $puntos;
        }else{
            return mysqli_error($connection);
        }
    }
}