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
        <div id="divDropdown" class="btn-group">
            <button type="button" class="btn btn-outline-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-reorder" aria-hidden="true"></i> OPÇÕES
            </button>
            <div class="dropdown-menu">
                <a id="buttonVisualizarMes" data-toggle="modal" data-target="#uploadModal" class="dropdown-item" href="#"><i class="fa fa-desktop" aria-hidden="true"></i> Visualizar Mês</a>
                <a id="buttonReadBaseAtual" data-toggle="modal" data-target="#uploadModal" class="dropdown-item" href="#"><i class="fa fa-upload" aria-hidden="true"></i> Update</a>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">

                <div id="modalContentDados" class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div id="modalBodyUpdate" class="modal-body d-none">
                        <form id="formUpload" action="" method="POST" enctype="multipart/form-data">
                            <input type="file" id="fileInputData" name="fileInputData">
                            <input type="button" id="btnEnviar" value="Enviar" />
                        </form>
                    </div>
                    <div id="modalBodyMes" class="modal-body d-none">
                        <form action="phpJson.php" id="formVisualizaMes" method="get">
                            <select name="m" id="selectMes" class="form-control" required>
                                <option disabled selected></option>
                                <?php
                                    foreach ($txtData->optionSqlData() as $p){
                                        echo "<option value='".$p[1]."'>".ucfirst($p[0])."</option>";
                                    }
                                ?>
                            </select>
                            <br/>
                            <button id="buttonModalSubmitMes" class="btn btn-primary btn-lg btn-block" type="submit"><i class="fa fa-share-square-o"></i> Cadastra</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>

                <div id="modalContentTable" class="modal-content d-none">
                    <img id="imgClose" src="img/error.png">
                    <div id="containerTableInfo2" class="container-fluid">
                        <h2 id="h2data"></h2>
                        <table id="tableIncidentes2">
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
                </div>
            </div>
        </div>

        <div class="square d-none"></div>

<?php require_once "inc/footer.php"; ?>