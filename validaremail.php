<?php

header('Content-Type: text/html; charset=ISO-8859-1');

require('main.php');

function generarLinkTemporal($idusuario, $username){

    $cadena = $idusuario.$username.rand(1,9999999).date('Y-m-d');
    $token = sha1($cadena);

    $strQuery = "INSERT INTO reseteo_pass (usuario, usser, token, add_usuario, add_fecha) VALUES($idusuario,'$username','$token',1,NOW());";
    $resultado = db_consulta($strQuery);
    if($resultado){
        $enlace = 'http://gruporyt.net/sistema/restablecer.php?idusuario='.sha1($idusuario).'&token='.$token;
        return $enlace;
    }
    else
        return FALSE;
}

function enviarEmail( $strEmail, $link ){

    $strMessage = "Restablece tu contraseña \r\n Hemos recibido una petición para restablecer la contraseña de tu cuenta. \r\n
      Si hiciste esta petición, haz clic en el siguiente enlace, si no hiciste esta petición puedes ignorar este correo.\r\n
         Enlace para restablecer tu contraseña \r\n
          {$link}";

    $strFrom = "webmaster@gruporyt.net";
    $strSubject = "Acceso a R&T";

    $strHeader = "From: ".$strFrom."\r\n";

    @mail($strEmail, $strSubject, $strMessage, $strHeader );


}

$email = $_POST['email'];

$respuesta = "";

if( $email != "" ){

    $strQuery = " SELECT * FROM usuario WHERE email = '$email' ";
    $resultado = db_consulta($strQuery);
    if($resultado->num_rows > 0){
        $usuario = $resultado->fetch_assoc();
        $linkTemporal = generarLinkTemporal( $usuario['usuario'], $usuario['usser'] );
        if($linkTemporal){
            enviarEmail( $email, $linkTemporal );
            $respuesta = '<div class="alert alert-info"> Un correo ha sido enviado a su cuenta de email con las instrucciones para restablecer la contraseña </div>';
        }
    }
    else
        $respuesta = '<div class="alert alert-warning"> No existe una cuenta asociada a ese correo. </div>';
}
else
    $respuesta = "Debes introducir el email de la cuenta";
echo ( $respuesta );
?>