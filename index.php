<?php require_once "inc/header.php"; ?>
    <body>

        <?php
            use SimpleExcel\SimpleExcel;
            require_once "lib/SimpleExcel/SimpleExcel.php";
            require_once "class/ManipulacaoDados.php";
            require_once "class/ManipuladorExcel.php";
            require_once "class/ReadBD.php";

            $txtData = new ManipulacaoDados();
            $texth1 = strtoupper("Acompanhamento incidentes - PERÍODO ".$txtData->h1InforDate());
            $xml = new ManipuladorExcel(new SimpleExcel('xml'));
            $classME = new ReadBD(new ManipuladorExcel(new SimpleExcel('xml')),$xml->getIncidente());
            $tot = $classME->totalIncidente();
            $qtd = $classME->divisaoTempo();
            $pont = $classME->calcPorcentagemTemp();
            $p = $pont[0];
            $j=0;

        ?>

        <div id="bodyDiv" class="container-fluir">

            <h1 class="text-center"><strong><?= $texth1 ?></strong></h1>

            <br/>

            <div id="containerTable" class="container-fluir">
                
                <table id="example" class="display table-bordered cell-border"  cellspacing="0" width="100%">

                    <thead>

                        <tr>
                            <th class="text-center" COLSPAN="4">
                                <h3><?= utf8_encode(strtoupper(strftime("%B/%Y"))) ?></h3>
                            </th>
                        </tr>

                        <tr class="table-primary text-center">
                            <th>Tempo de Resolução</th>
                            <th>Quantidade</th>
                            <th>%</th>
                            <th>Acumulado</th>
                        </tr>

                    </thead>

                    <tbody class="text-center">

                        <?php for($i=1; $i<=4; $i++): ?>

                                <tr>
                                    <th>

                                        <strong>Até <?= 2 * $i ?>h</strong>

                                    </th>

                                    <th><?= $qtd[$j] ?></th>
                                    <th><?= $pont[$j] ?>%</th>
                                    <th><?php

                                        switch ($i){
                                            case 1:
                                                echo $pont[0];
                                                break;
                                            case 2:
                                                echo $pont[0]+$pont[1];
                                                break;
                                            case 3:
                                                echo $pont[0]+$pont[1]+$pont[2];
                                                break;
                                            case 4:
                                                echo $pont[0]+$pont[1]+$pont[2]+$pont[3];
                                                break;
                                        }

                                        ?>%</th>
                                    
                                </tr>


                        <?php $j++; endfor; ?>
                        <tr>
                            <th class="text-center">

                                <strong>Superior a 8h</strong>

                            </th>
                            <th><?= $qtd[count($qtd)-1] ?></th>
                            <th><?= $pont[count($pont)-1] ?>%</th>
                            <th>100%</th>


                        </tr>
						
						<tr class="blueTr">
							<th>TOTAL</th>
                            <th><?= $tot ?></th>
							<th colspan="2">100%</th>
						</tr>

                    </tbody>

                </table>
            </div>
        </div>
        <a id="aExtracao" href="extracao.php?a=true" target="_blank" class="btn btn-outline-primary" role="button" aria-pressed="true"><i class="fa fa-upload" aria-hidden="true"></i> EXTRAÇÃO</a>
        <a id="buttonReadBaseAtual" class="btn btn-outline-success" href="leituraBaseXML.php?a=true" target="_blank" role="button" aria-pressed="true"><i class="fa fa-upload" aria-hidden="true"></i> UPDATE</a>
<?php require_once "inc/footer.php"; ?>