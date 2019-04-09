<?php

header('Content-Type: text/html; charset=ISO-8859-1');

require('main.php');
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
    <div class="container">
        <div class="row">
            <div class="col-md-2 col-md-offset-5">
                <img src="<?php echo "imagenes/logor&t.png"; ?>" class="img-responsive" alt=""/>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2 col-md-offset-5">
                &nbsp;
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Restaurar contraseña</h3>
                    </div>
                    <div class="panel-body">
                        <form id="frmRestablecer" role="form" method="post" action="validaremail.php">
                            <fieldset>
                                <div class="form-group">
                                    <label for="email"> Escribe el email asociado a tu cuenta para recuperar tu contraseña </label>
                                    <input type="email" id="email" class="form-control" name="email" required>
                                </div>
                                <!--div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="Remember Me">Recordar
                                    </label>
                                </div-->
                                <button class="btn btn-primary btn-lg btn-block" onclick="validarEmail();">
                                    Recuperar contraseña
                                </button>
                            </fieldset>
                        </form>
                    </div>
                </div>
                <div class="form-group" id="mensaje">&nbsp;</div>
            </div>
        </div>
    </div>
    <script>

        function validarEmail(){
            objAjaxBuscar = $.ajax({
                url:'validaremail.php',
                data:$("#frmRestablecer").serializeArray(),
                type:'post',
                dataType:'html',
                success:function(data){
                    $("#mensaje").html(data);
                }
            });
        }

        $(document).ready(function(){
            $("#frmRestablecer").submit(function(event){
                event.preventDefault();
            });
        });
    </script>
</body>
</html>