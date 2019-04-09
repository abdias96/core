<?php
print_r("hola");
require('main.php'); 

if( !empty($_POST['txtUsuario']) && !empty($_POST['txtPassword']) ) {
    $_SESSION['login_error'] = "Usuario y/o contraseña inválida.";
    $strUsuario = db_real_escape_string(trim($_POST['txtUsuario']));
    $strPassword = db_real_escape_string(trim($_POST['txtPassword']));
    $strQuery = "SELECT usuario,
                        nombre,
                        apellido,
                        usser,
                        email,
                        tipo_usuario
                 FROM   usuario
                 WHERE  usser = '{$strUsuario}'
                 AND    pass = MD5('{$strPassword}')";
    $qTMP = db_consulta($strQuery);
    while( $rTMP = db_fetch_assoc($qTMP) ) {
        $_SESSION['login'] = true;
        $_SESSION['usuario'] = $rTMP['usuario'];
        $_SESSION['nombre'] = $rTMP['nombre'];
        $_SESSION['apellido'] = $rTMP['apellido'];
        $_SESSION['usser'] = $rTMP['usser'];
        $_SESSION['email'] = $rTMP['email'];
        $_SESSION['tipo_usuario'] = $rTMP['tipo_usuario'];
        unset($_SESSION['login_error']);
    }
    db_free_result($qTMP);
    
}
elseif( ( !empty($_POST['txtUsuario']) && empty($_POST['txtPassword']) ) || ( empty($_POST['txtUsuario']) && !empty($_POST['txtPassword']) ) ) {
    $_SESSION['login_error'] = "Usuario y/o contraseña inválida.";
}

if( !boolThereLogin() )
    header('location:login.php');

$strAction = basename(__FILE__);
drawHeader("Página principal");
    ?>

    <?php
drawFooter();
?>