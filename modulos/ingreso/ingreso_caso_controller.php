<?php
require_once("ingreso_caso_view.php");
require_once("ingreso_caso_model.php");

class ingreso_caso_controller {
    
    public $objView;
    public $objModel;
    private $intCaso;

    function __construct() {
        $this->objView = new ingreso_caso_view();
        $this->objModel = new ingreso_caso_model();
    }

    public function setCaso(){
        $intCaso = isset($_GET["caso"]) ? $_GET["caso"] : "";
        $this->intCaso = $intCaso;
    }

    public function getCaso(){
        return $this->intCaso;
    }

    public function drawContent(){

        if( isset($_GET["caso"]) ){

            $this->objView->drawContentCaso( $this->getCaso() );
        }
        else{
            $this->objView->drawContent();
        }

    }

    public function process(){
        global $lang, $strAction, $objTemplate, $cfg;

        if( isset($_POST['hdnEliminar']) && intval($_POST['hdnEliminar']) > 0 ) {
            $intCaso = isset($_POST['hdnEliminar']) ? $_POST['hdnEliminar'] : 0;

            $this->objModel->deleteCaso($intCaso);
            ?>
            <script>
                document.location = "<?php echo $strAction; ?>?strAlert=del";
            </script>
            <?php

        }
        elseif( isset($_POST['hdnCaso']) ) {

            $intCaso = isset($_POST['hdnCaso']) ? intval($_POST['hdnCaso']) : 0;
            $intCasoTmp = $intCaso;
            $strNombre = isset($_POST['txtNombre']) ? db_real_escape_string($_POST['txtNombre']) : '';
            $strDescripcion = isset($_POST['txtDescripcion']) ? db_real_escape_string($_POST['txtDescripcion']) : '';
            $strActivo = isset($_POST['chkActivo']) ? 'Y' : 'N';
            if( $intCaso == 0 ) {
                if( !empty($strNombre) ) {

                    $intCaso = $this->objModel->insertCaso($strNombre,$strDescripcion,$strActivo,$_SESSION['usuario']);

                }
            }
            elseif( $intCaso > 0 ) {
                if( !empty($strNombre)  ) {

                    $this->objModel->updateCaso($intCaso,$strNombre,$strDescripcion,$strActivo,$_SESSION['usuario']);

                }
            }

            if( $intCasoTmp == 0 ) {
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