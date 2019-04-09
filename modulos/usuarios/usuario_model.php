<?php
class usuario_model {
    
    function __construct() {
        
    }

    public function deleteUsuario($intUsuario = 0){
        if($intUsuario > 0){
            $strQuery ="UPDATE  usuario
                SET     activo = 'Y',
                        eliminado = 'Y'
                WHERE   usuario = {$intUsuario}";
            db_consulta($strQuery);
        }
    }

    public function getListadoUsuario(){
        $arrData = array();

        $strWhere = ($_SESSION['tipo_usuario'] == 'administrador') ? "" : " AND tipo_usuario IN('normal') ";
        $strQuery = "SELECT usuario,
                            nombre,
                            apellido,
                            usser,
                            tipo_usuario,
                            activo,
                            email
                     FROM   usuario
                     WHERE  eliminado = 'N'
                     {$strWhere}    
                     ORDER  BY nombre";
        $qTMP = db_consulta($strQuery);
        while( $rTMP = db_fetch_assoc($qTMP) ) {
            $arrData[$rTMP["usuario"]]["usuario"] = $rTMP["usuario"];
            $arrData[$rTMP["usuario"]]["nombre"] = $rTMP["nombre"];
            $arrData[$rTMP["usuario"]]["apellido"] = $rTMP["apellido"];
            $arrData[$rTMP["usuario"]]["usser"] = $rTMP["usser"];
            $arrData[$rTMP["usuario"]]["tipo_usuario"] = $rTMP["tipo_usuario"];
            $arrData[$rTMP["usuario"]]["activo"] = $rTMP["activo"];
            $arrData[$rTMP["usuario"]]["email"] = $rTMP["email"];
        }
        db_free_result($qTMP);

        return $arrData;
    }

    public function getInfoUsuario($intUsuario = 0){
        $arrData = array();

        if($intUsuario > 0){
            $strQuery = "SELECT usuario,
                                nombre,
                                apellido,
                                usser,
                                tipo_usuario,
                                activo,
                                email,
                                direccion,
                                telefono, 
                                foto, 
                                firma
                         FROM   usuario
                         WHERE  usuario = {$intUsuario}";

            $qTMP = db_consulta($strQuery);
            while( $rTMP = db_fetch_assoc($qTMP) ) {
                $arrData["usuario"] = $rTMP["usuario"];
                $arrData["nombre"] = $rTMP["nombre"];
                $arrData["apellido"] = $rTMP["apellido"];
                $arrData["usser"] = $rTMP["usser"];
                $arrData["tipo_usuario"] = $rTMP["tipo_usuario"];
                $arrData["activo"] = $rTMP["activo"];
                $arrData["email"] = $rTMP["email"];
                $arrData["direccion"] = $rTMP["direccion"];
                $arrData["telefono"] = $rTMP["telefono"];
                $arrData["foto"] = $rTMP["foto"];
                $arrData["firma"] = $rTMP["firma"];
            }
            db_free_result($qTMP);
        }

        return $arrData;
    }

    public function getUsuarioPantalla($intUsuario = 0){
        $arrUsuarioPantalla = array();

        if($intUsuario > 0){
            $strQuery = "SELECT usuario_pantalla.usuario,
                                usuario_pantalla.pantalla
                         FROM   usuario_pantalla
                         WHERE  usuario_pantalla.usuario = {$intUsuario}";
            $qTMP = db_consulta($strQuery);
            while( $rTMP = db_fetch_assoc($qTMP) ) {
                $arrUsuarioPantalla[$rTMP["pantalla"]] = $rTMP["pantalla"];
            }
            db_free_result($qTMP);
        }

        return $arrUsuarioPantalla;
    }

    public function getInfoModulo(){
        $arrData = array();

        $strQuery = "SELECT modulo.modulo,
                            modulo.nombre AS nombreModulo,
                            pantalla.pantalla,
                            pantalla.nombre AS nombrePantalla
                     FROM   modulo
                            INNER JOIN pantalla
                                ON  pantalla.modulo = modulo.modulo
                     WHERE  modulo.activo = 'Y'
                     AND    pantalla.activo = 'Y'
                     ORDER  BY modulo.orden, modulo.nombre, pantalla.orden, pantalla.nombre";
        $qTMP = db_consulta($strQuery);
        while( $rTMP = db_fetch_assoc($qTMP) ) {
            $arrData[$rTMP["modulo"]]["nombreModulo"] = $rTMP["nombreModulo"];
            $arrData[$rTMP["modulo"]]["pantallas"][$rTMP["pantalla"]]["nombrePantalla"] = $rTMP["nombrePantalla"];
        }
        db_free_result($qTMP);

        return $arrData;
    }

    public function insertUsuario($strNombre,$strApellido,$strCuenta,$strPassword,$strTipoUsuario,$strActivo,$strEmail,$strDireccion,$strTelefono,$strPathFoto,$strPathFirma,$intUser){
        $intUsuario = 0;
        $strQuery ="INSERT INTO usuario(nombre,apellido,usser,pass,tipo_usuario,activo,email,direccion,telefono,foto,firma,add_usuario,add_fecha) 
                        VALUES ('{$strNombre}','{$strApellido}','{$strCuenta}',MD5('{$strPassword}'),'{$strTipoUsuario}','{$strActivo}','{$strEmail}','{$strDireccion}','{$strTelefono}','{$strPathFoto}','{$strPathFirma}',{$intUser},now())";
        db_consulta($strQuery);
        $intUsuario = db_insert_id();

        return $intUsuario;
    }

    public function updateUsuario($intUsuario,$strNombre,$strApellido,$strCuenta,$strPassword,$strTipoUsuario,$strActivo,$strEmail,$strDireccion,$strTelefono,$strPathFoto,$strPathFirma,$intUser){

        if($strPassword == ""){
            $strQuery ="UPDATE  usuario 
                    SET     nombre = '{$strNombre}',
                            apellido = '{$strApellido}',
                            usser = '{$strCuenta}',
                            tipo_usuario = '{$strTipoUsuario}',
                            activo =  '{$strActivo}',
                            email = '{$strEmail}',
                            direccion = '{$strDireccion}',
                            telefono = '{$strTelefono}',
                            foto = '{$strPathFoto}',
                            firma = '{$strPathFirma}',
                            mod_usuario = {$intUser},
                            mod_fecha = now()
                    WHERE   usuario = {$intUsuario}";
            db_consulta($strQuery);
        }
        else{
            $strQuery ="UPDATE  usuario 
                    SET     nombre = '{$strNombre}',
                            apellido = '{$strApellido}',
                            usser = '{$strCuenta}',
                            pass = '{$strPassword}',
                            tipo_usuario = '{$strTipoUsuario}',
                            activo =  '{$strActivo}',
                            email = '{$strEmail}',
                            direccion = '{$strDireccion}',
                            telefono = '{$strTelefono}',
                            foto = '{$strPathFoto}',
                            firma = '{$strPathFirma}',
                            mod_usuario = {$intUser},
                            mod_fecha = now()
                    WHERE   usuario = {$intUsuario}";
            db_consulta($strQuery);
        }

    }
    
}