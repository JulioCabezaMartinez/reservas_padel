<?php

abstract class usuario{
    protected String $id_usuario;
    private String $correo;
    private String $pass;

    public function __construct($correo, $pass) {
        $this->id_usuario = uniqid();
        $this->correo = $correo;
        $this->pass = $pass;
    }

    public function __get($name){
        if (property_exists($this, $name)) {
            return $this->$name;
        } else {
            return "Propiedad no definida";
        }
    }

    public function getIdUsuario(): string{
        return $this->id_usuario;
    }

    public function getCorreo(){
        return $this->correo;
    }

    public function getPass(){
        return $this->pass;
    }

    /**
     * Método que le permite a los clientes y profesores acceder a la aplicación.
     * @param mixed $correo Correo del usuario.
     * @param mixed $pass Contraseña del usuario.
     * @param mysqli $connection Conexión a la base de datos generada con anterioridad.
     * @return bool Devuelve true en caso de que el usuario se encuentre en la base de datos, false en caso contrario.
     */
    public static function LogIn($correo, $pass, mysqli $connection): bool|string{
        $query="SELECT id_cliente AS id, nombre, apellidos, password, 'clientes' AS tabla_origen
                FROM clientes
                WHERE correo = '".$correo."'
                UNION
                SELECT id_profesor AS id, nombre, apellidos, password, 'profesores' AS tabla_origen
                FROM profesores
                WHERE correo = '".$correo."'
                UNION
                SELECT id_administrador AS id, nombre, apellidos, password, 'administradores' AS tabla_origen
                FROM administradores
                WHERE correo = '".$correo."';";
                
        $tipo='';

        $result=$connection->query($query);

        if($result!=false){
            $linea=$result->fetch_object();

            if($linea->tabla_origen=="clientes"){
                $tipo="Alumno";
            }elseif($linea->tabla_origen=="profesores"){
                $tipo="Profesor";
            }elseif($linea->tabla_origen=="administradores"){
                $tipo="Administrador";
            }

            if($linea!=null){
                if(password_verify($pass, $linea->password)){
                    $_SESSION['id']=$linea->id;
                    $_SESSION["nombre"]=$linea->nombre;
                    $_SESSION["apellidos"]=$linea->apellidos;
                    $_SESSION["tipo_usuario"]=$tipo;
                    return true;
                }else return false;
            }return false;
        }return mysqli_error($connection);
        
    }

    public static function logOut(){

        session_unset();
        unset($_SESSION);
        session_destroy();

        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time()-42000, '/');
        }
    }

    private static function compruebaCorreo(mysqli $connection, $correo){
        $result=$connection->query('Select nombre from clientes where correo="'. $correo .'";');

        if($result!=false){
            $linea=$result->fetch_object();

            if(is_null($linea)){
                return true;
            }else return false;
        }
    }

    public static function registrarUsuario(mysqli $connection, $correo, $pass, $confirmPass, $nombre, $apellidos, $tipo, $DNI=null, $image=null){

        if(!is_null($correo) && !is_null($tipo) && !is_null($pass) && !is_null($confirmPass) && !is_null($nombre) && !is_null($apellidos)){ //Doble comprobación para evitar que inyecciones de datos erroneas en la BD
            if($pass===$confirmPass){
                if(usuario::compruebaCorreo($connection, $correo)){

                    //En caso de que se quiera usar imagenes descomentar las siguientes lineas.
                    
                    if(!empty($image["name"])){
                        $extension=strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
                        $extensionesPermitidas = ['jpg', 'jpeg', 'png'];

                        if($_FILES['imagen']['size']>(12*1024*1204)){ //Que el tamaño no sea mayor de 12 mb

                            return "Imagen demasiado pesada";

                        }elseif(!in_array($extension, $extensionesPermitidas)){

                            return "El archivo tiene un tipo no permitido";

                        }else{

                            $filename=$nombre."_".$apellidos.".jpg";
                            $tempName=$image['tmp_name'];
                            if(isset($filename)){
                                if(!empty('$filename')){
                                    $location="../../assets/IMG/". $filename;
                                    move_uploaded_file($tempName, $location);
                                }
                            }
                        }
                    }

                    $query="";
                    if($tipo=="Alumno"){
                        $alumno=new cliente($nombre, $apellidos, 0, $correo, $pass, $DNI);
                        $query='INSERT into clientes VALUES ("'.$alumno->id_cliente.'" ,"'.$alumno->nombre.'", "'.$alumno->apellidos.'", "'.$alumno->DNI.'", 0, "'.$alumno->getCorreo().'", "'.password_hash($alumno->getPass(), PASSWORD_DEFAULT).'");';
                    }elseif($tipo=="Profesor"){
                        $profesor=new profesor($nombre, $apellidos, $correo, $pass, $DNI);
                        $query='INSERT into profesores VALUES ("'.$profesor->id_profesor.'" ,"'.$profesor->nombre.'", "'.$profesor->apellidos.'", "'.$profesor->getCorreo().'", "'.password_hash($profesor->getPass(), PASSWORD_DEFAULT).'");';
                    }else{
                        return "Error de Servidor";
                    }
                    $result=$connection->query($query);

                    if($result!=false){
                        return true;
                    }else{
                        return mysqli_error($connection);
                    }
                }else{
                    return "Su correo ya se encuntra registrado";
                }
            }else{
                return "Contraseñas no coinciden";
            }
        }else{
            return "Faltan datos por rellenar";
        }
    }
}