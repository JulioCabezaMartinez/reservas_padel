<div class="container-fluid">
    <div class="row flex-nowrap">
        <!-- style="background-color: #ff8000;" -->
        <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark barra_lateral">
            <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                <?php
                    if($_SESSION["tipo_usuario"]=="Alumno"){
                ?>
                    <a style="cursor: default;" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                        <span><img class="fs-5 d-none d-sm-inline" src="../../../assets/IMG/file.png" style="width: 10rem;" alt=""></span><span>Clases: <?php echo $puntos?><i class="fa-solid fa-table-tennis-paddle-ball mx-2"></i></span>
                    </a>
                <?php
                    }else{
                ?>
                    <a style="cursor: default;" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                        <span><img class="fs-5 d-none d-sm-inline" src="../../../assets/IMG/file.png" style="width: 10rem;" alt=""></span>
                    </a>
                <?php
                    }
                ?>
                <ul class="nav flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
                    <li class="nav-item">
                    <?php
                        if($_SESSION["tipo_usuario"]=="Administrador"){
                    ?>
                        <a href="./actions_administrador.php?action=botones" class="nav-link align-middle px-0">
                            <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline color_panel">Panel Administrador</span>
                        </a>
                    <?php
                        }elseif($_SESSION["tipo_usuario"]=="Alumno"){
                    ?>
                        <a href="./actions_alumno.php?action=botones" class="nav-link align-middle px-0">
                            <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline color_panel">Panel Alumno</span>
                        </a>
                    <?php
                        }elseif($_SESSION["tipo_usuario"]=="Profesor"){
                    ?>
                        <a href="./actions_profesor.php?action=botones" class="nav-link align-middle px-0">
                            <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline color_panel">Panel Profesor</span>
                        </a>
                    <?php
                        }
                    ?>
                        
                    </li>
                    <li>

                        <ul class="nav flex-column ms-1" id="submenu1" data-bs-parent="#menu">
                        <?php
                        if($_SESSION["tipo_usuario"]=="Administrador"){
                        ?>
                            <li>
                                <a href="./actions_administrador.php?action=recarga" class="nav-link px-0 color_panel"> <span class="d-none d-sm-inline"><i class="fa-solid fa-plus"></i><i class="fa-solid fa-table-tennis-paddle-ball mx-2"></i>Recargar Clases</span></a>
                            </li>
                            <li>
                                <a href="./actions_administrador.php?action=mod_horarios" class="nav-link px-0 color_panel"> <span class="d-none d-sm-inline"><i class="fa-solid fa-calendar-days"></i><i class="fa-solid fa-pen"></i> Modificar/Añadir Horarios</span></a>
                            </li>
                            <li>
                                <a href="./actions_administrador.php?action=reservas" class="nav-link px-0 color_panel"> <span class="d-none d-sm-inline"><i class="fa-solid fa-book-bookmark"></i> Gestionar Reservas</span></a>
                            </li>
                            <li>
                                <a href="./actions_administrador.php?action=dar_alta_alumno" class="nav-link px-0 color_panel"> <span class="d-none d-sm-inline"><i class="fa-solid fa-user-plus"></i> Dar de alta Alumno</span></a>
                            </li>
                            <li>
                                <a href="./actions_administrador.php?action=dar_alta_profesor" class="nav-link px-0 color_panel"> <span class="d-none d-sm-inline"><i class="fa-solid fa-user-plus"></i> Dar de alta Profesor</span></a>
                            </li>
                        <?php
                        }elseif($_SESSION["tipo_usuario"]=="Profesor"){
                            if(reserva::detectaModificacion($connection, "profesor", id_profesor:$_SESSION['id'])){
                        ?>
                            <li>
                                <a href="./actions_profesor.php?action=horarios" class="nav-link px-0 color_panel"><span class="d-none d-sm-inline">Mis Horarios</span><span style="border-radius: 50%; background-color: red;"><i class="fa-solid fa-exclamation" style="color: #ffffff;"></i></span></a>
                            </li>
                        <?php
                            }else{
                        ?>
                            <li>
                                <a href="./actions_profesor.php?action=horarios" class="nav-link px-0 color_panel"><span class="d-none d-sm-inline">Mis Horarios</span></a>
                            </li>
                        <?php
                            }
                        ?>
                            <li>
                                <a href="./actions_profesor.php?action=reservas" class="nav-link px-0 color_panel"> <span class="d-none d-sm-inline">Mis Clases</span></a>
                            </li>
                        <?php
                        }elseif($_SESSION["tipo_usuario"]=="Alumno"){
                        ?>
                            <li>
                            

                                <a href="./actions_alumno.php?action=reserva_clase" class="nav-link px-0 color_panel"> <span class="d-none d-sm-inline">Reservar Clase</span></a>
                            </li>
                        <?php
                            $busqueda=reserva::detectaModificacion($connection, "alumno", id_cliente:$_SESSION['id']);
                            if($busqueda){
                        ?>
                            <li>
                                <a href="./actions_alumno.php?action=reservas" class="nav-link px-0"><span class="ml-2" style="border-radius: 50%; background-color: red;"><i class="fa-solid fa-exclamation" style="color: #ffffff; width: 20px; text-align: center;"></i></span> <span class="d-none d-sm-inline">Mis Clases</span></a>
                            </li>
                        <?php
                            }else{
                        ?>
                            <li>
                            <a href="./actions_alumno.php?action=reservas" class="nav-link px-0 color_panel"> <span class="d-none d-sm-inline">Mis Clases</span></a>

                            </li>
                        <?php
                            }
                        ?>
                        <?php
                        }
                        ?>
                            

                        </ul>

                    <li>
                        <a href="" class="nav-link px-0"> <span class="d-none d-sm-inline"></span></a>
                    </li>
                    <li class="nav-item">

                        <a href="" class="nav-link align-middle px-0">
                            <span class="ms-1 d-none d-sm-inline">
                                <span class="circulo_barraLateral">

                                </span>
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="" class="nav-link align-middle px-0">
                            <span class="ms-1 d-none d-sm-inline"></span>
                        </a>
                    </li>

                    </li>
                </ul>
                <hr>
                <div class="dropdown pb-4">
                    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="../../assets/IMG/donDigital_default.png" alt="hugenerd" width="30" height="30" class="rounded-circle">
                        <span class="d-none d-sm-inline mx-1"><?php echo $_SESSION["nombre"]." ".$_SESSION["apellidos"]?></span> <!-- Aqui tendría que coger la info de la sesion iniciada = -->
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                        <!-- <li><a class="dropdown-item" href="../../../src/view/cambiar_pass.php">Cambiar Contraseña</a></li> -->
                        <li><a class="dropdown-item" href="../../../src/controller/actions_usuario.php?action=cerrar">Cerrar Sesion</a></li>
                    </ul>
                </div>
            </div>
        </div>