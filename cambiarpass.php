<?php
header('Content-Type: text/html; charset=ISO-8859-1');

require('main.php');

$password1 = $_POST['password1'];
$password2 = $_POST['password2'];
$idusuario = $_POST['idusuario'];
$token = $_POST['token'];

if( $password1 != "" && $password2 != "" && $idusuario != "" && $token != "" ){
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html" charset=ISO-8859-1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no" name="viewport">
    <title><?php echo "R&T - "; ?></title>
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
    <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="dist/js/app.min.js"></script>
    <script src="plugins/morris/morris.min.js"></script>
    <script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <script src="plugins/knob/jquery.knob.js"></script>
    <!--script src="plugins/daterangepicker/daterangepicker.js"></script-->
    <script src="plugins/datepicker/bootstrap-datepicker.js"></script>
    <script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <script src="plugins/fastclick/fastclick.js"></script>
</head>
<body>
    <div class="container" role="main">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <?php
            $strQuery = " SELECT * FROM reseteo_pass WHERE token = '$token' ";
            $resultado = db_consulta($strQuery);
            if( $resultado->num_rows > 0 ){
                $usuario = $resultado->fetch_assoc();
                if( sha1( $usuario['usuario'] === $idusuario ) ){
                    if( $password1 === $password2 ){
                        $strQuery = "UPDATE usuario SET pass = '".MD5($password1)."' WHERE usuario = ".$usuario['usuario'];
                        $resultado = db_consulta($strQuery);
                        if($resultado){
                            $strQuery = "DELETE FROM reseteo_pass WHERE token = '$token';";
                            $resultado = db_consulta($strQuery);
                            ?>
                            <p class="alert alert-info"> La contraseña se actualizó con exito. </p>
                            <?php
                        }
                        else{
                            ?>
                            <p class="alert alert-danger"> Ocurrió un error al actualizar la contraseña, intentalo más tarde </p>
                            <?php
                        }
                    }
                    else{
                        ?>
                        <p class="alert alert-danger"> Las contraseñas no coinciden </p>
                        <?php
                    }
                }
                else{
                    ?>
                    <p class="alert alert-danger"> El token no es válido </p>
                    <?php
                }
            }
            else{
                ?>
                <p class="alert alert-danger"> El token no es válido </p>
                <?php
            }
            ?>
        </div>
        <div class="col-md-2"></div>
    </div>
</body>
</html>
    <?php
}
else{
    header('Location:index.php');
}
?>