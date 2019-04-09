<?php
require_once("configuracion_profesion_model.php");

class configuracion_profesion_view {

    public $objModel;
    public $strAlertaTipo = "";

    function __construct() {
        $this->objModel = new configuracion_profesion_model();
    }

    public function drawContent(){
        global $lang, $strAction, $objTemplate;
        $strForm = 'frmProfesion';

        $boolAlertaEliminar = isset($_GET["strAlert"]) && $_GET["strAlert"] == "del" ? true : false;
        $boolAlertaCreada = isset($_GET["strAlert"]) && $_GET["strAlert"] == "ins" ? true : false;
        $boolAlertaModificada = isset($_GET["strAlert"]) && $_GET["strAlert"] == "upd" ? true : false;
        ?>
        <form name="<?php print  $strForm; ?>" id="<?php print $strForm; ?>" method="post" action="<?php print $strAction; ?>" class="form-horizontal">
            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <ol class="breadcrumb">
                            <li><a href="index.php">Inicio</a></li>
                            <li><a href="<?php print $strAction; ?>" class="active">Profesión</a></li>
                        </ol>
                    </div>
                    <?php
                    if( $boolAlertaEliminar ) {
                        ?>
                        <div class="col-lg-4 col-lg-offset-4">
                            <div class="alert alert-warning">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <span class="glyphicon glyphicon-warning-sign"></span>&nbsp;<strong>Aviso:</strong>&nbsp;Profesión eliminada.
                            </div>
                        </div>
                        <?php
                    }
                    if( $boolAlertaCreada ) {
                        ?>
                        <div class="col-lg-5 col-lg-offset-3">
                            <div class="alert alert-success">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <span class="glyphicon glyphicon-info-sign"></span>&nbsp;<strong>información:</strong>&nbsp;Profesión creada exitosamente.
                            </div>
                        </div>
                        <?php
                    }
                    if( $boolAlertaModificada ) {
                        ?>
                        <div class="col-lg-5 col-lg-offset-3">
                            <div class="alert alert-info">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <span class="glyphicon glyphicon-info-sign"></span>&nbsp;<strong>información:</strong>&nbsp;Profesión modificada exitosamente.
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <button type="button" class="btn btn-primary btn-sm" onclick="fntNuevaProfesion();">
                                    <span class="glyphicon glyphicon-plus"></span>&nbsp;Nueva profesión
                                </button>
                                <script>
                                    function fntNuevaProfesion() {
                                        document.location = "<?php print $strAction; ?>?profesion=0";
                                    }
                                    function fntEditarProfesion(intProfesion) {
                                        document.location = "<?php print $strAction; ?>?profesion="+intProfesion;
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
                                            <th width="35%">&nbsp;&nbsp;Nombre&nbsp;&nbsp;</th>
                                            <th width="40%">&nbsp;&nbsp;Descripción&nbsp;&nbsp;</th>
                                            <th width="10%" class="text-center">Activo</th>
                                            <th width="10%" class="text-center">&nbsp;Acción&nbsp;</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $arrListadoProfesion = $this->objModel->getListadoProfesion();

                                        while( $rTMP = each($arrListadoProfesion) ) {
                                            ?>
                                            <tr>
                                                <td class="text-center"><a href="<?php print $strAction; ?>?profesion=<?php print $rTMP["key"]; ?>"><?php print $rTMP["key"]; ?></a></td>
                                                <td><?php print $rTMP["value"]["nombre"]; ?></td>
                                                <td><?php print $rTMP["value"]["descripcion"]; ?></td>
                                                <td class="text-center"><?php print $rTMP["value"]["activo"] == 'Y' ? 'Si' : 'No'; ?></td>
                                                <td class=" text-center">
                                                    <button type="button" class="btn btn-info btn-xs" onclick="fntEditarProfesion(<?php print $rTMP["key"]; ?>);" data-toggle="tooltip" data-placement="bottom" title="Editar profesión">
                                                        <span class="glyphicon glyphicon-pencil"></span>
                                                    </button>
                                                    <!--button type="button" class="btn btn-danger btn-xs" onclick="fntEliminarProfesion(<?php print $rTMP["key"]; ?>, '<?php print $rTMP["value"]["nombre"]; ?>', true);" data-toggle="tooltip" data-placement="bottom" title="Eliminar profesión">
                                                        <span class="glyphicon glyphicon-trash"></span>
                                                    </button-->
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
                        <h4 class="modal-title">Eliminar profesión</h4>
                    </div>
                    <div class="modal-body" id="divEliminarModalBody">
                        ¿Está seguro?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" onclick="fntEliminarProfesion(0,'', false)">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            function fntEliminarProfesion(intProfesion, strTexto, boolConfirmar) {

                if( intProfesion > 0 ) {
                    $("#hdnEliminar").val(intProfesion);
                }
                if( strTexto.length > 0 ) {
                    $("#divEliminarModalBody").html('¿Está seguro de eliminar la profesión <i>"'+strTexto+'"</i>?');
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

    public function drawContentProfesion($intProfesion){
        global $lang, $strAction, $objTemplate;

        $strForm = 'frmProfesion';

        $arrInfoProfesion = $this->objModel->getInfoProfesion($intProfesion);

        ?>
        <form name="<?php print  $strForm; ?>" id="<?php print $strForm; ?>" method="post" action="<?php print $strAction; ?>" class="form-horizontal">
            <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <ol class="breadcrumb">
                        <li><a href="index.php">Inicio</a></li>
                        <li><a href="<?php print $strAction; ?>">Profesión</a></li>
                        <li class="active"><?php print isset($arrInfoProfesion['nombre']) ? $arrInfoProfesion['nombre'] : 'Nueva profesión'; ?></li>
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
                            <input type="hidden" name="hdnProfesion" value="<?php print $intProfesion; ?>" readonly="readonly">
                            <div class="form-group has-feedback" id="txtNombreGrupo">
                                <label for="txtNombre" class="col-lg-3 col-lg-offset-1 control-label">Nombre *</label>
                                <div class="col-lg-5">
                                    <input type="text" name="txtNombre" id="txtNombre" value="<?php print isset($arrInfoProfesion['nombre']) ? $arrInfoProfesion['nombre'] : ''; ?>" class="form-control input-sm" autofocus="autofocus" maxlength="75" required="required" aria-describedby="txtNombre">
                                    <span id="txtNombreIcono" class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                    <span id="txtNombreMensaje" class="sr-only">(Este campo es requerido)</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="txtDescripcion" class="col-lg-3 col-lg-offset-1 control-label">Descripción</label>
                                <div class="col-lg-5">
                                    <textarea name="txtDescripcion" id="txtDescripcion" class="form-control input-sm"><?php print isset($arrInfoProfesion['descripcion']) ? $arrInfoProfesion['descripcion'] : ''; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="chkActivo" class="col-lg-3 col-lg-offset-1 control-label">Activo</label>
                                <div class="col-lg-5 form-control-static">
                                    <input type="checkbox" name="chkActivo" id="chkActivo" value="1" <?php print isset($arrInfoProfesion['activo']) && $arrInfoProfesion['activo'] == 'Y' ? 'checked="checked"' : ''; ?>>
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
                });
            </script>
        </div>
        </form>
        <?php

    }

}