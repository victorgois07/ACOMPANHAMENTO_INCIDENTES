<?php

    use classes\manipulacao\Manipulacao;

    require_once dirname(__FILE__).DIRECTORY_SEPARATOR."classes/manipulacao/Manipulacao.php";

    $manipulacao = new Manipulacao(new DateTime('now'));

    echo "<pre>";
    print_r($_SERVER);
    exit;

?>

<!doctype html>
<html lang="pt-br">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="<?= $manipulacao->getLocal() ?>lib/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?= $manipulacao->getLocal() ?>lib/datatable/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="<?= $manipulacao->getLocal() ?>css/estilo.css">

        <title>Acompanhamento de Incidentes</title>

    </head>

    <body class="d-flex align-items-center">

        <div id="divJumbotronTable" class="jumbotron jumbotron-fluid">

            <h1 id="tdTitulo"><?= $manipulacao->h1Titulo() ?></h1>

            <button type="button" class="btn btn-outline-primary"><i class="fa fa"></i></button>

            <div class="btn-group" role="group">
                <button id="btnGroupDrop1" type="button" class="btn btn-outline-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Dropdown
                </button>
                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                    <a class="dropdown-item" href="#">Dropdown link</a>
                    <a class="dropdown-item" href="#">Dropdown link</a>
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

        <script src="<?= $manipulacao->getLocal() ?>lib/jquery/jquery-3.3.1.js"></script>
        <script src="<?= $manipulacao->getLocal() ?>lib/bootstrap/site/docs/4.1/assets/js/vendor/popper.min.js"></script>
        <script src="<?= $manipulacao->getLocal() ?>lib/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="<?= $manipulacao->getLocal() ?>lib/datatable/js/jquery.dataTables.min.js"></script>
        <script src="<?= $manipulacao->getLocal() ?>lib/datatable/js/dataTables.bootstrap4.min.js"></script>
        <script src="<?= $manipulacao->getLocal() ?>js/script.js"></script>
    </body>
</html>