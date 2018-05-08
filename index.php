<?php require_once "inc/header.php"; ?>

    <body onload="setInterval(function() { window.location.reload('true')},180000)">
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
                <tbody id="bodyTable" class="text-center"></tbody>
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
                <i class="fas fa-bars" aria-hidden="true"></i> OPÇÕES
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

                            <input type="file" id="fileInputData" name="fileInputData" required>
                            <input type="submit" id="btnEnviar" value="Upload"/>

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

                            <button id="buttonModalSubmitMes" class="btn btn-primary btn-lg btn-block" type="submit"><i class="fas fa-search"></i> Visualizar</button>

                        </form>

                    </div>

                </div>

                <div id="modalContentTable" class="modal-content d-none">

                    <img id="imgClose" src="img/error.png">

                    <form id="formExtracaoView" method="post" target="_blank" action="extracao.php">

                        <input type="hidden" id="dados_a_enviar_view" name="dados_a_enviar" />

                        <button id="aExtracaoView" class="btn btn-primary" type="submit">

                            <i class="fa fa-upload" aria-hidden="true"></i>

                        </button>

                    </form>

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

        <div id="modalTableData" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog d-flex align-items-center" role="document">
                <div id="modalContentDataTable" class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Incidentes</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div id="modalBodyTable" class="modal-body d-flex justify-content-center"></div>
                </div>
            </div>
        </div>

        <div id="loader"></div>
        <div id="loaderModal" class="d-none"></div>

<?php require_once "inc/footer.php"; ?>