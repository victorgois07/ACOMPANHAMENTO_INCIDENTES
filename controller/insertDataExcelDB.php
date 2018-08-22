<?php

    use classes\Database\Create;
    use classes\manipulacao\Files;

    ini_set('max_execution_time', 800); //300 seconds = 5 minutes

    require_once "../config/config.php";

    try {

        if (isset($_FILES['fileInputData'])) {

            $file = new Files($_FILES['fileInputData'], new DateTime('now'), new Create());

            echo json_encode($file->resultInsertData());

            unlink($file->getDestino());

            header('Content-Type: application/json');

        }else{

            throw new Exception("Erro durante o upload do arquivos!!");

        }

    } catch (Exception $e) {

        ob_end_clean();

        exit("ERRO: ".$e->getMessage()."<br/>LINHA: ".$e->getLine()."<br/>CODE: ".$e->getCode()."<br/>ARQUIVO: ".$e->getFile());

    }

?>