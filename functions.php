<?php

header('Content-Type: text/html; charset=ISO-8859-1');

function boolThereLogin() {
    $boolReturn = false;

    if( isset($_SESSION['login']) )
        $boolReturn = true;

     return $boolReturn;
}

function base_dbInsert($strTabla, $arrDatos){
    $strQuery = "";
    $strCampos =  "";
    $strValores = "";
    
    while( $arrD = each($arrDatos) ) {
        $strCampos .= empty($strCampos) ? "" : ",";
        $strCampos .= $arrD["key"];
        $strValores .= empty($strValores) ? "" : ",";
        $strValores .= "'".$arrD["value"]."'";
    }
    
    $strQuery = "INSERT INTO {$strTabla} ({$strCampos}) VALUES ({$strValores})";
    db_consulta($strQuery);
    //print $strQuery;
    return db_insert_id();
}

function base_dbUpdate($strTabla, $arrLlaves, $arrDatos){
    $strWhere =  "";
    $strCampos = "";
    
    while( $arrL = each($arrLlaves) ) {
        $strWhere .= empty($strWhere) ? "" : " AND ";
        $strWhere .= $arrL["key"]." = ".$arrL["value"];
    }
    
    while( $arrD = each($arrDatos) ) {
        $strCampos .= empty($strCampos) ? "" : ",";
        $strCampos .= $arrD["key"]." = '".$arrD["value"]."'";
    }
    
    $strQuery = "UPDATE {$strTabla} SET {$strCampos} WHERE {$strWhere}";
    //print $strQuery;
    db_consulta($strQuery);
    return db_affected_rows();
}

function base_dbDelete($strTabla, $arrLlaves){
    $strWhere = "";
    
    while( $arrL = each($arrLlaves) ) {
        $strWhere .= empty($strWhere) ? "" : " AND ";
        $strWhere .= $arrL["key"]." = ".$arrL["value"];
    }

    $strQuery = "DELETE FROM {$strTabla} WHERE ({$strWhere})";
    db_consulta($strQuery);
    return db_affected_rows();
}

