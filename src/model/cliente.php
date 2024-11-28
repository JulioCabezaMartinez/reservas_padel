<?php

class cliente extends usuario{
    private String $id_cliente;
    private String $nombre;
    private String $apellidos;
    private String $DNI;
    private int $puntos;

    public function __construct($nombre, $apellidos, $puntos, $correo, $pass, $DNI, $id_cliente=null){
        parent::__construct($correo, $pass);
        $this->nombre=$nombre;
        $this->apellidos=$apellidos;
        $this->puntos=$puntos;
        $this->DNI=$DNI;

        if(is_null($id_cliente)){
            $this->id_cliente=$this->getIdUsuario();
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
                $cliente=new cliente($linea->nombre, $linea->apellidos, $linea->puntos, $linea->correo, $linea->password, $linea->DNI, $linea->id_cliente);
                array_push($lista_clientes, $cliente);
                $linea=$result->fetch_object();
            }
            return $lista_clientes;
        }else{
            return mysqli_error($connection);
        }
    }

    public static function selectCliente(mysqli $connection, $tipo, $id_cliente=null, $DNI=null){
        $query="";
        switch($tipo){
            case "Puntos":
                $query="SELECT puntos from clientes where id_cliente='".$id_cliente."';";
            break;

            case "Todo":
                $query="SELECT * from clientes where id_cliente='".$id_cliente."';";
            break;

            case "Puntos_DNI":
                $query="SELECT puntos from clientes where DNI='".$DNI."';";
            break;

            case "id_DNI":
                $query="SELECT id_cliente from clientes where DNI='".$DNI."';";
            break;
        }
        $result=$connection->query($query);

        if($result!=false){
            $linea=$result->fetch_object();

            $return='';

            switch($tipo){
                case "Puntos":
                    $return=$linea->puntos;
                break;

                case "Todo":
                    $return=new cliente($linea->nombre, $linea->apellidos, $linea->puntos, $linea->correo, $linea->password, $linea->DNI, $linea->id_cliente);
                break;

                case "Puntos_DNI":
                    $return=$linea->puntos;
                break;

                case "id_DNI":
                    $return=$linea->id_cliente;
                break;
            }

            return $return;
        }else{
            return mysqli_error($connection);
        }
    }

    public static function selectClientesBuscador(mysqli $connection, $buscador){
        $lista_clientes=[];

        $result=$connection->query("SELECT * FROM clientes where nombre LIKE '$buscador%' OR DNI LIKE '$buscador%';");

        if($result!=false){
            $linea=$result->fetch_object();

            while($linea!=null){
                $cliente=new cliente($linea->nombre, $linea->apellidos, $linea->puntos, $linea->correo, $linea->password, $linea->DNI, $linea->id_cliente); 
            
                array_push($lista_clientes, $cliente);
                $linea=$result->fetch_object();
            }
            return $lista_clientes;
        }else{
            return mysqli_error($connection);
        }
    }

    public static function updateCliente(mysqli $connection, $tipo_update, $id_cliente=null, $nombre=null, $apellidos=null, $puntos=null, $correo=null, $password=null, $DNI=null){
        $query='';
        switch($tipo_update){
            case "Puntos":
                $query="UPDATE clientes SET puntos=puntos+".((int)$puntos*5)." WHERE DNI='".$DNI."';";
            break;

            case 'Puntos_reserva':
                $query="UPDATE clientes SET puntos=".$puntos." WHERE id_cliente='".$id_cliente."';";
            break;

            case 'todo-pass':
                $query= "UPDATE clientes SET nombre='".$nombre."', apellidos='".$apellidos."', correo='".$correo."', puntos=".$puntos.", DNI='".$DNI."' WHERE id_cliente='".$id_cliente."';";
        }

        $result=$connection->query($query);

        if($result!=false){
            return true;
        }else{
            return mysqli_error($connection);
        }
    }
}