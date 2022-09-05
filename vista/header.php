<?php

  session_start();
  $id =0;
  $rol='';
  $id_rol ='';
  $nombre = '';
  $ad_user_id = '';

  //var_dump($_SESSION['usuario']);
  foreach ($_SESSION['usuario'] as $datos ) {
    $id = $datos['id_s_usuario'];
    $rol = $datos['nombrerol'];
    $nombre = $datos['nombre'] .' '. $datos['paterno'];
    $ad_user_id = $datos['ad_user_id'];

  }

  if ($id == 0 && $rol == '') {
    
    session_destroy();
    header('Location: ../index.php');
    exit();

  }else{
    //header('Location: ../index.php');
  }

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Digital-Quality</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>

        <link href="../bootstrap/styles.css" rel="stylesheet" />
        <link href="../bootstrap/modal.css" rel="stylesheet">


        <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
        <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
        <link type="text/css" rel="stylesheet" href="https://unpkg.com/bootstrap@4.5.0/dist/css/bootstrap.min.css" />
        <link type="text/css" rel="stylesheet" href="//unpkg.com/bootstrap-vue@latest/dist/bootstrap-vue.min.css" />
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
        <script src="//unpkg.com/bootstrap-vue@latest/dist/bootstrap-vue.min.js"></script> 

        <script src="https://unpkg.com/vue-select@3.0.0"></script>
        <link rel="stylesheet" href="https://unpkg.com/vue-select@3.0.0/dist/vue-select.css">
        <!-- <script>
        document.domain = 'refividrio.com.mx';
        </script> -->
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.html">Digital-Quality</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">

            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <!-- <li><a class="dropdown-item" href="#!">Settings</a></li> -->
                        <!-- <li><hr class="dropdown-divider" /></li> -->
                        <li><a class="dropdown-item" href="../logout.php">Cerrar Sesion</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Men&uacute;</div>
                            <!-- <a class="nav-link" href="index.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                             -->
                            <?php

                            //var_dump ($_SESSION['menu']);

                            foreach ($_SESSION['menu'] as $menu ) {
                            //$menu =>'nombreurl';
                            //echo( $menu['nombreurl']);
                            echo '
                                <li class="nav-item">
                                  <a class="nav-link text-white" href='.$menu['url'].'>
                                    '.$menu['svg'].'
                                    '.$menu['nombreurl'].'
                                  </a>
                              </li>       
                            ';  
                            }
                            ?>


                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Iniciado como:</div>
                          <?php echo $nombre;?> 
                          <div class="small">ID ADempiere:</div>
                          <?php echo $ad_user_id;?> 

                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>


