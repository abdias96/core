<?php
class ingreso_caso_model {
    
    function __construct() {
        
    }

    public function getListadoCasos(){
        $arrData = array();

        $strQuery = "SELECT caso,
                            no_caso
                     FROM   caso";
        $qTMP = db_consulta($strQuery);
        while( $rTMP = db_fetch_assoc($qTMP) ) {
            $arrData[$rTMP["caso"]]["no_caso"] = $rTMP["no_caso"];
        }
        db_free_result($qTMP);

        return $arrData;
    }

    public function getInfoCaso($intDelito = 0){
        $arrData = array();

        if($intDelito > 0){
            $strQuery = "SELECT delito,
                                nombre,
                                descripcion,
                                activo
                         FROM   delito
                         WHERE  delito = {$intDelito}";

            $qTMP = db_consulta($strQuery);
            while( $rTMP = db_fetch_assoc($qTMP) ) {
                $arrData["delito"] = $rTMP["delito"];
                $arrData["nombre"] = $rTMP["nombre"];
                $arrData["descripcion"] = $rTMP["descripcion"];
                $arrData["activo"] = $rTMP["activo"];
            }
            db_free_result($qTMP);
        }

        return $arrData;
    }

    public function getComisarias($intComisaria = 0){
        $arrData = array();

        $arrData[0]["texto"] = "Seleccione comisaría...";
        $arrData[0]["selected"] = false;

        $strQuery = "SELECT comisaria,
                            nombre
                     FROM   comisaria
                     ORDER  BY nombre";
        $qTMP = db_consulta($strQuery);
        while( $rTMP = db_fetch_assoc($qTMP) ) {
            $arrData[$rTMP["comisaria"]]["texto"] = $rTMP["nombre"];
            $arrData[$rTMP["comisaria"]]["selected"] = $rTMP["comisaria"] == $intComisaria ? true : false;
        }
        db_free_result($qTMP);

        return $arrData;
    }

    public function getEstaciones($intComisaria = 0, $intEstacion = 0){
        $arrData = array();

        $arrData[0]["texto"] = "Seleccione estación...";
        $arrData[0]["selected"] = false;

        if($intComisaria != 0){
            $strQuery = "SELECT estacion,
                                nombre
                         FROM   estacion
                         WHERE  comisaria = {$intComisaria}
                         ORDER  BY nombre";
            $qTMP = db_consulta($strQuery);
            while( $rTMP = db_fetch_assoc($qTMP) ) {
                $arrData[$rTMP["estacion"]]["texto"] = $rTMP["nombre"];
                $arrData[$rTMP["estacion"]]["selected"] = $rTMP["estacion"] == $intEstacion ? true : false;
            }
            db_free_result($qTMP);
        }

        return $arrData;
    }

    public function getSubEstaciones($intComisaria = 0, $intEstacion = 0, $intSubEstacion = 0){
        $arrData = array();

        $arrData[0]["texto"] = "Seleccione sub estación...";
        $arrData[0]["selected"] = false;

        if($intComisaria != 0 && $intEstacion != 0){
            $strQuery = "SELECT subestacion,
                                nombre
                         FROM   subestacion
                         WHERE  comisaria = {$intComisaria}
                         AND    estacion = {$intEstacion}
                         ORDER  BY nombre";
            $qTMP = db_consulta($strQuery);
            while( $rTMP = db_fetch_assoc($qTMP) ) {
                $arrData[$rTMP["subestacion"]]["texto"] = $rTMP["nombre"];
                $arrData[$rTMP["subestacion"]]["selected"] = $rTMP["subestacion"] == $intSubEstacion ? true : false;
            }
            db_free_result($qTMP);
        }

        return $arrData;
    }

