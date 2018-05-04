<?php
    use SimpleExcel\SimpleExcel;
    require_once "lib/SimpleExcel/SimpleExcel.php";
    require_once "class/ManipulacaoDados.php";
    require_once "class/ManipuladorExcel.php";
    require_once "class/ReadBD.php";
    
    $xml = new ManipuladorExcel(new SimpleExcel('xml'));
    $classME = new ReadBD(new ManipuladorExcel(new SimpleExcel('xml')),$xml->getIncidente());
    $data = new DateTime('now');
    $tot = $classME->totalIncidente($data->format("m"));
    $qtd = $classME->divisaoTempo();
    $pont = $classME->calcPorcentagemTemp($qtd,$tot);
    $p = $pont[0];

    $k=0;

    for($i=1; $i<=4; $i++){
        switch ($i){
            case 1:
                $acumulado[$k] = round($pont[0]);
                break;
            case 2:
                $acumulado[$k] = round($pont[0]+$pont[1]);
                break;
            case 3:
                $acumulado[$k] = round($pont[0]+$pont[1]+$pont[2]);
                break;
            case 4:
                $acumulado[$k] = round($pont[0]+$pont[1]+$pont[2]+$pont[3]);
                break;
        }
        $k++;
    }

    if (isset($acumulado)) {

        $j = 0;

        for ($i = 1; $i <= 6; $i++) {

            if ($i == 5) {

                $dados[$j] = array(
                    "tempoDeResolução" => "Superior a 8h",
                    "quantidade" => round($qtd[count($qtd)-1]),
                    "%" => round($pont[count($pont)-1])."%",
                    "acumulado" => "100%"
                );

            }else if ($i == 6){

                $dados[$j] = array(
                    "tempoDeResolução" => "TOTAL",
                    "quantidade" => $tot,
                    "%" => "100%",
                    "acumulado" => "100%"
                );

            } else {
                $dados[$j] = array(
                    "tempoDeResolução" => "Até " . (2 * $i) . "h",
                    "quantidade" => $qtd[$j],
                    "%" => round($pont[$j])."%",
                    "acumulado" => $acumulado[$j]."%"
                );
            }

            $j++;
        }

        if(isset($dados)){
            echo json_encode($dados);
        }

    }

?>