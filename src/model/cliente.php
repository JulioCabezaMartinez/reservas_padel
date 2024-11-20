<?php

class cliente extends usuario{
    private String $id_cliente;
    private String $nombre;
    private String $apellidos;
    private int $puntos;

    public function __construct($nombre, $apellidos, $puntos, $correo, $pass, $id_cliente=null){
        parent::__construct($correo, $pass);
        $this->nombre=$nombre;
        $this->apellidos=$apellidos;

        $this->puntos=$puntos;

        if(is_null($id_cliente)){
            $this->id_cliente=parent::$id_usuario;
        }else{
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

    public static function selectAllClientes(mysqli $connection){
        $result=$connection->query("SELECT * from clientes;");

        if($result!=false){
            $lista_clientes=[];

            $linea=$result->fetch_object();

            while($linea!=null){
                $cliente=new cliente($linea->nombre, $linea->apellidos, $linea->puntos, $linea->correo, $linea->password, $linea->id_cliente);
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

    public static function updateCliente(mysqli $connection, $tipo_update, $id_cliente, $nombre=null, $apellidos=null, $puntos=null, $correo=null, $password=null){
        $query='';
        switch($tipo_update){
            case "Puntos":
                $query="UPDATE clientes SET puntos=".$puntos." WHERE id_cliente='".$id_cliente."';";
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