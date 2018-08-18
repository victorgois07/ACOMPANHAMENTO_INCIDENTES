<?php

    use classes\manipulacao\Manipulacao;

    require_once dirname(__FILE__).DIRECTORY_SEPARATOR."classes/manipulacao/Manipulacao.php";

    $manipulacao = new Manipulacao(new DateTime('now'));

?>

<!doctype html>
<html lang="pt-br">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="lib/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="lib/datatable/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="lib/Font-Awesome/web-fonts-with-css/css/fontawesome-all.min.css">
        <link rel="stylesheet" href="css/estilo.css">

        <title>Acompanhamento de Incidentes</title>

    </head>

    <body class="d-flex align-items-center">

        <div id="divJumbotronTable" class="jumbotron jumbotron-fluid">

            <h1 id="tdTitulo"><?= $manipulacao->h1Titulo() ?></h1>

            <button id="buttonExtracao" type="button" class="btn btn-outline-primary"><i class="fa fa-upload" aria-hidden="true"></i> EXTRAÇÃO</button>

            <div id="buttonOpcao" class="btn-group" role="group">
                <button id="btnGroupDrop1" type="button" class="btn btn-outline-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-bars" aria-hidden="true"></i> OPÇÕES
                </button>
                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                    <a id="buttonVisualizarMes" class="dropdown-item" href="#"><i class="fa fa-desktop" aria-hidden="true"></i> Visualizar Mês</a>
                    <a id="buttonReadBaseAtual" class="dropdown-item" href="#"><i class="fa fa-upload" aria-hidden="true"></i> Update</a>
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

        <script src="lib/jquery/jquery-3.3.1.js"></script>
        <script src="lib/bootstrap/site/docs/4.1/assets/js/vendor/popper.min.js"></script>
        <script src="lib/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="lib/datatable/js/jquery.dataTables.min.js"></script>
        <script src="lib/datatable/js/dataTables.bootstrap4.min.js"></script>
        <script src="js/script.js"></script>
    </body>
</html>