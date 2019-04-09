<?php
require('main.php');
require_once("modulos/usuarios/usuario_controller.php");
if( !boolThereLogin() )
    header('location:error.php');

$objController = new usuario_controller();
$strAction = basename(__FILE__);

$objController->runAjax();

$objController->setUsuario();

$objController->process();

drawHeader("Usuarios");

$objController->drawContent();

drawFooter();