function drawHeader($strTitle, $boolDrawSidebar = true) {
    global $objConexion;

    $strTitle = !empty($strTitle) ? $strTitle : "Página principal";
    $arrUsuario = array();
    $strQuery ="SELECT  usuario.usuario, 
                        usuario.nombre, 
                        usuario.apellido, 
                        usuario.usser, 
                        usuario.pass, 
                        usuario.tipo_usuario,
                        usuario.email, 
                        usuario.foto
                FROM    usuario
                WHERE   usuario.usuario = {$_SESSION['usuario']}";
    $qTMP = db_consulta($strQuery);
    while( $rTMP = db_fetch_assoc($qTMP) ) {
        $arrUsuario["usuario"] = $rTMP["usuario"];
        $arrUsuario["nombre"] = $rTMP["nombre"];
        $arrUsuario["apellido"] = $rTMP["apellido"];
        $arrUsuario["usser"] = $rTMP["usser"];
        $arrUsuario["tipo_usuario"] = $rTMP["tipo_usuario"];
        $arrUsuario["email"] = $rTMP["email"];
        $arrUsuario["foto"] = $rTMP["foto"];
    }
    db_free_result($qTMP);

    ?>
    <!DOCTYPE html>
    <html lang="es">
        <head>
            <meta http-equiv="Content-Type" content="text/html" charset=ISO-8859-1">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no" name="viewport">
            <title><?php echo "R&T - ".$strTitle; ?></title>
            <link rel="shortcut icon" href="imagenes/logor&t.png">
            <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
            <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
            <link rel="stylesheet" href="dist/css/skins/skin-blue.min.css">
            <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
            <link rel="stylesheet" href="plugins/iCheck/flat/blue.css">
            <link rel="stylesheet" href="plugins/morris/morris.css">
            <link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css">
            <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
            <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
            <!--link rel="stylesheet" href="plugins/datetimepicker/bootstrap-datetimepicker.min.css"-->
            <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
            <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
            <link rel="stylesheet" href="plugins/datatables/jquery.dataTables.css">
            <script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
            <script src="bootstrap/js/bootstrap.min.js"></script>
            <script src="dist/js/app.min.js"></script>
            <script src="plugins/morris/morris.min.js"></script>
            <script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
            <script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
            <script src="plugins/knob/jquery.knob.js"></script>
            <!--script src="plugins/daterangepicker/daterangepicker.js"></script-->
            <script src="plugins/datepicker/bootstrap-datepicker.js"></script>
            <!--script src="plugins/datetimepicker/bootstrap-datetimepicker.min.js"></script-->
            <script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
            <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
            <script src="plugins/fastclick/fastclick.js"></script>
            <script src="plugins/datatables/jquery.dataTables.js"></script>
        </head>
        <body class="hold-transition skin-blue sidebar-mini">
            <div id="wrapper" class="wrapper">
                <header class="main-header">
                    <a href="index.php" class="logo">
                        <span class="logo-mini"><b>R&T</b></span>
                        <span class="logo-lg"><b>Grupo </b>R&T</span>
                    </a>
                    <nav class="navbar navbar-static-top" role="navigation">
                        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                            <span class="sr-only">Toggle navigation</span>
                        </a>
                        <div class="navbar-custom-menu">
                            <ul class="nav navbar-nav">
                                <!--li class="dropdown messages-menu">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <i class="fa fa-envelope-o"></i>
                                        <span class="label label-success">4</span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li class="header">You have 4 messages</li>
                                        <li>
                                            <ul class="menu">
                                                <a href="#">
                                                    <div class="pull-left">
                                                        <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                                                    </div>
                                                    <h4>
                                                        Support Team
                                                        <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                                    </h4>
                                                    <p>Why not buy a new awesome theme?</p>
                                                </a>
                                              </li>
                                            </ul>
                                        </li>
                                        <li class="footer"><a href="#">See All Messages</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown notifications-menu">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <i class="fa fa-bell-o"></i>
                                        <span class="label label-warning">10</span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li class="header">You have 10 notifications</li>
                                        <li>
                                            <ul class="menu">
                                                <a href="#">
                                                <i class="fa fa-users text-aqua"></i> 5 new members joined today
                                                </a>
                                            </ul>
                                        </li>
                                        <li class="footer"><a href="#">View all</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown tasks-menu">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <i class="fa fa-flag-o"></i>
                                        <span class="label label-danger">9</span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li class="header">You have 9 tasks</li>
                                        <li>
                                            <ul class="menu">
                                                <li>
                                                    <a href="#">
                                                    <h3>
                                                        Design some buttons
                                                        <small class="pull-right">20%</small>
                                                    </h3>
                                                    <div class="progress xs">
                                                        <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                            <span class="sr-only">20% Complete</span>
                                                        </div>
                                                    </div>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="footer">
                                            <a href="#">View all tasks</a>
                                        </li>
                                    </ul>
                                </li-->
                                <li class="dropdown user user-menu">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <?php $strFoto = isset($arrUsuario["foto"]) && $arrUsuario["foto"] ? $arrUsuario["foto"] : "imagenes/usuario.png" ?>
                                        <img src="<?php echo $strFoto; ?>" class="user-image" alt="User Image">
                                        <span class="hidden-xs">
                                            <?php
                                            echo $arrUsuario["nombre"]." ".$arrUsuario["apellido"];
                                            ?>
                                        </span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li class="user-header">
                                            <img src="<?php echo $strFoto; ?>" class="img-circle" alt="User Image">
                                            <p>
                                                <?php
                                                echo $arrUsuario["nombre"]." ".$arrUsuario["apellido"];
                                                ?>
                                                <small>
                                                    <?php
                                                    echo $arrUsuario["email"];
                                                    ?>
                                                </small>
                                            </p>
                                        </li>
                                        <!--li class="user-body">
                                            <div class="row">
                                                <div class="col-xs-4 text-center">
                                                    <a href="#">Followers</a>
                                                </div>
                                                <div class="col-xs-4 text-center">
                                                    <a href="#">Sales</a>
                                                </div>
                                                <div class="col-xs-4 text-center">
                                                    <a href="#">Friends</a>
                                                </div>
                                            </div>
                                        </li-->
                                        <li class="user-footer">
                                            <div class="pull-left">
                                                <a href="#" class="btn btn-default btn-flat">Mi cuenta</a>
                                            </div>
                                            <div class="pull-right">
                                                <a href="login.php?logout=4236a440a662cc8253d7536e5aa17942" class="btn btn-default btn-flat">Salir</a>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                                <!--li>
                                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                                </li-->
                            </ul>
                        </div>
                    </nav>
                </header>?
                    <aside class="main-sidebar">
                        <section class="sidebar">
                            <div class="user-panel">
                                <div class="pull-left image">
                                    <img src="<?php echo $strFoto; ?>" class="img-circle" alt="User Image">
                                </div>
                                <div class="pull-left info">
                                    <p>
                                        <?php
                                        echo $arrUsuario["nombre"];
                                        ?>
                                    </p>
                                    <a href="#"><i class="fa fa-circle text-success"></i> En línea</a>
                                </div>
                            </div>
                            <!--form action="#" method="get" class="sidebar-form">
                                <div class="input-group">
                                    <input type="text" name="q" class="form-control" placeholder="Search...">
                                    <span class="input-group-btn">
                                        <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                                        </button>
                                    </span>
                                </div>
                            </form-->
                            <ul class="sidebar-menu">
                                <li class="header">Menú</li>
                                <li>
                                    <a href="index.php"><i class="fa fa-dashboard fa-fw"></i><span> Inicio</span></a>
                                </li>
                                <?php
                                $arrMenu = array();

                                if( $_SESSION['tipo_usuario'] == "administrador" ) {
                                    $strQuery ="SELECT  modulo.modulo, modulo.nombre nombreModulo, pantalla.pantalla, pantalla.nombre nombrePantalla, pantalla.link 
                                                FROM    modulo
                                                        INNER JOIN pantalla
                                                            ON  modulo.modulo = pantalla.modulo
                                                WHERE   modulo.activo = 'Y'
                                                AND     pantalla.activo = 'Y'
                                                ORDER BY modulo.orden, nombreModulo, pantalla.orden, nombrePantalla";

                                }
                                else {

                                    $strQuery ="SELECT  modulo.modulo, modulo.nombre nombreModulo, pantalla.pantalla, pantalla.nombre nombrePantalla, pantalla.link 
                                                FROM    modulo
                                                        INNER JOIN pantalla
                                                            ON  modulo.modulo = pantalla.modulo
                                                        INNER JOIN usuario_pantalla
                                                            ON  pantalla.pantalla = usuario_pantalla.pantalla     
                                                WHERE   modulo.activo = 'Y'
                                                AND     pantalla.activo = 'Y'
                                                AND     usuario_pantalla.usuario = {$_SESSION['usuario']}
                                                ORDER BY modulo.orden, nombreModulo, pantalla.orden, nombrePantalla";

                                }
                                $qTMP = db_consulta($strQuery);
                                while( $rTMP = db_fetch_assoc($qTMP) ) {
                                    $arrMenu[$rTMP["modulo"]]["nombreModulo"] = $rTMP["nombreModulo"];
                                    $arrMenu[$rTMP["modulo"]]["pantallas"][$rTMP["pantalla"]]["nombrePantalla"] = $rTMP["nombrePantalla"];
                                    $arrMenu[$rTMP["modulo"]]["pantallas"][$rTMP["pantalla"]]["link"] = $rTMP["link"];
                                }
                                db_free_result($qTMP);
                                reset($arrMenu);
                                $intCorrelativo = 1;
                                while( $arrM = each($arrMenu) ) {
                                    ?>
                                    <li class="treeview">
                                        <a id="aMenu_<?php echo $intCorrelativo; ?>" href="#"><i class="fa fa-user"></i><span><?php print $arrM["value"]["nombreModulo"]; ?></span>
                                            <span class="pull-right-container">
                                                <i class="fa fa-angle-left pull-right"></i>
                                            </span>
                                        </a>
                                        <ul class="treeview-menu" id="ulMenu_<?php echo $intCorrelativo; ?>">
                                            <?php
                                            while( $arrP = each($arrM["value"]["pantallas"]) ) {
                                                ?>
                                                <li><a href="<?php print $arrP["value"]["link"]; ?>">-&nbsp;<?php print $arrP["value"]["nombrePantalla"]; ?></a></li>
                                                <?php
                                            }
                                            ?>
                                        </ul>
                                    </li>
                                    <?php
                                    $intCorrelativo++;

                                }
                                ?>
                                <!--li><a href="#"><i class="fa fa-link"></i> <span>Another Link</span></a></li>
                                <li class="treeview">
                                    <a href="#"><i class="fa fa-link"></i> <span>Multilevel</span>
                                        <span class="pull-right-container">
                                            <i class="fa fa-angle-left pull-right"></i>
                                        </span>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li><a href="#">Link in level 2</a></li>
                                        <li><a href="#">Link in level 2</a></li>
                                    </ul>
                                </li-->
                            </ul>
                        </section>
                    </aside>
                    <div class="content-wrapper">
                        <!--section class="content-header">
                            <h1>
                                Page Header
                                <small>Optional description</small>
                            </h1>
                            <ol class="breadcrumb">
                                <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
                                <li class="active">Here</li>
                            </ol>
                        </section-->

                        <section class="content">
                    <?php
    
}

