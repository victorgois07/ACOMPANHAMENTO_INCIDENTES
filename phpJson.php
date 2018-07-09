<?php

    require_once "class/InsertBD.php";

    $insert = new \Classes\InsertBD();

    $date = new \DateTime('now');

    $_GET["m"] = !empty($_GET["m"])?$_GET["m"]:$date->format("Y-m");

    $dados = $insert->calculoEntreHoras($_GET["m"]);

    if (isset($dados)) {

        foreach ($dados as $key => $d) {
            foreach ($d as $k => $v) {
                if ($k == 4) {
                    $json[] = array(
                        "tempoDeResolução" => "Superior a 8h",
                        "quantidade" => $dados[0][$k],
                        "%" => $dados[1][$k] . "%",
                        "acumulado" => "100%",
                    );
                } else {
                    $json[] = array(
                        "tempoDeResolução" => "Até " . (2 * ($k + 1)) . "h",
                        "quantidade" => $dados[0][$k],
                        "%" => $dados[1][$k] . "%",
                        "acumulado" => $dados[2][$k] > 100?"100%":$dados[2][$k]."%",
                    );
                }
            }
            break;
        }

        if (isset($json)) {

            array_push(
                $json,
                array(
                    "tempoDeResolução" => "TOTAL",
                    "quantidade" => $insert->calculoTotal($_GET["m"]),
                    "%" => "100%",
                    "acumulado" => "100%"
                )
            );

            echo json_encode($json, JSON_UNESCAPED_UNICODE);
            header('Content-Type: application/json');
        }
    }

?>