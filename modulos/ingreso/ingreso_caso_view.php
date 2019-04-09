<?php
require_once("ingreso_caso_model.php");

class ingreso_caso_view {
    
    public $objModel;
    public $strAlertaTipo = "";

    function __construct() {
        $this->objModel = new ingreso_caso_model();
    }

    public function drawContent(){
        global $lang, $strAction, $objTemplate;
        $strForm = 'frmCaso';

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
                            <li><a href="<?php print $strAction; ?>" class="active">Casos</a></li>
                        </ol>
                    </div>
                    <?php
                    if( $boolAlertaEliminar ) {
                        ?>
                        <div class="col-lg-4 col-lg-offset-4">
                            <div class="alert alert-warning">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <span class="glyphicon glyphicon-warning-sign"></span>&nbsp;<strong>Aviso:</strong>&nbsp;Caso eliminado.
                            </div>
                        </div>
                        <?php
                    }
                    if( $boolAlertaCreada ) {
                        ?>
                        <div class="col-lg-5 col-lg-offset-3">
                            <div class="alert alert-success">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <span class="glyphicon glyphicon-info-sign"></span>&nbsp;<strong>información:</strong>&nbsp;Caso creado exitosamente.
                            </div>
                        </div>
                        <?php
                    }
                    if( $boolAlertaModificada ) {
                        ?>
                        <div class="col-lg-5 col-lg-offset-3">
                            <div class="alert alert-info">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <span class="glyphicon glyphicon-info-sign"></span>&nbsp;<strong>información:</strong>&nbsp;Caso modificado exitosamente.
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <button type="button" class="btn btn-primary btn-sm" onclick="fntNuevoCaso();">
                                    <span class="glyphicon glyphicon-plus"></span>&nbsp;Nuevo caso
                                </button>
                                <script>
                                    function fntNuevoCaso() {
                                        document.location = "<?php print $strAction; ?>?caso=0";
                                    }
                                    function fntEditarCaso(intCaso) {
                                        document.location = "<?php print $strAction; ?>?caso="+intCaso;
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
                                            <th width="35%">&nbsp;&nbsp;No. caso&nbsp;&nbsp;</th>
                                            <th width="40%">&nbsp;&nbsp;Estado caso&nbsp;&nbsp;</th>
                                            <th width="10%" class="text-center">Tipo caso</th>
                                            <th width="10%" class="text-center">Acción</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $arrListadoCasos = $this->objModel->getListadoCasos();

                                        while( $rTMP = each($arrListadoCasos) ) {
                                            ?>
                                            <tr>
                                                <td class="text-center"><a href="<?php print $strAction; ?>?caso=<?php print $rTMP["key"]; ?>"><?php print $rTMP["key"]; ?></a></td>
                                                <td><?php print $rTMP["value"]["no_caso"]; ?></td>
                                                <td class="text-center"><?php print $rTMP["value"]["estado_caso"] == 'proceso' ? 'En proceso' : ($rTMP["value"]["estado_caso"] == 'finalizado' ? "Finalizado" : ""); ?></td>
                                                <td class="text-center"><?php print $rTMP["value"]["tipo_caso"] == 'secuestro' ? 'Secuestro' : ($rTMP["value"]["tipo_caso"] == '' ? "" : ""); ?></td>
                                                <td class=" text-center">
                                                    <button type="button" class="btn btn-info btn-xs" onclick="fntEditarCaso(<?php print $rTMP["key"]; ?>);" data-toggle="tooltip" data-placement="bottom" title="Editar caso">
                                                        <span class="glyphicon glyphicon-pencil"></span>
                                                    </button>
                                                    <!--button type="button" class="btn btn-danger btn-xs" onclick="fntEliminarDelito(<?php print $rTMP["key"]; ?>, '<?php print $rTMP["value"]["no_caso"]; ?>', true);" data-toggle="tooltip" data-placement="bottom" title="Eliminar usuario">
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
                        <h4 class="modal-title">Eliminar caso</h4>
                    </div>
                    <div class="modal-body" id="divEliminarModalBody">
                        ¿Está seguro?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" onclick="fntEliminarCaso(0,'', false)">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            function fntEliminarCaso(intCaso, strTexto, boolConfirmar) {

                if( intCaso > 0 ) {
                    $("#hdnEliminar").val(intCaso);
                }
                if( strTexto.length > 0 ) {
                    $("#divEliminarModalBody").html('¿Está seguro de eliminar el caso No. <i>"'+strTexto+'"</i>?');
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

    public function drawContentCaso($intCaso){
        global $lang, $strAction, $objTemplate;

        $strForm = 'frmCaso';

        $arrInfoCaso = $this->objModel->getInfoCaso($intCaso);

        ?>
        <form name="<?php print  $strForm; ?>" id="<?php print $strForm; ?>" method="post" action="<?php print $strAction; ?>" class="form-horizontal" enctype="multipart/form-data">
            <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <ol class="breadcrumb">
                        <li><a href="index.php">Inicio</a></li>
                        <li><a href="<?php print $strAction; ?>">Usuarios</a></li>
                        <li class="active"><?php print isset($arrInfoCaso['no_caso']) ? $arrInfoCaso['no_caso'] : 'Caso nuevo'; ?></li>
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
                            <input type="hidden" name="hdnCaso" value="<?php print $intCaso; ?>" readonly="readonly">
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#principal" aria-controls="principal" role="tab" data-toggle="tab">Información principal</a></li>
                                <li role="presentation"><a href="#denunciante" aria-controls="denunciante" role="tab" data-toggle="tab">Denunciante</a></li>
                                <li role="presentation"><a href="#victima" aria-controls="victima" role="tab" data-toggle="tab">Víctima</a></li>
                                <li role="presentation"><a href="#detenidos" aria-controls="detenidos" role="tab" data-toggle="tab">Detenidos</a></li>
                                <li role="presentation"><a href="#incautaciones" aria-controls="incautaciones" role="tab" data-toggle="tab">Incautaciones</a></li>
                            </ul>
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="principal">
                                    <div class="form-group">
                                        <div class="col-lg-12">&nbsp;</div>
                                    </div>
                                    <div class="form-group">
                                        <label for="sltTipoCaso" class="col-lg-3 col-lg-offset-1 control-label" style="text-align: right;">Tipo de caso</label>
                                        <div class="col-lg-4" style="padding-left: 0px;">
                                            <select name="sltTipoCaso" id="sltTipoCaso" class="form-control input-sm">
                                                <option value="secuestro" <?php print ( isset($arrInfoCaso['tipo_caso']) && $arrInfoCaso['tipo_caso'] == 'secuestro' ) ? "selected='selected'" : ''; ?>>Secuestro</option>
                                                <option value="fallecido_lesionado" <?php print ( isset($arrInfoCaso['tipo_caso']) && $arrInfoCaso['tipo_caso'] == 'fallecido_lesionado' ) ? "selected='selected'" : ''; ?>>Fallecido o lesionado</option>
                                                <option value="aprehendido_allanamiento" <?php print ( isset($arrInfoCaso['tipo_caso']) && $arrInfoCaso['tipo_caso'] == 'aprehendido_allanamiento' ) ? "selected='selected'" : ''; ?>>Aprehendido o allanamiento</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-6">
                                            <div class="form-group has-feedback">
                                                <label for="txtNoCaso" class="col-lg-4" style="text-align: right;">No. de caso *</label>
                                                <div class="col-lg-5" style="padding-left: 0px;">
                                                    <input type="text" name="txtNoCaso" id="txtNoCaso" value="<?php print isset($arrInfoCaso['no_caso']) ? $arrInfoCaso['no_caso'] : ''; ?>" class="form-control input-sm" autofocus="autofocus" maxlength="75" required="required" aria-describedby="txtNoCaso">
                                                    <span id="txtNoCasoIcono" class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                                    <span id="txtNoCasoMensaje" class="sr-only">(Este campo es requerido)</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="sltAreaHecho" class="col-lg-4 control-label" style="text-align: right;">Área del hecho</label>
                                                <div class="col-lg-5" style="padding-left: 0px;">
                                                    <select name="sltAreaHecho" id="sltAreaHecho" class="form-control input-sm">
                                                        <option value="rural" <?php print ( isset($arrInfoCaso['area_hecho']) && $arrInfoCaso['area_hecho'] == 'rural' ) ? "selected='selected'" : ''; ?>>Rural</option>
                                                        <option value="urbana" <?php print ( isset($arrInfoCaso['area_hecho']) && $arrInfoCaso['area_hecho'] == 'urbana' ) ? "selected='selected'" : ''; ?>>Urbana</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="sltProcedencia" class="col-lg-4 control-label" style="text-align: right;">Procedencia</label>
                                                <div class="col-lg-5" style="padding-left: 0px;">
                                                    <select name="sltProcedencia" id="sltProcedencia" class="form-control input-sm">
                                                        <option value="pnc" <?php print ( isset($arrInfoCaso['procedencia']) && $arrInfoCaso['procedencia'] == 'pnc' ) ? "selected='selected'" : ''; ?>>PNC</option>
                                                        <option value="deic" <?php print ( isset($arrInfoCaso['procedencia']) && $arrInfoCaso['procedencia'] == 'deic' ) ? "selected='selected'" : ''; ?>>DEIC</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="sltEstadoCaso" class="col-lg-4 control-label" style="text-align: right;">Estado de caso</label>
                                                <div class="col-lg-5" style="padding-left: 0px;">
                                                    <select name="sltEstadoCaso" id="sltEstadoCaso" class="form-control input-sm">
                                                        <option value="fase_investigacion" <?php print ( isset($arrInfoCaso['estado_caso']) && $arrInfoCaso['estado_caso'] == 'fase_investigacion' ) ? "selected='selected'" : ''; ?>>Fase de investigación</option>
                                                        <option value="concluido" <?php print ( isset($arrInfoCaso['estado_caso']) && $arrInfoCaso['estado_caso'] == 'concluido' ) ? "selected='selected'" : ''; ?>>Concluido</option>
                                                        <option value="archivado" <?php print ( isset($arrInfoCaso['estado_caso']) && $arrInfoCaso['estado_caso'] == 'archivado' ) ? "selected='selected'" : ''; ?>>Archivado</option>
                                                        <option value="desestimado" <?php print ( isset($arrInfoCaso['estado_caso']) && $arrInfoCaso['estado_caso'] == 'desestimado' ) ? "selected='selected'" : ''; ?>>Desestimado</option>
                                                        <option value="con_sindicados" <?php print ( isset($arrInfoCaso['estado_caso']) && $arrInfoCaso['estado_caso'] == 'con_sindicados' ) ? "selected='selected'" : ''; ?>>Con sindicados</option>
                                                        <option value="con_detenidos" <?php print ( isset($arrInfoCaso['estado_caso']) && $arrInfoCaso['estado_caso'] == 'con_detenidos' ) ? "selected='selected'" : ''; ?>>Con detenidos</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="sltComisaria" class="col-lg-6 control-label" style="text-align: right;">Comisaría *</label>
                                                <div class="col-lg-6" style="padding-left: 0px;">
                                                    <select name="sltComisaria" id="sltComisaria" class="form-control input-sm">
                                                        <?php
                                                        $intComisaria = isset($arrInfoCaso['comisaria']) ? $arrInfoCaso['comisaria'] : 0;
                                                        $arrComisarias = $this->objModel->getComisarias($intComisaria);
                                                        while($arrC = each($arrComisarias)){
                                                            ?>
                                                            <option value="<?php echo $arrC["key"]; ?>" <?php print ( isset($arrC["value"]['selected']) && $arrC["value"]['selected'] == true ) ? "selected='selected'" : ''; ?>><?php echo $arrC["value"]['texto']; ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <span id="sltComisariaMensaje" class="sr-only">(Este campo es requerido)</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="sltEstacion" class="col-lg-6 control-label" style="text-align: right;">Estación *</label>
                                                <div class="col-lg-6" style="padding-left: 0px;">
                                                    <select name="sltEstacion" id="sltEstacion" class="form-control input-sm">
                                                        <?php
                                                        $intEstacion = isset($arrInfoCaso['estacion']) ? $arrInfoCaso['estacion'] : 0;
                                                        $arrEstacion = $this->objModel->getEstaciones($intComisaria, $intEstacion);
                                                        while($arrE = each($arrEstacion)){
                                                            ?>
                                                            <option value="<?php echo $arrE["key"]; ?>" <?php print ( isset($arrE["value"]['selected']) && $arrE["value"]['selected'] == true ) ? "selected='selected'" : ''; ?>><?php echo $arrE["value"]['texto']; ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <span id="sltEstacionMensaje" class="sr-only">(Este campo es requerido)</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="sltSubEstacion" class="col-lg-6 control-label" style="text-align: right;">Sub Estación *</label>
                                                <div class="col-lg-6" style="padding-left: 0px;">
                                                    <select name="sltSubEstacion" id="sltSubEstacion" class="form-control input-sm">
                                                        <?php
                                                        $intSubEstacion = isset($arrInfoCaso['subestacion']) ? $arrInfoCaso['subestacion'] : 0;
                                                        $arrSubEstacion = $this->objModel->getSubEstaciones($intComisaria, $intEstacion, $intSubEstacion);
                                                        while($arrS = each($arrSubEstacion)){
                                                            ?>
                                                            <option value="<?php echo $arrS["key"]; ?>" <?php print ( isset($arrS["value"]['selected']) && $arrS["value"]['selected'] == true ) ? "selected='selected'" : ''; ?>><?php echo $arrS["value"]['texto']; ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <span id="sltEstacionMensaje" class="sr-only">(Este campo es requerido)</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-6">
                                            <div class="form-group has-feedback">
                                                <label for="txtFechaHecho" class="col-lg-4 control-label" style="text-align: right;">Fecha del hecho</label>
                                                <div class='input-group date col-lg-5' id='divFechaHecho'>
                                                    <input id="txtFechaHecho" type='text' value="<?php echo isset($arrInfoCaso['fecha_hecho']) ? $arrInfoCaso['fecha_hecho'] : '';?>" class="form-control"/>
                                                    <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group has-feedback">
                                                <label for="txtFechaIngreso" class="col-lg-4 control-label" style="text-align: right;">Fecha de ingreso</label>
                                                <div class='input-group date col-lg-5' id='divFechaIngreso'>
                                                    <input id="txtFechaIngreso type='text' value="<?php echo isset($arrInfoCaso['fecha_ingreso']) ? $arrInfoCaso['fecha_ingreso'] : '';?>" class="form-control"/>
                                                    <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" id="divDenunciaLiberacion">
                                        <div class="col-lg-6">
                                            <div class="form-group has-feedback">
                                                <label for="txtFechaDenuncia" class="col-lg-4 control-label" style="text-align: right;">Fecha de denuncia</label>
                                                <div class='input-group date col-lg-5' id='divFechaDenuncia'>
                                                    <input id="txtFechaDenuncia" type='text' value="<?php echo isset($arrInfoCaso['fecha_denuncia']) ? $arrInfoCaso['fecha_denuncia'] : '';?>" class="form-control"/>
                                                    <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group has-feedback">
                                                <label for="txtFechaLiberacion" class="col-lg-4 control-label" style="text-align: right;">Fecha de liberación</label>
                                                <div class='input-group date col-lg-5' id='divFechaLiberacion'>
                                                    <input id="txtFechaLiberacion type='text' value="<?php echo isset($arrInfoCaso['fecha_liberacion']) ? $arrInfoCaso['fecha_liberacion'] : '';?>" class="form-control"/>
                                                    <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="sltDelitos" class="col-lg-4 control-label" style="text-align: right;">Delitos *</label>
                                                <div class="col-lg-5" style="padding-left: 0px;">
                                                    <select name="sltDelitos" id="sltDelitos" class="form-control input-sm" multiple="multiple">
                                                        <?php
                                                        $arrDelitosCaso = $this->objModel->getDelitosCaso($arrInfoCaso["caso"]);
                                                        $arrDelitos = $this->objModel->getDelitos();
                                                        while($arrC = each($arrDelitos)){
                                                            ?>
                                                            <option value="<?php echo $arrC["key"]; ?>" <?php print array_key_exists($arrDelitosCaso["key"],$arrDelitos) ? "selected='selected'" : ''; ?>><?php echo $arrC["value"]['texto']; ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <span id="sltDelitosMensaje" class="sr-only">(Este campo es requerido)</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="sltCausa" class="col-lg-4 control-label" style="text-align: right;">Causa *</label>
                                                <div class="col-lg-5" style="padding-left: 0px;">
                                                    <select name="sltCausa" id="sltCausa" class="form-control input-sm">
                                                        <?php
                                                        $intCausa = isset($arrInfoCaso['causa']) ? $arrInfoCaso['causa'] : 0;
                                                        $arrCausas = $this->objModel->getCausas($intCausa);
                                                        while($arrC = each($arrCausas)){
                                                            ?>
                                                            <option value="<?php echo $arrC["key"]; ?>" <?php print ( isset($arrC["value"]['selected']) && $arrC["value"]['selected'] == true ) ? "selected='selected'" : ''; ?>><?php echo $arrC["value"]['texto']; ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <span id="sltCausaMensaje" class="sr-only">(Este campo es requerido)</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="sltMovilHecho" class="col-lg-4 control-label" style="text-align: right;">Móvil del hecho *</label>
                                                <div class="col-lg-5" style="padding-left: 0px;">
                                                    <select name="sltMovilHecho" id="sltMovilHecho" class="form-control input-sm">
                                                        <?php
                                                        $intMovilHecho = isset($arrInfoCaso['movil_hecho']) ? $arrInfoCaso['movil_hecho'] : 0;
                                                        $arrMovilHecho = $this->objModel->getMovilHecho($intMovilHecho);
                                                        while($arrM = each($arrMovilHecho)){
                                                            ?>
                                                            <option value="<?php echo $arrM["key"]; ?>" <?php print ( isset($arrM["value"]['selected']) && $arrM["value"]['selected'] == true ) ? "selected='selected'" : ''; ?>><?php echo $arrM["value"]['texto']; ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <span id="sltMovilHechoMensaje" class="sr-only">(Este campo es requerido)</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" id="divDireccionHecho">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="txtDireccionHecho" class="col-lg-6 control-label" style="text-align: right;">Dirección del hecho *</label>
                                                <div class="col-lg-6" style="padding-left: 0px;">
                                                    <input type="text" name="txtDireccionHecho" id="txtDireccionHecho" value="<?php print isset($arrInfoCaso['direccion_hecho']) ? $arrInfoCaso['direccion_hecho'] : ''; ?>" class="form-control input-sm" autofocus="autofocus" maxlength="200" required="required" aria-describedby="txtDireccionHecho">
                                                    <span id="txtDireccionHechoMensaje" class="sr-only">(Este campo es requerido)</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="sltDepartamentoHecho" class="col-lg-6 control-label" style="text-align: right;">Departamento del hecho *</label>
                                                <div class="col-lg-6" style="padding-left: 0px;">
                                                    <select name="sltDepartamentoHecho" id="sltDepartamentoHecho" class="form-control input-sm">
                                                        <?php
                                                        $intDepartamento = isset($arrInfoCaso['departamento_hecho']) ? $arrInfoCaso['departamento_hecho'] : 0;
                                                        $arrDepartamento = $this->objModel->getDepartamentos($intDepartamento);
                                                        while($arrD = each($arrDepartamento)){
                                                            ?>
                                                            <option value="<?php echo $arrD["key"]; ?>" <?php print ( isset($arrD["value"]['selected']) && $arrD["value"]['selected'] == true ) ? "selected='selected'" : ''; ?>><?php echo $arrD["value"]['texto']; ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <span id="sltDepartamentoHechoMensaje" class="sr-only">(Este campo es requerido)</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="sltMunicipioHecho" class="col-lg-6 control-label" style="text-align: right;">Municipio del hecho *</label>
                                                <div class="col-lg-6" style="padding-left: 0px;">
                                                    <select name="sltMunicipioHecho" id="sltMunicipioHecho" class="form-control input-sm">
                                                        <?php
                                                        $intMunicipio = isset($arrInfoCaso['municipio_hecho']) ? $arrInfoCaso['municipio_hecho'] : 0;
                                                        $arrMunicipio = $this->objModel->getMunicipios($intDepartamento, $intMunicipio);
                                                        while($arrM = each($arrMunicipio)){
                                                            ?>
                                                            <option value="<?php echo $arrM["key"]; ?>" <?php print ( isset($arrM["value"]['selected']) && $arrM["value"]['selected'] == true ) ? "selected='selected'" : ''; ?>><?php echo $arrM["value"]['texto']; ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <span id="sltMunicipioHechoMensaje" class="sr-only">(Este campo es requerido)</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" id="divDireccionSecuestro">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="txtDireccionSecuestro" class="col-lg-6 control-label" style="text-align: right;">Dirección del secuestro *</label>
                                                <div class="col-lg-6" style="padding-left: 0px;">
                                                    <input type="text" name="txtDireccionSecuestro" id="txtDireccionSecuestro" value="<?php print isset($arrInfoCaso['direccion_secuestro']) ? $arrInfoCaso['direccion_secuestro'] : ''; ?>" class="form-control input-sm" autofocus="autofocus" maxlength="200" required="required" aria-describedby="txtDireccionSecuestro">
                                                    <span id="txtDireccionSecuestroMensaje" class="sr-only">(Este campo es requerido)</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="sltDepartamentoSecuestro" class="col-lg-6 control-label" style="text-align: right;">Departamento del secuestro *</label>
                                                <div class="col-lg-6" style="padding-left: 0px;">
                                                    <select name="sltDepartamentoSecuestro" id="sltDepartamentoSecuestro" class="form-control input-sm">
                                                        <?php
                                                        $intDepartamento = isset($arrInfoCaso['departamento_secuestro']) ? $arrInfoCaso['departamento_secuestro'] : 0;
                                                        $arrDepartamento = $this->objModel->getDepartamentos($intDepartamento);
                                                        while($arrD = each($arrDepartamento)){
                                                            ?>
                                                            <option value="<?php echo $arrD["key"]; ?>" <?php print ( isset($arrD["value"]['selected']) && $arrD["value"]['selected'] == true ) ? "selected='selected'" : ''; ?>><?php echo $arrD["value"]['texto']; ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <span id="sltDepartamentoSecuestroMensaje" class="sr-only">(Este campo es requerido)</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="sltMunicipioSecuestro" class="col-lg-6 control-label" style="text-align: right;">Municipio del secuestro *</label>
                                                <div class="col-lg-6" style="padding-left: 0px;">
                                                    <select name="sltMunicipioSecuestro" id="sltMunicipioSecuestro" class="form-control input-sm">
                                                        <?php
                                                        $intMunicipio = isset($arrInfoCaso['municipio_secuestro']) ? $arrInfoCaso['municipio_secuestro'] : 0;
                                                        $arrMunicipio = $this->objModel->getMunicipios($intDepartamento, $intMunicipio);
                                                        while($arrM = each($arrMunicipio)){
                                                            ?>
                                                            <option value="<?php echo $arrM["key"]; ?>" <?php print ( isset($arrM["value"]['selected']) && $arrM["value"]['selected'] == true ) ? "selected='selected'" : ''; ?>><?php echo $arrM["value"]['texto']; ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <span id="sltMunicipioSecuestroMensaje" class="sr-only">(Este campo es requerido)</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" id="divDireccionCautiverio">
                                        <div class="col-lg-12">
                                            <div class="table-responsive">
                                                <table id="tblDireccionCautiverio" class="table table-bordered">
                                                    <thead>
                                                        <tr style="background-color: #428bca; color: #fff;">
                                                            <td>Dirección del cautiverio</td>
                                                            <td>Departamento del cautiverio</td>
                                                            <td>Municipio del cautiverio</td>
                                                            <td>&nbsp;</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $intCorrelativoDireccionCautiverio = 1;
                                                        $intCaso = isset($arrInfoCaso["caso"]) ? $arrInfoCaso["caso"] : 0;
                                                        $arrInfoDireccionCautiverio = $this->objModel->getDireccionCautiverio($intCaso);
                                                        while($arrIDC = each($arrInfoDireccionCautiverio)){
                                                            ?>
                                                            <tr>
                                                                <td>
                                                                    <input type="text" name="txtDireccionCautiverio_<?php echo $intCorrelativoDireccionCautiverio; ?>" id="txtDireccionCautiverio_<?php echo $intCorrelativoDireccionCautiverio; ?>" value="<?php print isset($arrIDC['direccion']) ? $arrIDC['direccion'] : ''; ?>" class="form-control input-sm" autofocus="autofocus" maxlength="200" required="required" aria-describedby="txtDireccionCautiverio_<?php echo $intCorrelativoDireccionCautiverio; ?>">
                                                                    <span id="txtDireccionCautiverioMensaje_<?php echo $intCorrelativoDireccionCautiverio; ?>" class="sr-only">(Este campo es requerido)</span>
                                                                </td>
                                                                <td>
                                                                    <select name="sltDepartamentoCautiverio_<?php echo $intCorrelativoDireccionCautiverio; ?>" id="sltDepartamentoCautiverio_<?php echo $intCorrelativoDireccionCautiverio; ?>" class="form-control input-sm">
                                                                        <?php
                                                                        $intDepartamento = isset($arrIDC['departamento']) ? $arrIDC['departamento'] : 0;
                                                                        $arrDepartamento = $this->objModel->getDepartamentos($intDepartamento);
                                                                        while($arrD = each($arrDepartamento)){
                                                                            ?>
                                                                            <option value="<?php echo $arrD["key"]; ?>" <?php print ( isset($arrD["value"]['selected']) && $arrD["value"]['selected'] == true ) ? "selected='selected'" : ''; ?>><?php echo $arrD["value"]['texto']; ?></option>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                    <span id="sltDepartamentoCautiverioMensaje_<?php echo $intCorrelativoDireccionCautiverio; ?>" class="sr-only">(Este campo es requerido)</span>
                                                                </td>
                                                                <td>
                                                                    <select name="sltMunicipioCautiverio_<?php echo $intCorrelativoDireccionCautiverio; ?>" id="sltMunicipioCautiverio_<?php echo $intCorrelativoDireccionCautiverio; ?>" class="form-control input-sm">
                                                                        <?php
                                                                        $intMunicipio = isset($arrIDC['municipio']) ? $arrIDC['municipio'] : 0;
                                                                        $arrMunicipio = $this->objModel->getMunicipios($intDepartamento, $intMunicipio);
                                                                        while($arrM = each($arrMunicipio)){
                                                                            ?>
                                                                            <option value="<?php echo $arrM["key"]; ?>" <?php print ( isset($arrM["value"]['selected']) && $arrM["value"]['selected'] == true ) ? "selected='selected'" : ''; ?>><?php echo $arrM["value"]['texto']; ?></option>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                    <span id="sltMunicipioCautiverioMensaje_<?php echo $intCorrelativoDireccionCautiverio; ?>" class="sr-only">(Este campo es requerido)</span>
                                                                </td>
                                                                <td>
                                                                    <button type="button" class="btn btn-danger btn-xs" onclick="fntEliminarDireccionCautiverio(this);" data-toggle="tooltip" data-placement="bottom" title="Eliminar dirección cautiverio">
                                                                        <span class="glyphicon glyphicon-trash"></span>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                            $intCorrelativoDireccionCautiverio++;
                                                        }
                                                        ?>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="4">
                                                                <span class="glyphicon glyphicon-plus" style="cursor: pointer;" onclick="fntaddDireccionCautiverio();"><b>Agregar dirección de cautiverio</b></span>
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" id="divDireccionLiberacion">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="txtDireccionLiberacion" class="col-lg-6 control-label" style="text-align: right;">Dirección de la liberación *</label>
                                                <div class="col-lg-6" style="padding-left: 0px;">
                                                    <input type="text" name="txtDireccionLiberacion" id="txtDireccionLiberacion" value="<?php print isset($arrInfoCaso['direccion_liberacion']) ? $arrInfoCaso['direccion_liberacion'] : ''; ?>" class="form-control input-sm" autofocus="autofocus" maxlength="200" required="required" aria-describedby="txtDireccionLiberacion">
                                                    <span id="txtDireccionLiberacionMensaje" class="sr-only">(Este campo es requerido)</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="sltDepartamentoLiberacion" class="col-lg-6 control-label" style="text-align: right;">Departamento de la liberación *</label>
                                                <div class="col-lg-6" style="padding-left: 0px;">
                                                    <select name="sltDepartamentoLiberacion" id="sltDepartamentoLiberacion" class="form-control input-sm">
                                                        <?php
                                                        $intDepartamento = isset($arrInfoCaso['departamento_liberacion']) ? $arrInfoCaso['departamento_liberacion'] : 0;
                                                        $arrDepartamento = $this->objModel->getDepartamentos($intDepartamento);
                                                        while($arrD = each($arrDepartamento)){
                                                            ?>
                                                            <option value="<?php echo $arrD["key"]; ?>" <?php print ( isset($arrD["value"]['selected']) && $arrD["value"]['selected'] == true ) ? "selected='selected'" : ''; ?>><?php echo $arrD["value"]['texto']; ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <span id="sltDepartamentoLiberacionMensaje" class="sr-only">(Este campo es requerido)</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="sltMunicipioLiberacion" class="col-lg-6 control-label" style="text-align: right;">Municipio de la liberación *</label>
                                                <div class="col-lg-6" style="padding-left: 0px;">
                                                    <select name="sltMunicipioLiberacion" id="sltMunicipioLiberacion" class="form-control input-sm">
                                                        <?php
                                                        $intMunicipio = isset($arrInfoCaso['municipio_liberacion']) ? $arrInfoCaso['municipio_liberacion'] : 0;
                                                        $arrMunicipio = $this->objModel->getMunicipios($intDepartamento, $intMunicipio);
                                                        while($arrM = each($arrMunicipio)){
                                                            ?>
                                                            <option value="<?php echo $arrM["key"]; ?>" <?php print ( isset($arrM["value"]['selected']) && $arrM["value"]['selected'] == true ) ? "selected='selected'" : ''; ?>><?php echo $arrM["value"]['texto']; ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <span id="sltMunicipioLiberacionMensaje" class="sr-only">(Este campo es requerido)</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="sltTipoAutor" class="col-lg-4 control-label" style="text-align: right;">Tipo de autor *</label>
                                                <div class="col-lg-5" style="padding-left: 0px;">
                                                    <select name="sltTipoAutor" id="sltTipoAutor" class="form-control input-sm">
                                                        <?php
                                                        $intTipoAutor = isset($arrInfoCaso['tipo_autor']) ? $arrInfoCaso['tipo_autor'] : 0;
                                                        $arrTipoAutor = $this->objModel->getTipoAutor($intTipoAutor);
                                                        while($arrC = each($arrTipoAutor)){
                                                            ?>
                                                            <option value="<?php echo $arrC["key"]; ?>" <?php print ( isset($arrC["value"]['selected']) && $arrC["value"]['selected'] == true ) ? "selected='selected'" : ''; ?>><?php echo $arrC["value"]['texto']; ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <span id="sltTipoAutorMensaje" class="sr-only">(Este campo es requerido)</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="sltTipoSolicitudSecuestrador" class="col-lg-4 control-label" style="text-align: right;">Tipo de solicitud del secuestrador *</label>
                                                <div class="col-lg-5" style="padding-left: 0px;">
                                                    <select name="sltTipoSolicitudSecuestrador" id="sltTipoSolicitudSecuestrador" class="form-control input-sm">
                                                        <?php
                                                        $intTipoSolicitudSecuestrador = isset($arrInfoCaso['tipo_solicitud_secuestrador']) ? $arrInfoCaso['tipo_solicitud_secuestrador'] : 0;
                                                        $arrTipoSolicitudSecuestrador = $this->objModel->getTipoSolicitudSecuestrador($intTipoSolicitudSecuestrador);
                                                        while($arrM = each($arrTipoSolicitudSecuestrador)){
                                                            ?>
                                                            <option value="<?php echo $arrM["key"]; ?>" <?php print ( isset($arrM["value"]['selected']) && $arrM["value"]['selected'] == true ) ? "selected='selected'" : ''; ?>><?php echo $arrM["value"]['texto']; ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <span id="sltTipoSolicitudSecuestradorMensaje" class="sr-only">(Este campo es requerido)</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" id="divAccesoNegEstVictima">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="chkAccesoNegociar" class="col-lg-4 control-label" style="text-align: right;">Acceso a negociar *</label>
                                                <div class="col-lg-5" style="padding-left: 0px;">
                                                    <input type="checkbox" id="chkAccesoNegociar" name="chkAccesoNegociar" value="Acceso a negociar" checked=\"checked\"">
                                                    <span id="chkAccesoNegociarMensaje" class="sr-only">(Este campo es requerido)</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="sltEstadoFinalVictima" class="col-lg-4 control-label" style="text-align: right;">Estado final de la víctima *</label>
                                                <div class="col-lg-5" style="padding-left: 0px;">
                                                    <select name="sltEstadoFinalVictima" id="sltEstadoFinalVictima" class="form-control input-sm">
                                                        <?php
                                                        $intEstadoFinalVictima = isset($arrInfoCaso['estado_final_victima']) ? $arrInfoCaso['estado_final_victima'] : 0;
                                                        $arrEstadoFinalVictima = $this->objModel->getEstadoFinalVictima($intEstadoFinalVictima);
                                                        while($arrM = each($arrEstadoFinalVictima)){
                                                            ?>
                                                            <option value="<?php echo $arrM["key"]; ?>" <?php print ( isset($arrM["value"]['selected']) && $arrM["value"]['selected'] == true ) ? "selected='selected'" : ''; ?>><?php echo $arrM["value"]['texto']; ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <span id="sltEstadoFinalVictimaMensaje" class="sr-only">(Este campo es requerido)</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" id="divMontoSolicitadoNegociado">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="txtMontoSolicitado" class="col-lg-4 control-label" style="text-align: right;">Monto solicitado *</label>
                                                <div class="col-lg-5" style="padding-left: 0px;">
                                                    <input type="text" name="txtMontoSolicitado" id="txtMontoSolicitado" value="<?php print isset($arrInfoCaso['monto_solicitado']) ? $arrInfoCaso['monto_solicitado'] : ''; ?>" class="form-control input-sm" autofocus="autofocus" maxlength="75" required="required" aria-describedby="txtMontoSolicitado">
                                                    <span id="txtMontoSolicitadoMensaje" class="sr-only">(Este campo es requerido)</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="txtMontoNegociado" class="col-lg-4 control-label" style="text-align: right;">Monto negociado *</label>
                                                <div class="col-lg-5" style="padding-left: 0px;">
                                                    <input type="text" name="txtMontoNegociado" id="txtMontoNegociado" value="<?php print isset($arrInfoCaso['monto_negociado']) ? $arrInfoCaso['monto_negociado'] : ''; ?>" class="form-control input-sm" autofocus="autofocus" maxlength="75" required="required" aria-describedby="txtMontoNegociado">
                                                    <span id="txtMontoNegociadoMensaje" class="sr-only">(Este campo es requerido)</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" id="divMontoEntregado">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="txtMontoEntregado" class="col-lg-4 control-label" style="text-align: right;">Monto entregado *</label>
                                                <div class="col-lg-5" style="padding-left: 0px;">
                                                    <input type="text" name="txtMontoEntregado" id="txtMontoEntregado" value="<?php print isset($arrInfoCaso['monto_entregado']) ? $arrInfoCaso['monto_entregado'] : ''; ?>" class="form-control input-sm" autofocus="autofocus" maxlength="75" required="required" aria-describedby="txtMontoEntregado">
                                                    <span id="txtMontoEntregadoMensaje" class="sr-only">(Este campo es requerido)</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="txtObservaciones" class="col-lg-4 control-label" style="text-align: right;">Observaciones *</label>
                                                <div class="col-lg-5" style="padding-left: 0px;">
                                                    <textarea name="txtObservaciones" id="txtObservaciones" cols="75" rows="5" value="<?php print isset($arrInfoCaso['observaciones']) ? $arrInfoCaso['observaciones'] : ''; ?>"></textarea>
                                                    <span id="txtObservacionesMensaje" class="sr-only">(Este campo es requerido)</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="txtReseniaHecho" class="col-lg-4 control-label" style="text-align: right;">Reseña del hecho *</label>
                                                <div class="col-lg-5" style="padding-left: 0px;">
                                                    <textarea name="txtReseniaHecho" id="txtReseniaHecho" cols="75" rows="5" value="<?php print isset($arrInfoCaso['resenia_hecho']) ? $arrInfoCaso['resenia_hecho'] : ''; ?>"></textarea>
                                                    <span id="txtReseniaHechoMensaje" class="sr-only">(Este campo es requerido)</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="denunciante">

                                </div>
                                <div role="tabpanel" class="tab-pane" id="victima">dfgsref</div>
                                <div role="tabpanel" class="tab-pane" id="detenidos">toisofs</div>
                                <div role="tabpanel" class="tab-pane" id="incautaciones">toisofs</div>
                            </div>

                            <!--div class="form-group has-feedback">
                                <label for="imgFotoVictima" class="col-lg-3 col-lg-offset-1">Foto víctima</label>
                                <input class="" name="uploadedfile" type="file" />
                            </div>
                            <div class="form-group has-feedback" id="txtNombreGrupo">
                                <label for="txtNombre" class="col-lg-3 col-lg-offset-1 control-label">Nombre *</label>
                                <div class="col-lg-5">
                                    <input type="text" name="txtNombre" id="txtNombre" value="<?php print isset($arrInfoDelito['nombre']) ? $arrInfoDelito['nombre'] : ''; ?>" class="form-control input-sm" autofocus="autofocus" maxlength="75" required="required" aria-describedby="txtNombreEstado">
                                    <span id="txtNombreIcono" class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                    <span id="txtNombreMensaje" class="sr-only">(Este campo es requerido)</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="txtDescripcion" class="col-lg-3 col-lg-offset-1 control-label">Descripción</label>
                                <div class="col-lg-5">
                                    <textarea name="txtDescripcion" id="txtDescripcion" class="form-control input-sm"><?php print isset($arrInfoDelito['descripcion']) ? $arrInfoDelito['descripcion'] : ''; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="chkActivo" class="col-lg-3 col-lg-offset-1 control-label">Activo</label>
                                <div class="col-lg-5 form-control-static">
                                    <input type="checkbox" name="chkActivo" id="chkActivo" value="1" <?php print isset($arrInfoDelito['activo']) && $arrInfoDelito['activo'] == 'Y' ? 'checked="checked"' : ''; ?>>
                                </div>
                            </div-->
                        </div>
                    </div>
                </div>
            </div>
            <script>
                var intCorrelativoDireccionCautiverio = parseInt(<?php echo $intCorrelativoDireccionCautiverio; ?>);

                function fntaddDireccionCautiverio(){
                    strHtml = "";

                    strHtml = '<tr>'+
                        '<td>'+
                            '<input type="text" name="txtDireccionCautiverio_'+intCorrelativoDireccionCautiverio+'" id="txtDireccionCautiverio_'+intCorrelativoDireccionCautiverio+'" value="" class="form-control input-sm" autofocus="autofocus" maxlength="200" required="required" aria-describedby="txtDireccionCautiverio_'+intCorrelativoDireccionCautiverio+'">'+
                            '<span id="txtDireccionCautiverioMensaje_'+intCorrelativoDireccionCautiverio+'" class="sr-only">(Este campo es requerido)</span>'+
                        '</td>'+
                        '<td>'+
                            '<select name="sltDepartamentoCautiverio_'+intCorrelativoDireccionCautiverio+'" id="sltDepartamentoCautiverio_'+intCorrelativoDireccionCautiverio+'" class="form-control input-sm">'+
                            <?php
                            $arrDepartamento = $this->objModel->getDepartamentos();
                            while($arrD = each($arrDepartamento)){
                                ?>
                                '<option value="<?php echo $arrD["key"]; ?>"><?php echo $arrD["value"]["texto"]; ?></option>'+
                                <?php
                            }
                            ?>
                            '</select>'+
                            '<span id="sltDepartamentoCautiverioMensaje_'+intCorrelativoDireccionCautiverio+'" class="sr-only">(Este campo es requerido)</span>'+
                        '</td>'+
                        '<td>'+
                            '<select name="sltMunicipioCautiverio_'+intCorrelativoDireccionCautiverio+'" id="sltMunicipioCautiverio_'+intCorrelativoDireccionCautiverio+'" class="form-control input-sm">'+
                            <?php
                            $arrMunicipio = $this->objModel->getMunicipios();
                            while($arrD = each($arrMunicipio)){
                                ?>
                                '<option value="<?php echo $arrD["key"]; ?>"><?php echo $arrD["value"]["texto"]; ?></option>'+
                                <?php
                            }
                            ?>
                            '</select>'+
                            '<span id="sltMunicipioCautiverioMensaje_'+intCorrelativoDireccionCautiverio+'" class="sr-only">(Este campo es requerido)</span>'+
                        '</td>'+
                        '<td>'+
                            '<button type="button" class="btn btn-danger btn-xs" onclick="fntEliminarFila(this);" data-toggle="tooltip" data-placement="bottom" title="Eliminar usuario">'+
                            '<span class="glyphicon glyphicon-trash"></span>'+
                            '</button>'+
                        '</td>'+
                        '</tr>';
                    $("#tblDireccionCautiverio > tbody").append(strHtml);
                    intCorrelativoDireccionCautiverio++;

                }
                
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
                    $('#divFechaHecho').datetimepicker();
                    $('#divFechaIngreso').datetimepicker();
                    $('#divFechaDenuncia').datetimepicker();
                    $('#divFechaLiberacion').datetimepicker();
                    if(intCorrelativoDireccionCautiverio == 1){
                        fntaddDireccionCautiverio();
                    }
                    $("#sltDelitos").multiselect({
                        buttonText: function(options, select) {
                            if (options.length === 0) {
                                return 'Ninguna opción selecionada...';
                            }
                            else if (options.length > 0 ) {
                                return  'Más de una opción seleccionada!';
                            }
                        }
                    });

                    if($("#sltTipoCaso").val() == "secuestro"){
                        $("#divDireccionHecho").hide();
                    }
                    else if($("#sltTipoCaso").val() == "fallecido_lesionado"){
                        $("#divDireccionHecho").show();
                    }
                    else if($("#sltTipoCaso").val() == "aprehendido_allanamiento"){
                        $("#divDireccionHecho").show();
                    }

                    $("#sltTipoCaso").on("change",function(){
                        if($("#sltTipoCaso").val() == "secuestro"){
                            $("#divDireccionHecho").hide();
                            $("#divDireccionSecuestro").show();
                            $("#divDireccionCautiverio").show();
                            $("#divDireccionLiberacion").show();
                            $("#divMontoSolicitadoNegociado").show();
                            $("#divMontoEntregado").show();
                            $("#divAccesoNegEstVictima").show();
                            $("#divDenunciaLiberacion").show();
                        }
                        else if($("#sltTipoCaso").val() == "fallecido_lesionado"){
                            $("#divDireccionHecho").show();
                            $("#divDireccionSecuestro").hide();
                            $("#divDireccionCautiverio").hide();
                            $("#divDireccionLiberacion").hide();
                            $("#divMontoSolicitadoNegociado").hide();
                            $("#divMontoEntregado").hide();
                            $("#divAccesoNegEstVictima").hide();
                            $("#divDenunciaLiberacion").hide();
                        }
                        else if($("#sltTipoCaso").val() == "aprehendido_allanamiento"){
                            $("#divDireccionHecho").show();
                            $("#divDireccionSecuestro").hide();
                            $("#divDireccionCautiverio").hide();
                            $("#divDireccionLiberacion").hide();
                            $("#divMontoSolicitadoNegociado").hide();
                            $("#divMontoEntregado").hide();
                            $("#divAccesoNegEstVictima  ").hide();
                            $("#divDenunciaLiberacion  ").hide();
                        }
                    });
                });
            </script>
        </div>
        </form>
        <?php

    }

}