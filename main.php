<?php
session_start();
include('configuracion.php');
include('db_mysqli.php');
$objConexion = db_conectar(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_DBNAME);
include('functions.php');