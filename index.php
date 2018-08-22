<?php

    use classes\manipulacao\Manipulacao;

    require_once dirname(__FILE__).DIRECTORY_SEPARATOR."classes/manipulacao/Manipulacao.php";

    $manipulacao = new Manipulacao(new DateTime('now'));

?>

<!doctype html>
<html lang="pt-br" class="no-js">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <link rel="stylesheet" href="lib/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="lib/datatable/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="lib/datatable/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="lib/Font-Awesome/web-fonts-with-css/css/fontawesome-all.min.css">
        <link rel="stylesheet" href="lib/jqueryconfirm/jquery-confirm.min.css">
        <link rel="stylesheet" href="lib/file_export_datatable/buttons.dataTables.min.css">
        <link rel="stylesheet" href="css/estilo.css">

        <title>Acompanhamento de Incidentes</title>

    </head>

    <body>

        <div id="divJumbotronTable" class="jumbotron jumbotron-fluid">

            <h1 id="tdTitulo"><?= $manipulacao->h1Titulo() ?></h1>

            <div id="buttonOpcao" class="btn-group" role="group">
                <button id="btnGroupDrop1" type="button" class="btn btn-outline-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-keyboard="false" data-backdrop="static">
                    <i class="fas fa-bars" aria-hidden="true"></i> OPÇÕES
                </button>
                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                    <a id="buttonVisualizarMes" data-toggle="modal" data-target="#modalOpcaoPainel" class="dropdown-item" href="#" data-keyboard="false" data-backdrop="static"><i class="fa fa-desktop" aria-hidden="true"></i> Visualizar Mês</a>
                    <a id="buttonReadBaseAtual" data-toggle="modal" data-target="#modalOpcaoPainel" class="dropdown-item" href="#" data-keyboard="false" data-backdrop="static"><i class="fa fa-upload" aria-hidden="true"></i> Update</a>
                </div>
            </div>

            <table id="tableAcompanhamentoIncidentes" class="table table-striped table-bordered text-center" style="width:100%">

                <thead>

                    <tr>

                        <td colspan="4"><?= $manipulacao->tbMes() ?></td>

                    </tr>

                    <tr>

                        <td>Tempo de Resolução</td>

                        <td>Quantidade</td>

                        <td>%</td>

                        <td>Acumulado</td>

                    </tr>

                </thead>

            </table>

        </div>

        <!-- Modal -->
        <div class="modal fade" id="modalOpcaoPainel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

            <div class="modal-dialog" role="document">

                <div class="modal-content">

                    <div class="modal-header">

                        <h5 class="modal-title" id="exampleModalLabel"></h5>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>

                    </div>

                    <div id="modalBodyUpdate" class="modal-body d-none">

                        <form id="formUpload" action="" method="POST" enctype="multipart/form-data">

                            <input type="file" id="fileInputData" name="fileInputData" required>
                            <input type="submit" id="btnEnviar" value="Upload"/>

                        </form>

                    </div>

                    <div id="modalBodyMes" class="modal-body d-none">
                        <form id="formDataMesSectect" method="get" target="_blank" action="controller/mesTable.php">
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <select name="selectDataTableMes" id="selectDataTableMes" class="form-control form-control-sm"></select>
                                </div>
                            </div>
                            <br>
                            <button id="buttonSubmitMes" class="btn btn-primary btn-lg btn-block" type="submit"><i class="fa fa-sign-out-alt"></i> Extrair</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>

        <div class="modal fade" id="modalBaseTable" tabindex="-1" role="dialog" aria-labelledby="titleModalDataTable" aria-hidden="true">

            <div id="dialogModal" class="modal-dialog" role="document">

                <div class="modal-content">

                    <div class="modal-header">

                        <h5 class="modal-title" id="titleModalDataTable"></h5>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="location.reload(true)">
                            <span aria-hidden="true">&times;</span>
                        </button>

                    </div>

                    <div id="modalDataTable" class="modal-body">

                        <table id="tableDataBase" class="table table-striped table-bordered text-center" style="width:100%">

                            <thead>

                            <tr>

                                <td>Incidente</td>

                                <td>Sumário</td>

                                <td>IC</td>

                                <td>Prioridade</td>

                                <td>Criado</td>

                                <td>Resolvido</td>

                                <td>Duração</td>

                                <td>Vencido >8h</td>

                                <td>Vencido Prioridade</td>

                                <td>Grupo designado</td>

                                <td>Empresa</td>

                            </tr>

                            </thead>

                        </table>

                    </div>

                </div>

            </div>

        </div>

        <div class="modal fade" id="modalMesSelectData" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="h5MesSelectData"><strong>Base do Mês</strong></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="location.reload(true)">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <table id="tableMesSelectData" class="table table-striped table-bordered text-center" style="width:100%">

                            <thead>

                            <tr>

                                <td id="tdMesSelectData" colspan="4"></td>

                            </tr>

                            <tr>

                                <td>Tempo de Resolução</td>

                                <td>Quantidade</td>

                                <td>%</td>

                                <td>Acumulado</td>

                            </tr>

                            </thead>

                        </table>

                    </div>

                </div>
            </div>
        </div>



        <div id="loaderModal" class="d-none"></div>
        <div id="loader"></div>

        <script src="lib/jquery/jquery-3.3.1.js"></script>
        <script src="lib/bootstrap/site/docs/4.1/assets/js/vendor/popper.min.js"></script>
        <script src="lib/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="lib/datatable/js/jquery.dataTables.min.js"></script>
        <script src="lib/datatable/js/dataTables.bootstrap4.min.js"></script>
        <script src="lib/jqueryconfirm/jquery-confirm.min.js"></script>
        <script src="lib/file_export_datatable/dataTables.buttons.min.js"></script>
        <script src="lib/file_export_datatable/buttons.flash.min.js"></script>
        <script src="lib/file_export_datatable/jszip.min.js"></script>
        <script src="lib/file_export_datatable/pdfmake.min.js"></script>
        <script src="lib/file_export_datatable/vfs_fonts.js"></script>
        <script src="lib/file_export_datatable/buttons.html5.min.js"></script>
        <script src="lib/file_export_datatable/buttons.print.min.js"></script>
        <script src="js/script.js"></script>
    </body>
</html>