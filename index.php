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

        <a id="buttonReadBaseAtual" class="btn btn-outline-success" href="leituraBaseXML.php?a=true" target="_blank" role="button" aria-pressed="true">
            <i class="fa fa-upload" aria-hidden="true"></i> UPDATE
        </a>

<?php require_once "inc/footer.php"; ?>