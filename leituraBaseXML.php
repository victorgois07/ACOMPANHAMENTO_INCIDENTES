<?php

    ini_set('max_execution_time', 300); //300 seconds = 5 minutes

    try {
        if (isset($_FILES['fileInputData'])) {

            date_default_timezone_set('America/Sao_Paulo');

            $date = new DateTime('now');

            $extensao = pathinfo($_FILES["fileInputData"]["name"], PATHINFO_EXTENSION);

            if ($extensao == "xml") {

                $temporario = $_FILES["fileInputData"]["tmp_name"];
                $novoNome = "Base_" . $date->format("d-m-Y") . "." . $extensao;

                if (move_uploaded_file($temporario, "files/" . $novoNome)) {

                    $mensagem[] = "Upload Realizado com sucesso! Arquivos: ".$novoNome." foi criado!";

                    ini_set('max_execution_time', 300); //300 seconds = 5 minutes
                    require_once "class/InsertBD.php";

                    $insert = new \Classes\InsertBD();

                    $insert->parser->loadFile($insert->getArquivosXml());

                    $foo = $insert->parser->getField();

                    $dado = explode("/",$insert->getArquivosXml());
                    $ex = explode(".",$dado[1]);

                    $criar = fopen("json/".$ex[0].".json","a");

                    fwrite($criar,json_encode($foo));

                    $mensagem[] = $insert->implantDataDB();

                    echo json_encode(implode(" | ", $mensagem));
                    header('Content-Type: application/json');

                } else {

                    throw new Exception("Erro durante o upload do arquivos!!");

                }

            } else {

                throw new Exception("Extensão do arquivos inválida!! Favor converter arquivos para XML (EXCEL2003 XML)");

            }

        }
    } catch (\Exception $e) {

        echo json_encode(array("ERRO: ".$e->getMessage(),"Linha: ".$e->getLine(),"Arquivos: ".$e->getFile()));
        header('Content-Type: application/json');

    }

?>