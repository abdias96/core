<?php
require_once("usuario_view.php");
require_once("usuario_model.php");

class usuario_controller {
    
    public $objView;
    public $objModel;
    private $intUsuario;

    function __construct() {
        $this->objView = new usuario_view();
        $this->objModel = new usuario_model();
    }

    public function setUsuario(){
        $intUsuario = isset($_GET["usuario"]) ? $_GET["usuario"] : "";
        $this->intUsuario = $intUsuario;
    }

    public function getUsuario(){
        return $this->intUsuario;
    }

    public function drawContent(){

        if( isset($_GET["usuario"]) ){

            $this->objView->drawContentUsuario( $this->getUsuario() );
        }
        else{
            $this->objView->drawContent();
        }

    }

    public function process(){
        global $lang, $strAction, $objTemplate, $cfg;

        if( isset($_POST['hdnEliminar']) && intval($_POST['hdnEliminar']) > 0 ) {
            $intUsuario = isset($_POST['hdnEliminar']) ? $_POST['hdnEliminar'] : 0;

            $this->objModel->deleteUsuario($intUsuario);
            ?>
            <script>
                document.location = "<?php echo $strAction; ?>?strAlert=del";
            </script>
            <?php

        }
        elseif( isset($_POST['hdnUsuario']) ) {

            $intUsuario = isset($_POST['hdnUsuario']) ? intval($_POST['hdnUsuario']) : 0;
            $intUsuarioTmp = $intUsuario;

            $strNombre = isset($_POST['txtNombre']) ? ($_POST['txtNombre']) : '';
            $strApellido = isset($_POST['txtApellido']) ? ($_POST['txtApellido']) : '';
            $strCuenta = isset($_POST['txtCuenta']) ? ($_POST['txtCuenta']) : '';
            $strEmail = isset($_POST['txtEmail']) ? ($_POST['txtEmail']) : '';
            $strDireccion = isset($_POST['txtDireccion']) ? ($_POST['txtDireccion']) : '';
            $strTelefono = isset($_POST['txtTelefono']) ? ($_POST['txtTelefono']) : '';
            $strTipoUsuario = isset($_POST['sltTipoUsuario']) ? ($_POST['sltTipoUsuario']) : '';
            $strPassword = isset($_POST['txtPassword']) ? ($_POST['txtPassword']) : "";
            $strActivo = isset($_POST['chkActivo']) ? 'Y' : 'N';
            $strPathFoto = isset($_FILES['strFoto']['name']) && $_FILES['strFoto']['name'] != "" ? "imagenes/".$_FILES['strFoto']['name'] : $_POST['hdnFoto'];
            $strPathFirma = isset($_FILES['strFirma']['name']) && $_FILES['strFirma']['name'] != "" ? "imagenes/".$_FILES['strFirma']['name'] : $_POST['hdnFirma'];

            move_uploaded_file($_FILES['strFoto']['tmp_name'], $strPathFoto);
            move_uploaded_file($_FILES['strFirma']['tmp_name'], $strPathFirma);

            if( $intUsuario == 0 ) {
                if( !empty($strNombre) && !empty($strApellido) && !empty($strEmail) && !empty($strPassword) && !empty($strTipoUsuario) ) {

                    $intUsuario = $this->objModel->insertUsuario($strNombre,$strApellido,$strCuenta,$strPassword,$strTipoUsuario,$strActivo,$strEmail,$strDireccion,$strTelefono,$strPathFoto,$strPathFirma,$_SESSION['usuario']);

                    $strMessage = "Estimado(a) {$strNombre},\r\n Te damos la bienvenida al Sistema de Registro de expedientes.\r\n Para acceder al sitio ingresa al siguiente link: http://gruporyt.net/sistema/login.php con el siguiente usuario y contraseña.Usuario: {$strCuenta} Contraseña: {$strPassword} \r\nSaludos cordiales, Webmaster";

                    $strFrom = "webmaster@gruporyt.net";
                    $strSubject = "Acceso a R&T";

                    $strHeader = "From: ".$strFrom."\r\n";

                    @mail($strEmail, $strSubject, $strMessage, $strHeader );

                }
            }
            elseif( $intUsuario > 0 ) {
                $boolPasswordCambiar = isset($_POST['chkPasswordCambiar']) ? true : false;
                $strPassword = "";
                if( $boolPasswordCambiar ) {
                    $strPassword = isset($_POST['txtPassword']) ? db_real_escape_string($_POST['txtPassword']) : "";
                }
                if( !empty($strNombre) && !empty($strCuenta) && !empty($strTipoUsuario) ) {

                    $strPassword = empty($strPassword) ? "" : "password = MD5('".$strPassword."'),";

                    $this->objModel->updateUsuario($intUsuario,$strNombre,$strApellido,$strCuenta,$strPassword,$strTipoUsuario,$strActivo,$strEmail,$strDireccion,$strTelefono,$strPathFoto,$strPathFirma,$_SESSION['usuario']);

                }
            }

            $strQuery = "DELETE FROM usuario_pantalla WHERE usuario = {$intUsuario}";
            db_consulta($strQuery);

            reset($_POST);
            while( $arrP = each($_POST) ) {

                $arrExplode = explode("_",$arrP["key"]);
                if( $arrExplode[0] == "chkPantalla" ) {
                    $strQuery = "INSERT INTO usuario_pantalla(usuario,pantalla,add_usuario,add_fecha) VALUES ({$intUsuario},'{$arrP["value"]}',1,now())";
                    db_consulta($strQuery);
                }

            }

            if( $intUsuarioTmp == 0 ) {
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