<?php
require_once("usuario_model.php");

class usuario_view {
    
    public $objModel;
    public $strAlertaTipo = "";

    function __construct() {
        $this->objModel = new usuario_model();
    }

    public function drawContent(){
        global $lang, $strAction, $objTemplate;
        $strForm = 'frmUsuario';

        $boolAlertaEliminar = isset($_GET["strAlert"]) && $_GET["strAlert"] == "del" ? true : false;
        $boolAlertaCreada = isset($_GET["strAlert"]) && $_GET["strAlert"] == "ins" ? true : false;
        $boolAlertaModificada = isset($_GET["strAlert"]) && $_GET["strAlert"] == "upd" ? true : false;
        ?>
        <form name="<?php print  $strForm; ?>" id="<?php print $strForm; ?>" method="post" action="<?php print $strAction; ?>" class="form-horizontal" enctype="multipart/form-data">
            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <ol class="breadcrumb">
                            <li><a href="index.php">Inicio</a></li>
                            <li><a href="<?php print $strAction; ?>" class="active">Usuarios</a></li>
                        </ol>
                    </div>
                    <?php
                    if( $boolAlertaEliminar ) {
                        ?>
                        <div class="col-lg-4 col-lg-offset-4">
                            <div class="alert alert-warning">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <span class="glyphicon glyphicon-warning-sign"></span>&nbsp;<strong>Aviso:</strong>&nbsp;Usuario eliminado.
                            </div>
                        </div>
                        <?php
                    }
                    if( $boolAlertaCreada ) {
                        ?>
                        <div class="col-lg-5 col-lg-offset-3">
                            <div class="alert alert-success">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <span class="glyphicon glyphicon-info-sign"></span>&nbsp;<strong>información:</strong>&nbsp;Usuario creado exitosamente.
                            </div>
                        </div>
                        <?php
                    }
                    if( $boolAlertaModificada ) {
                        ?>
                        <div class="col-lg-5 col-lg-offset-3">
                            <div class="alert alert-info">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <span class="glyphicon glyphicon-info-sign"></span>&nbsp;<strong>información:</strong>&nbsp;Usuario modificado exitosamente.
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <button type="button" class="btn btn-primary btn-sm" onclick="fntNuevoUsuario();">
                                    <span class="glyphicon glyphicon-plus"></span>&nbsp;Nuevo usuario
                                </button>
                                <script>
                                    function fntNuevoUsuario() {
                                        document.location = "<?php print $strAction; ?>?usuario=0";
                                    }
                                    function fntEditarUsuario(intUsuario) {
                                        document.location = "<?php print $strAction; ?>?usuario="+intUsuario;
                                    }
                                </script>
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="tblPaginas">
                                        <thead>
                                        <tr>
                                            <th width="5%" class="text-center">ID</th>
                                            <th width="30%">&nbsp;&nbsp;Nombre&nbsp;&nbsp;</th>
                                            <th width="21%">&nbsp;&nbsp;Usuario&nbsp;&nbsp;</th>
                                            <th width="20%">&nbsp;&nbsp;Correo electrónico&nbsp;&nbsp;</th>
                                            <th width="8%">&nbsp;&nbsp;Tipo&nbsp;&nbsp;</th>
                                            <th width="7%" class="text-center">Activo</th>
                                            <th width="8%" class="text-center">&nbsp;Acción&nbsp;</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $arrListadoUsuario = $this->objModel->getListadoUsuario();

                                        while( $rTMP = each($arrListadoUsuario) ) {
                                            ?>
                                            <tr>
                                                <td class="text-center"><a href="<?php print $strAction; ?>?usuario=<?php print $rTMP["key"]; ?>"><?php print $rTMP["key"]; ?></a></td>
                                                <td><?php print $rTMP["value"]["nombre"]." ".$rTMP["value"]["apellido"]; ?></td>
                                                <td><?php print $rTMP["value"]["usser"]; ?></td>
                                                <td><?php print $rTMP["value"]["email"]; ?></td>
                                                <td><?php print ucfirst($rTMP["value"]["tipo_usuario"]); ?></td>
                                                <td class="text-center"><?php print $rTMP["value"]["activo"] == 'Y' ? 'Si' : 'No'; ?></td>
                                                <td class=" text-center">
                                                    <button type="button" class="btn btn-info btn-xs" onclick="fntEditarUsuario(<?php print $rTMP["key"]; ?>);" data-toggle="tooltip" data-placement="bottom" title="Editar usuario">
                                                        <span class="glyphicon glyphicon-pencil"></span>
                                                    </button>
                                                    <button type="button" class="btn btn-danger btn-xs" onclick="fntEliminarUsuario(<?php print $rTMP["key"]; ?>, '<?php print $rTMP["value"]["nombre"]; ?>', true);" data-toggle="tooltip" data-placement="bottom" title="Eliminar usuario">
                                                        <span class="glyphicon glyphicon-trash"></span>
                                                    </button>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
            </div>
            <input type="hidden" name="hdnEliminar" id="hdnEliminar" value="0"  readonly="readonly">
        </form>
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Eliminar usuario</h4>
                    </div>
                    <div class="modal-body" id="divEliminarModalBody">
                        ¿Está seguro?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" onclick="fntEliminarUsuario(0,'', false)">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            function fntEliminarUsuario(intUsuario, strTexto, boolConfirmar) {

                if( intUsuario > 0 ) {
                    $("#hdnEliminar").val(intUsuario);
                }
                if( strTexto.length > 0 ) {
                    $("#divEliminarModalBody").html('¿Está seguro de eliminar el usuario <i>"'+strTexto+'"</i>?');
                }
                if( boolConfirmar ) {
                    $('#myModal').modal();
                }
                else {
                    $('#myModal').modal('hide');
                    $("#<?php print $strForm; ?>").submit();
                }

            }

            $(document).ready(function() {
                $('#tblPaginas').dataTable({
                    "language": {
                        "emptyTable":     "No hay datos disponibles en la tabla",
                        "info":           "Mostrando del _START_ al _END_ de _TOTAL_ filas",
                        "infoEmpty":      "Mostrando 0 de 0 filas",
                        "infoFiltered":   "(filtradas de _MAX_ filas totales)",
                        "infoPostFix":    "",
                        "thousands":      ",",
                        "lengthMenu":     "Mostrar _MENU_ filas",
                        "loadingRecords": "Loading...",
                        "processing":     "Processing...",
                        "search":         "Buscar: ",
                        "zeroRecords":    "No hay registros coincidentes encontrados",
                        "paginate": {
                            "first":      "Primero",
                            "last":       "Ultimo",
                            "next":       "Siguiente",
                            "previous":   "Anterior"
                        },
                        "aria": {
                            "sortAscending":  ": activate to sort column ascending",
                            "sortDescending": ": activate to sort column descending"
                        }
                    }
                });
                $('button').tooltip();
            });
        </script>
        <?php
    }

    public function drawContentUsuario($intUsuario){
        global $lang, $strAction, $objTemplate;

        $strForm = 'frmUsuario';

        $arrInfoUsuario = $this->objModel->getInfoUsuario($intUsuario);
        //print "<pre>";
        //print_r($arrInfoUsuario);
        //print "</pre>";


        ?>
        <form name="<?php print  $strForm; ?>" id="<?php print $strForm; ?>" method="post" action="<?php print $strAction; ?>" class="form-horizontal" enctype="multipart/form-data">
            <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <ol class="breadcrumb">
                        <li><a href="index.php">Inicio</a></li>
                        <li><a href="<?php print $strAction; ?>">Usuarios</a></li>
                        <li class="active"><?php print isset($arrInfoUsuario['nombre']) ? $arrInfoUsuario['nombre'] : 'Nuevo usuario'; ?></li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <button type="button" class="btn btn-success btn-sm" onclick="fntGuardar();">
                                <span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;Guardar
                            </button>
                            <button type="button" class="btn btn-primary btn-sm" onclick="fntRegresar();">
                                <span class="glyphicon glyphicon-th-list"></span>&nbsp;Ir al listado
                            </button>
                        </div>
                        <div class="panel-body">
                            <input type="hidden" name="hdnUsuario" value="<?php print $intUsuario; ?>" readonly="readonly">
                            <div class="form-group" id="txtFotoGrupo">
                                <label for="txtFoto" class="col-lg-3 col-lg-offset-1 control-label">Foto</label>
                                <div class="col-lg-5">
                                    <input type="hidden" name="hdnFoto" value="<?php print isset($arrInfoUsuario['foto']) ? $arrInfoUsuario['foto'] : ''; ?>" readonly="readonly">
                                    <input type="file" name="strFoto" id="strFoto">
                                </div>
                            </div>
                            <div class="form-group has-feedback" id="txtNombreGrupo">
                                <label for="txtNombre" class="col-lg-3 col-lg-offset-1 control-label">Nombre *</label>
                                <div class="col-lg-5">
                                    <input type="text" name="txtNombre" id="txtNombre" value="<?php print isset($arrInfoUsuario['nombre']) ? $arrInfoUsuario['nombre'] : ''; ?>" class="form-control input-sm" autofocus="autofocus" maxlength="75" required="required" aria-describedby="txtNombreEstado">
                                    <span id="txtNombreIcono" class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                    <span id="txtNombreMensaje" class="sr-only">(Este campo es requerido)</span>
                                </div>
                            </div>
                            <div class="form-group has-feedback" id="txtApellidoGrupo">
                                <label for="txtApellido" class="col-lg-3 col-lg-offset-1 control-label">Apellido *</label>
                                <div class="col-lg-5">
                                    <input type="text" name="txtApellido" id="txtApellido" value="<?php print isset($arrInfoUsuario['apellido']) ? $arrInfoUsuario['apellido'] : ''; ?>" class="form-control input-sm" autofocus="autofocus" maxlength="75" required="required" aria-describedby="txtApellidoEstado">
                                    <span id="txtApellidoIcono" class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                    <span id="txtApellidoMensaje" class="sr-only">(Este campo es requerido)</span>
                                </div>
                            </div>
                            <div class="form-group has-feedback" id="txtCuentaGrupo">
                                <label for="txtCuenta" class="col-lg-3 col-lg-offset-1 control-label">Usuario *</label>
                                <div class="col-lg-5">
                                    <input type="text" name="txtCuenta" id="txtCuenta" value="<?php print isset($arrInfoUsuario['usser']) ? $arrInfoUsuario['usser'] : ''; ?>" class="form-control input-sm" maxlength="75" required="required">
                                    <span id="txtCuentaIcono" class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                    <span id="txtCuentaMensaje" class="sr-only">(Este campo es requerido)</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <?php
                                if( $intUsuario == 0 ) {
                                    ?>
                                    <!--label for="chkPasswordAleatoria" class="col-lg-3 col-lg-offset-1 control-label">Generar contraseña aleatoria</label>
                                    <div class="col-lg-5 form-control-static">
                                        <input type="checkbox" name="chkPasswordAleatoria" id="chkPasswordAleatoria" value="1">
                                    </div-->
                                    <?php
                                }
                                else {
                                    ?>
                                    <label for="chkPasswordCambiar" class="col-lg-3 col-lg-offset-1 control-label">Cambiar contraseña</label>
                                    <div class="col-lg-5 form-control-static">
                                        <input type="checkbox" name="chkPasswordCambiar" id="chkPasswordCambiar" value="1">
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <div class="form-group has-feedback" id="txtPasswordGrupo" <?php print $intUsuario == 0 ? "" : "style='display: none'"; ?>>
                                <label for="txtPassword" class="col-lg-3 col-lg-offset-1 control-label">Contraseña *</label>
                                <div class="col-lg-5">
                                    <input type="password" name="txtPassword" id="txtPassword" value="" class="form-control input-sm" maxlength="33" <?php print $intUsuario == 0 ? "required='required'" : ""; ?>>
                                    <span id="txtPasswordIcono" class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                    <span id="txtPasswordMensaje" class="sr-only">(Este campo es requerido)</span>
                                </div>
                            </div>
                            <div class="form-group has-feedback" id="txtConfirmarPasswordGrupo" <?php print $intUsuario == 0 ? "" : "style='display: none'"; ?>>
                                <label for="txtConfirmarPassword" class="col-lg-3 col-lg-offset-1 control-label">Confirmar Contraseña *</label>
                                <div class="col-lg-5">
                                    <input type="password" name="txtConfirmarPassword" id="txtConfirmarPassword" value="" class="form-control input-sm" maxlength="33" <?php print $intUsuario == 0 ? "required='required'" : ""; ?>>
                                    <span id="txtConfirmarPasswordIcono" class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                    <span id="txtConfirmarPasswordMensaje" class="sr-only">(Este campo es requerido)</span>
                                </div>
                            </div>
                            <div class="form-group has-feedback" id="txtEmailGrupo">
                                <label for="txtEmail" class="col-lg-3 col-lg-offset-1 control-label">Correo electrónico *</label>
                                <div class="col-lg-5">
                                    <input type="text" name="txtEmail" id="txtEmail" value="<?php print isset($arrInfoUsuario['email']) ? $arrInfoUsuario['email'] : ''; ?>" class="form-control input-sm" maxlength="255" required="required">
                                    <span id="txtEmailIcono" class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                    <span id="txtEmailMensaje" class="sr-only">(Este campo es requerido)</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="txtDireccion" class="col-lg-3 col-lg-offset-1 control-label">Dirección</label>
                                <div class="col-lg-5">
                                    <textarea name="txtDireccion" id="txtDireccion" class="form-control input-sm"><?php print isset($arrInfoUsuario['direccion']) ? $arrInfoUsuario['direccion'] : ''; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="txtTelefono" class="col-lg-3 col-lg-offset-1 control-label">Teléfono</label>
                                <div class="col-lg-5">
                                    <input type="text" name="txtTelefono" id="txtTelefono" value="<?php print isset($arrInfoUsuario['telefono']) ? $arrInfoUsuario['telefono'] : ''; ?>" class="form-control input-sm" maxlength="255">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="sltTipoUsuario" class="col-lg-3 col-lg-offset-1 control-label">Tipo de usuario</label>
                                <div class="col-lg-5">
                                    <select name="sltTipoUsuario" id="sltTipoUsuario" class="form-control input-sm">
                                        <?php
                                        if( $_SESSION['tipo_usuario'] == 'administrador' ) {
                                            ?>
                                            <option value="administrador" <?php print ( isset($arrInfoUsuario['tipo_usuario']) && $arrInfoUsuario['tipo_usuario'] == 'administrador' ) ? "selected='selected'" : ''; ?>>Administrador</option>
                                            <?php
                                        }
                                        ?>
                                        <option value="normal" <?php print ( isset($arrInfoUsuario['tipo_usuario']) && $arrInfoUsuario['tipo_usuario'] == 'normal' ) ? "selected='selected'" : ''; ?>>Normal</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="chkActivo" class="col-lg-3 col-lg-offset-1 control-label">Activo</label>
                                <div class="col-lg-5 form-control-static">
                                    <input type="checkbox" name="chkActivo" id="chkActivo" value="1" <?php print isset($arrInfoUsuario['activo']) && $arrInfoUsuario['activo'] == 'Y' ? 'checked="checked"' : ($intUsuario == 0 ? 'checked="checked"' : ""); ?>>
                                </div>
                            </div>
                            <div class="form-group" id="txtFirmaGrupo">
                                <label for="txtFirma" class="col-lg-3 col-lg-offset-1 control-label">Firma</label>
                                <div class="col-lg-5">
                                    <input type="hidden" name="hdnFirma" value="<?php print isset($arrInfoUsuario['firma']) ? $arrInfoUsuario['firma'] : ''; ?>" readonly="readonly">
                                    <input type="file" name="strFirma" id="strFirma">
                                </div>
                            </div>
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <strong>Accesos</strong>
                                </div>
                                <div class="panel-body">
                                    <?php

                                    $arrUsuarioPantalla = $this->objModel->getUsuarioPantalla($intUsuario);

                                    $arrInfoModulo = $this->objModel->getInfoModulo();

                                    reset($arrInfoModulo);
                                    while( $arrM = each($arrInfoModulo) ) {
                                        ?>
                                        <div class="row">
                                            <div class="col-sm-12"><strong><?php print $arrM["value"]["nombreModulo"]; ?></strong></div>
                                        </div>
                                        <?php
                                        reset($arrM["value"]["pantallas"]);
                                        while( $arrP = each($arrM["value"]["pantallas"]) ) {
                                            $strChecked = isset($arrUsuarioPantalla[$arrP["key"]]) ? 'checked="checked"' : '';
                                            ?>
                                            <div class="row">
                                                <div class="col-sm-4 text-left">&nbsp;--&nbsp;<input type="checkbox" <?php print $strChecked; ?> name="chkPantalla_<?php print $arrP["key"]; ?>" value="<?php print $arrP["key"]; ?>">&nbsp;<?php print $arrP["value"]["nombrePantalla"]; ?></div>
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                function fntGuardar() {
                    boolCorrecto = true;
                    boolCorrecto = fntCamposRequeridosEach(boolCorrecto);
                    if( boolCorrecto ) {
                        $("#<?php print $strForm; ?>").submit();
                    }

                }

                function fntRegresar() {
                    document.location = "<?php print $strAction; ?>";
                }

                function fntCamposRequeridosChange() {
                    $("[required='required']").change( function() {
                        if( $(this).val().length == 0 ) {
                            $("#"+$(this).attr("name")+"Grupo").removeClass("has-success").addClass("has-error");
                            $("#"+$(this).attr("name")+"Icono").removeClass("glyphicon-ok").addClass("glyphicon-remove");
                            $("#"+$(this).attr("name")+"Mensaje").removeClass("sr-only");
                        }
                        else {
                            $("#"+$(this).attr("name")+"Grupo").removeClass("has-error").addClass("has-success");
                            $("#"+$(this).attr("name")+"Icono").removeClass("glyphicon-remove").addClass("glyphicon-ok");
                            $("#"+$(this).attr("name")+"Mensaje").addClass("sr-only");
                        }
                    });
                }

                function fntCamposRequeridosEach(boolCorrecto) {
                    boolCorrecto = boolCorrecto;
                    $("[required='required']").each( function() {
                        if( $(this).val().length == 0 ) {
                            $("#"+$(this).attr("name")+"Grupo").removeClass("has-success").addClass("has-error");
                            $("#"+$(this).attr("name")+"Icono").removeClass("glyphicon-ok").addClass("glyphicon-remove");
                            $("#"+$(this).attr("name")+"Mensaje").removeClass("sr-only");
                            boolCorrecto = false;
                        }
                        else {
                            $("#"+$(this).attr("name")+"Grupo").removeClass("has-error").addClass("has-success");
                            $("#"+$(this).attr("name")+"Icono").removeClass("glyphicon-remove").addClass("glyphicon-ok");
                            $("#"+$(this).attr("name")+"Mensaje").addClass("sr-only");
                        }
                    });
                    return boolCorrecto;
                }

                $(function() {
                    fntCamposRequeridosChange();
                    $("#txtPassword").val("");
                    $("#txtConfirmarPassword").val("");
                    $("#chkPasswordAleatoria").click(function() {
                        if( $(this).prop("checked") ) {
                            $("#txtPasswordGrupo").hide();
                            $("#txtConfirmarPasswordGrupo").hide();
                            $("#txtPassword").val("").removeAttr("required");
                            $("#txtConfirmarPassword").val("").removeAttr("required");
                            $("#txtConfirmarPasswordGrupo").hide();
                            $("#txtPasswordGrupo").removeClass("has-error").removeClass("has-success");
                            $("#txtPasswordIcono").removeClass("glyphicon-remove").removeClass("glyphicon-ok");
                            $("#txtPasswordMensaje").addClass("sr-only");
                            $("#txtConfirmarPasswordGrupo").removeClass("has-error").removeClass("has-success");
                            $("#txtConfirmarPasswordIcono").removeClass("glyphicon-remove").removeClass("glyphicon-ok");
                            $("#txtConfirmarPasswordMensaje").addClass("sr-only");
                            fntCamposRequeridosChange();
                        }
                        else {
                            $("#txtPassword").val("").attr("required","required");
                            $("#txtConfirmarPassword").val("").attr("required","required");
                            $("#txtPasswordGrupo").show();
                            $("#txtConfirmarPasswordGrupo").show();
                            fntCamposRequeridosChange();
                        }
                    });
                    $("#chkPasswordCambiar").click(function() {
                        if( $(this).prop("checked") ) {
                            $("#txtPassword").val("").attr("required","required");
                            $("#txtConfirmarPassword").val("").attr("required","required");
                            $("#txtPasswordGrupo").show();
                            $("#txtConfirmarPasswordGrupo").show();
                            fntCamposRequeridosChange();
                        }
                        else {
                            $("#txtPasswordGrupo").hide();
                            $("#txtConfirmarPasswordGrupo").hide();
                            $("#txtPassword").val("").removeAttr("required");
                            $("#txtConfirmarPassword").val("").removeAttr("required");
                            $("#txtConfirmarPasswordGrupo").hide();
                            $("#txtPasswordGrupo").removeClass("has-error").removeClass("has-success");
                            $("#txtPasswordIcono").removeClass("glyphicon-remove").removeClass("glyphicon-ok");
                            $("#txtPasswordMensaje").addClass("sr-only");
                            $("#txtConfirmarPasswordGrupo").removeClass("has-error").removeClass("has-success");
                            $("#txtConfirmarPasswordIcono").removeClass("glyphicon-remove").removeClass("glyphicon-ok");
                            $("#txtConfirmarPasswordMensaje").addClass("sr-only");
                            fntCamposRequeridosChange();
                        }
                    });
                });
            </script>
        </div>
        </form>
        <?php

    }

}