function drawFooter() {
                ?>
                </section>
            </div>
            <footer class="main-footer">
                <div class="pull-right hidden-xs">

                </div>
                <strong>Copyright &copy; 2017 <a href="#">Abdias</a>.</strong> All rights reserved.
            </footer>
            <!--aside class="control-sidebar control-sidebar-dark">
                <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
                    <li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
                    <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="control-sidebar-home-tab">
                        <h3 class="control-sidebar-heading">Recent Activity</h3>
                        <ul class="control-sidebar-menu">
                            <li>
                                <a href="javascript::;">
                                <i class="menu-icon fa fa-birthday-cake bg-red"></i>
                                <div class="menu-info">
                                    <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>
                                    <p>Will be 23 on April 24th</p>
                                </div>
                            </a>
                            </li>
                        </ul>
                        <h3 class="control-sidebar-heading">Tasks Progress</h3>
                        <ul class="control-sidebar-menu">
                            <li>
                                <a href="javascript::;">
                                <h4 class="control-sidebar-subheading">
                                    Custom Template Design
                                    <span class="pull-right-container">
                                        <span class="label label-danger pull-right">70%</span>
                                    </span>
                                </h4>
                                <div class="progress progress-xxs">
                                    <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                                </div>
                            </a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
                    <div class="tab-pane" id="control-sidebar-settings-tab">
                        <form method="post">
                            <h3 class="control-sidebar-heading">General Settings</h3>
                            <div class="form-group">
                                <label class="control-sidebar-subheading">
                                    Report panel usage
                                    <input type="checkbox" class="pull-right" checked>
                                </label>
                                <p>
                                    Some information about this general settings option
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </aside-->
            <div class="control-sidebar-bg"></div>
        </body>
    </html>
    <?php
}
