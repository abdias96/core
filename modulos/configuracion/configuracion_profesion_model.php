<?php
class configuracion_profesion_model {
    
    function __construct() {
        
    }

    public function getListadoProfesion(){
        $arrData = array();

        $strQuery = "SELECT profesion,
                            nombre,
                            descripcion,
                            activo
                     FROM   profesion
                     ORDER  BY nombre";
        $qTMP = db_consulta($strQuery);
        while( $rTMP = db_fetch_assoc($qTMP) ) {
            $arrData[$rTMP["profesion"]]["profesion"] = $rTMP["profesion"];
            $arrData[$rTMP["profesion"]]["nombre"] = $rTMP["nombre"];
            $arrData[$rTMP["profesion"]]["descripcion"] = $rTMP["descripcion"];
            $arrData[$rTMP["profesion"]]["activo"] = $rTMP["activo"];
        }
        db_free_result($qTMP);

        return $arrData;
    }

    public function getInfoProfesion($intProfesion = 0){
        $arrData = array();

        if($intProfesion > 0){
            $strQuery = "SELECT profesion,
                                nombre,
                                descripcion,
                                activo
                         FROM   profesion
                         WHERE  profesion = {$intProfesion}";

            $qTMP = db_consulta($strQuery);
            while( $rTMP = db_fetch_assoc($qTMP) ) {
                $arrData["profesion"] = $rTMP["profesion"];
                $arrData["nombre"] = $rTMP["nombre"];
                $arrData["descripcion"] = $rTMP["descripcion"];
                $arrData["activo"] = $rTMP["activo"];
            }
            db_free_result($qTMP);
        }

        return $arrData;
    }

    public function insertProfesion($strNombre,$strDescripcion,$strActivo,$intUser){
        $intProfesion = 0;
        $strQuery ="INSERT INTO profesion(nombre,descripcion,activo,add_usuario,add_fecha) 
                        VALUES ('{$strNombre}','{$strDescripcion}','{$strActivo}',{$intUser},now())";
        db_consulta($strQuery);
        $intProfesion = db_insert_id();

        return $intProfesion;
    }

    public function updateProfesion($intProfesion,$strNombre,$strDescripcion,$strActivo,$intUser){
            $strQuery ="UPDATE  profesion 
                    SET     nombre = '{$strNombre}',
                            descripcion = '{$strDescripcion}',
                            activo =  '{$strActivo}',
                            mod_usuario = {$intUser},
                            mod_fecha = now()
                    WHERE   profesion = {$intProfesion}";
            db_consulta($strQuery);

    }
    
}