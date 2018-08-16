<?php

require_once "PHPExcel/PHPExcel.php";

final class ExcelData extends PHPExcel {
    public $indice;

    protected function validateFilesName():string{

        try {

            if (is_dir(dirname(__FILE__,3).DIRECTORY_SEPARATOR."files")) {

                $arquivos = glob(dirname(__FILE__,3).DIRECTORY_SEPARATOR."files".DIRECTORY_SEPARATOR."{*.xls}", GLOB_BRACE);

                if (!empty($arquivos)) {

                    foreach ($arquivos as $nome) {

                        $arrayDados[] = $nome;

                    }

                    if (isset($arrayDados)) {

                        return $arrayDados[0];

                    }else{

                        throw new Exception("ERRO: Variavel arrayDados encontra-se sem valores!");

                    }

                } else {

                    throw new Exception("Não Existem arquivos dentro do diretorio files");

                }

            } else {

                throw new Exception("O Diretorio files não existe!");

            }
        } catch (Exception $e) {

            return "ERRO: ".$e->getMessage()."\nLinha: ".$e->getLine()."\nArquivos: ".$e->getFile();

        }
    }

    private function dataExcel():array {

        try {

            $excelReader = PHPExcel_IOFactory::createReaderForFile($this->validateFilesName());

            $excelObj = $excelReader->load($this->validateFilesName());

            $worksheet = $excelObj->getActiveSheet();

            $lastRow = $worksheet->getHighestRow();

            $col = ord($worksheet->getHighestColumn())-64;

            for ($i=0; $i<$col; $i++){
                $valCol[] = chr(65+$i);
            }

            if (isset($valCol)) {
                for ($i = 1; $i <= $lastRow; $i++) {
                    for ($j = 0; $j < $col; $j++) {
                        $excel[$i - 1][$j] = $worksheet->getCell($valCol[$j] . $i)->getValue();
                    }
                }

                if(isset($excel)){

                    return $excel;

                }else{

                    throw new Exception("ERRO: Variavel excel encontra-se sem valores!");

                }
            }else{

                throw new Exception("ERRO: Variavel valCol encontra-se sem valores!");

            }

        } catch (PHPExcel_Reader_Exception $e) {

            ob_end_clean();

            exit("ERRO: ".$e->getMessage()."<br/>LINHA: ".$e->getLine()."<br/>CODE: ".$e->getCode()."<br/>ARQUIVO: ".$e->getFile());

        } catch (PHPExcel_Exception $e) {

            ob_end_clean();

            exit("ERRO: ".$e->getMessage()."<br/>LINHA: ".$e->getLine()."<br/>CODE: ".$e->getCode()."<br/>ARQUIVO: ".$e->getFile());

        } catch (Exception $e){

            ob_end_clean();

            exit("ERRO: ".$e->getMessage()."<br/>LINHA: ".$e->getLine()."<br/>CODE: ".$e->getCode()."<br/>ARQUIVO: ".$e->getFile());

        }


    }

    private function checkColumnExist():bool{
        $excelData = $this->dataExcel();

        $indice = $excelData[0];

        $check = array(
            "Empresa de Suporte*",
            "Grupo Designado*+",
            "Notas",
            "Resolução",
            "Criado em",
            "Prioridade*",
            "Data da Última Resolução",
            "IC+",
            "ID do Incidente*+",
            "Sumário*"
        );

        foreach ($check as $ch){
            if(!in_array($ch,$indice)){
                return false;
            }
        }

        return true;

    }

    public function organizeArrayExcel():array {

        if ($this->checkColumnExist() == true) {

            $excel = $this->dataExcel();

            $this->setIndice($excel[0]);

            for($i=1;$i < count($excel) - 2; $i++){
                $data[] = $excel[$i];
            }

            return $data;

        }

    }

    public function getIndice():Array{
        return $this->indice;
    }

    public function setIndice(Array $indice): void{
        $this->indice = $indice;
    }





}