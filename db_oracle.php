<?php
function db_conectar($db_host, $db_username, $db_password, $db_dbname) {
    $conn = oci_pconnect($db_username, $db_password, $db_host);
    if (!$conn) {
        $e = oci_error();
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        exit();
    }
    return $conn;
}

function db_cerrar() {
    global $objConexion;
    oci_close($objConexion);
}

function db_consulta($strQuery) {
    global $objConexion;

    $qTMP = @oci_parse($objConexion,$strQuery);
    @oci_execute($qTMP);
    return $qTMP; 
}

function db_fetch_assoc($rTMP) {
    return oci_fetch_array($rTMP);
}

function db_free_result($rTMP) {
    return oci_free_statement($rTMP);
}

/*
function db_insert_id() {
    global $objConexion;
    return mysqli_insert_id($objConexion);
}
*/
function db_real_escape_string($strEscape) {
    return str_replace("\"", "\\\"", $strEscape);
}
/*
function db_num_rows($rTMP) {
    return mysqli_num_rows($rTMP);
}

function db_affected_rows() {
    global $objConexion;
    return mysqli_affected_rows($objConexion);
}
*/