    public function getCausas($intCausa = 0){
        $arrData = array();

        $arrData[0]["texto"] = "Seleccione causa...";
        $arrData[0]["selected"] = false;

        $strQuery = "SELECT causa,
                            nombre
                     FROM   causa
                     ORDER  BY nombre";
        $qTMP = db_consulta($strQuery);
        while( $rTMP = db_fetch_assoc($qTMP) ) {
            $arrData[$rTMP["causa"]]["texto"] = $rTMP["nombre"];
            $arrData[$rTMP["causa"]]["selected"] = $rTMP["causa"] == $intCausa ? true : false;
        }
        db_free_result($qTMP);

        return $arrData;
    }

    public function getDelitos(){
        $arrData = array();

        $strQuery = "SELECT delito,
                            nombre
                     FROM   delito
                     ORDER  BY nombre";
        $qTMP = db_consulta($strQuery);
        while( $rTMP = db_fetch_assoc($qTMP) ) {
            $arrData[$rTMP["delito"]]["texto"] = $rTMP["nombre"];
            $arrData[$rTMP["delito"]]["selected"] = false;
        }
        db_free_result($qTMP);

        return $arrData;
    }

    public function getDelitosCaso($intCaso = 0){
        $arrData = array();

        if($intCaso > 0 ){
            $strQuery = "SELECT delito
                         FROM   caso_delito
                         WHERE  caso = {$intCaso}";
            $qTMP = db_consulta($strQuery);
            while( $rTMP = db_fetch_assoc($qTMP) ) {
                $arrData[$rTMP["delito"]] = $rTMP["delito"];
            }
            db_free_result($qTMP);
        }

        return $arrData;
    }

    public function getMovilHecho($intMovilHecho = 0){
        $arrData = array();

        $arrData[0]["texto"] = "Seleccione móvil del hecho...";
        $arrData[0]["selected"] = false;

        $strQuery = "SELECT movil_hecho,
                            nombre
                     FROM   movil_hecho
                     ORDER  BY nombre";
        $qTMP = db_consulta($strQuery);
        while( $rTMP = db_fetch_assoc($qTMP) ) {
            $arrData[$rTMP["movil_hecho"]]["texto"] = $rTMP["nombre"];
            $arrData[$rTMP["movil_hecho"]]["selected"] = $rTMP["movil_hecho"] == $intMovilHecho ? true : false;
        }
        db_free_result($qTMP);

        return $arrData;
    }

    public function getDepartamentos($intDepartamento = 0){
        $arrData = array();

        $arrData[0]["texto"] = "Seleccione departamento...";
        $arrData[0]["selected"] = false;

        $strQuery = "SELECT departamento,
                            nombre
                     FROM   departamento
                     ORDER  BY nombre";
        $qTMP = db_consulta($strQuery);
        while( $rTMP = db_fetch_assoc($qTMP) ) {
            $arrData[$rTMP["departamento"]]["texto"] = $rTMP["nombre"];
            $arrData[$rTMP["departamento"]]["selected"] = $rTMP["departamento"] == $intDepartamento ? true : false;
        }
        db_free_result($qTMP);

        return $arrData;
    }

    public function getMunicipios($intDepartamento = 0, $intMunicipio = 0){
        $arrData = array();

        $arrData[0]["texto"] = "Seleccione municipio...";
        $arrData[0]["selected"] = false;

        if($intDepartamento != 0){
            $strQuery = "SELECT municipio,
                                nombre
                         FROM   municipio
                         WHERE  departamento = {$intDepartamento}
                         ORDER  BY nombre";
            $qTMP = db_consulta($strQuery);
            while( $rTMP = db_fetch_assoc($qTMP) ) {
                $arrData[$rTMP["municipio"]]["texto"] = $rTMP["nombre"];
                $arrData[$rTMP["municipio"]]["selected"] = $rTMP["municipio"] == $intMunicipio ? true : false;
            }
            db_free_result($qTMP);
        }

        return $arrData;
    }

