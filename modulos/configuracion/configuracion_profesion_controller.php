<?php
require_once("configuracion_profesion_view.php");
require_once("configuracion_profesion_model.php");

class configuracion_profesion_controller {
    
    public $objView;
    public $objModel;
    private $intProfesion;

    function __construct() {
        $this->objView = new configuracion_profesion_view();
        $this->objModel = new configuracion_profesion_model();
    }

    public function setProfesion(){
        $intProfesion = isset($_GET["profesion"]) ? $_GET["profesion"] : "";
        $this->intProfesion = $intProfesion;
    }

    public function getProfesion(){
        return $this->intProfesion;
    }

    public function drawContent(){

        if( isset($_GET["profesion"]) ){

            $this->objView->drawContentProfesion( $this->getProfesion() );
        }
        else{
            $this->objView->drawContent();
        }

    }

    public function process(){
        global $lang, $strAction, $objTemplate, $cfg;

        if( isset($_POST['hdnEliminar']) && intval($_POST['hdnEliminar']) > 0 ) {
            $intProfesion = isset($_POST['hdnEliminar']) ? $_POST['hdnEliminar'] : 0;

            $this->objModel->deleteProfesion($intProfesion);
            ?>
            <script>
                document.location = "<?php echo $strAction; ?>?strAlert=del";
            </script>
            <?php

        }
        elseif( isset($_POST['hdnProfesion']) ) {

            $intProfesion = isset($_POST['hdnProfesion']) ? intval($_POST['hdnProfesion']) : 0;
            $intProfesionTmp = $intProfesion;
            $strNombre = isset($_POST['txtNombre']) ? db_real_escape_string($_POST['txtNombre']) : '';
            $strDescripcion = isset($_POST['txtDescripcion']) ? db_real_escape_string($_POST['txtDescripcion']) : '';
            $strActivo = isset($_POST['chkActivo']) ? 'Y' : 'N';
            if( $intProfesion == 0 ) {
                if( !empty($strNombre) ) {

                    $intProfesion = $this->objModel->insertProfesion($strNombre,$strDescripcion,$strActivo,$_SESSION['usuario']);

                }
            }
            elseif( $intProfesion > 0 ) {
                if( !empty($strNombre)  ) {

                    $this->objModel->updateProfesion($intProfesion,$strNombre,$strDescripcion,$strActivo,$_SESSION['usuario']);

                }
            }

            if( $intProfesionTmp == 0 ) {
                header("location:{$strAction}?strAlert=ins");
            }
            else{
                header("location:{$strAction}?strAlert=upd");
            }
        }

    }

    public function runAjax(){

    }
    
}