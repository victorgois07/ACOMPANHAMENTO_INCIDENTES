<?php require_once "inc/header.php"; ?>

    <body>
        <?php
            require_once "class/ManipulacaoDados.php";
            $txtData = new ManipulacaoDados();
            $texth1 = strtoupper("Acompanhamento incidentes - PERÍODO ".$txtData->h1InforDate());
        ?>

        <h1 class="text-center"><strong><?= $texth1 ?></strong></h1>

        <div id="containerTableInfo" class="container-fluid">
            <h2><?= utf8_encode(strtoupper(strftime("%B/%Y"))) ?></h2>
            <table id="tableIncidentes">
                <thead>
                    <tr>
                        <th>Tempo de Resolução</th>
                        <th>Quantidade</th>
                        <th>%</th>
                        <th>Acumulado</th>
                    </tr>
                </thead>
                <tbody class="text-center"></tbody>
            </table>
        </div>

        <form id="formExtracao" method="post" target="_blank" action="extracao.php">
            <input type="hidden" id="dados_a_enviar" name="dados_a_enviar" />
            <button id="aExtracao" class="btn btn-outline-primary" type="submit">
                <i class="fa fa-upload" aria-hidden="true"></i> EXTRAÇÃO
            </button>
        </form>

        <!-- Example single danger button -->
        <div class="btn-group">
            <button type="button" class="btn btn-outline-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Opções
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="#">Visualizar Mês!</a>
                <a class="dropdown-item" href="#">Something else here</a>
                <div class="dropdown-divider"></div>
                <a id="buttonReadBaseAtual" data-toggle="modal" data-target="#uploadModal" class="dropdown-item" href="#"><i class="fa fa-upload" aria-hidden="true"></i> UPDATE</a>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Upload Arquivo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="formUpload" action="" method="POST" enctype="multipart/form-data">
                            <input type="file" id="fileInputData" name="fileInputData">
                            <input type="button" id="btnEnviar" value="Enviar" />
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="square d-none"></div>

<?php require_once "inc/footer.php"; ?>