    public function getTipoAutor($intTipoAutor = 0){
        $arrData = array();

        $arrData[0]["texto"] = "Seleccione tipo de autor...";
        $arrData[0]["selected"] = false;

        $strQuery = "SELECT tipo_autor,
                            nombre
                     FROM   tipo_autor
                     ORDER  BY nombre";
        $qTMP = db_consulta($strQuery);
        while( $rTMP = db_fetch_assoc($qTMP) ) {
            $arrData[$rTMP["tipo_autor"]]["texto"] = $rTMP["nombre"];
            $arrData[$rTMP["tipo_autor"]]["selected"] = $rTMP["tipo_autor"] == $intTipoAutor ? true : false;
        }
        db_free_result($qTMP);

        return $arrData;
    }

    public function getTipoSolicitudSecuestrador($intTipoSolicitudSecuestrador = 0){
        $arrData = array();

        $arrData[0]["texto"] = "Seleccione tipo de solicitud del secuestrador...";
        $arrData[0]["selected"] = false;

        $strQuery = "SELECT tipo_solicitud_secuestrador,
                            nombre
                     FROM   tipo_solicitud_secuestrador
                     ORDER  BY nombre";
        $qTMP = db_consulta($strQuery);
        while( $rTMP = db_fetch_assoc($qTMP) ) {
            $arrData[$rTMP["tipo_solicitud_secuestrador"]]["texto"] = $rTMP["nombre"];
            $arrData[$rTMP["tipo_solicitud_secuestrador"]]["selected"] = $rTMP["tipo_solicitud_secuestrador"] == $intTipoSolicitudSecuestrador ? true : false;
        }
        db_free_result($qTMP);

        return $arrData;
    }

    public function getEstadoFinalVictima($intEstadoFinalVictima = 0){
        $arrData = array();

        $arrData[0]["texto"] = "Seleccione estado final de la víctima...";
        $arrData[0]["selected"] = false;

        $strQuery = "SELECT estado_final_victima,
                            nombre
                     FROM   estado_final_victima
                     ORDER  BY nombre";
        $qTMP = db_consulta($strQuery);
        while( $rTMP = db_fetch_assoc($qTMP) ) {
            $arrData[$rTMP["estado_final_victima"]]["texto"] = $rTMP["nombre"];
            $arrData[$rTMP["estado_final_victima"]]["selected"] = $rTMP["estado_final_victima"] == $intEstadoFinalVictima ? true : false;
        }
        db_free_result($qTMP);

        return $arrData;
    }

    public function getDireccionCautiverio($intCaso = 0){
        $arrData = array();

        if($intCaso > 0){
            $strQuery = "SELECT caso_direccion_cautiverio, 
                                direccion, 
                                municipio, 
                                departamento
                        FROM    caso_direccion_cautiverio
                        WHERE   caso = {$intCaso}";
            $qTMP = db_consulta($strQuery);
            while( $rTMP = db_fetch_assoc($qTMP) ) {
                $arrData[$rTMP["caso_direccion_cautiverio"]]["direccion"] = $rTMP["direccion"];
                $arrData[$rTMP["caso_direccion_cautiverio"]]["municipio"] = $rTMP["municipio"];
                $arrData[$rTMP["caso_direccion_cautiverio"]]["departamento"] = $rTMP["departamento"];
            }
            db_free_result($qTMP);
        }

        return $arrData;
    }

    public function insertCaso($strNombre,$strDescripcion,$strActivo,$intUser){
        $intDelito = 0;
        $strQuery ="INSERT INTO delito(nombre,descripcion,activo,add_usuario,add_fecha) 
                        VALUES ('{$strNombre}','{$strDescripcion}','{$strActivo}',{$intUser},now())";
        db_consulta($strQuery);
        $intDelito = db_insert_id();

        return $intDelito;
    }

    public function updateCaso($intDelito,$strNombre,$strDescripcion,$strActivo,$intUser){
            $strQuery ="UPDATE  delito 
                    SET     nombre = '{$strNombre}',
                            descripcion = '{$strDescripcion}',
                            activo =  '{$strActivo}',
                            mod_usuario = {$intUser},
                            mod_fecha = now()
                    WHERE   delito = {$intDelito}";
            db_consulta($strQuery);

    }
    
}