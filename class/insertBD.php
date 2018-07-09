<?php

namespace Classes;

require_once "ReadBD.php";

class InsertBD extends \Classes\ReadBD{

    protected function keyReturnDiff($data,$col,$table):array {

        foreach ($data as $key => $value){

            if($this->dataExist("SELECT $col FROM $table WHERE $col = ?",$value) == false){

                $var[] = $key;

            }

        }

        if(isset($var)){
            return $var;
        }

    }

    protected function insertNotExist($data,$col,$table){

        if (is_array($data)) {

            if ($this->dataExist("SELECT $col FROM $table WHERE $col = ?", $data[0]) == false) {

                $id = $this->jailNumberId($table);

                $this->insert("INSERT INTO $table VALUES (?,?,?)",array($id,$data[0],$data[1]));

                if(!empty($id)){

                    return $id;

                }else{

                    return $this->idValueReturn($table,$col,$data[0]);

                }

            }else{

                return $this->idValueReturn($table,$col,$data[0]);

            }

        }else{

            if ($this->dataExist("SELECT $col FROM $table WHERE $col = ?", $data) == false) {

                $id = $this->jailNumberId($table);

                $this->insert("INSERT INTO $table VALUES (?,?)",array($id,$data));

                if(!empty($id)){

                    return $id;

                }else{

                    return $this->idValueReturn($table,$col,$data);

                }

            }else{

                return $this->idValueReturn($table,$col,$data);

            }

        }
    }

    public function implantDataDB(){
        
        $arrayDadosXml = $this->getContainerDataXml();
        $indenteDB = $this->compareOccurrenceDiff();

        $inc = $arrayDadosXml["incidente"];
        $emp = $arrayDadosXml["empresa"];
        $ic = $arrayDadosXml["ic"];
        $sumario = $arrayDadosXml["sumario"];
        $prioridade = $arrayDadosXml["prioridade"];
        $grupoDesignado = $arrayDadosXml["grupo"];
        $criado = $this->dataTimeFormatInsertDB($arrayDadosXml["criado"]);
        $resolvido = $this->dataTimeFormatInsertDB($arrayDadosXml["resolvido"]);
        $descricaoProblema = $arrayDadosXml["nota"];
        $descricaoResolvido = $arrayDadosXml["resolucao"];

        foreach($inc as $key => $i){
            if(in_array($i,$indenteDB)){
                $keyComp[] = $key;
            }
        }

        try {

            foreach($keyComp as $kc){
                $this->insert(
                    "INSERT INTO tb_ocorrencia (incidente, criado, resolucao, descricao_problema, descricao_solucao, fk_grupo_designado, fk_ic, fk_prioridade, fk_sumario) VALUES (?,?,?,?,?,?,?,?,?)",
                    array(
                        $inc[$kc],
                        $criado[$kc],
                        $resolvido[$kc],
                        $descricaoProblema[$kc],
                        $descricaoResolvido[$kc],
                        $this->insertNotExist(array($grupoDesignado[$kc],$this->insertNotExist($emp[$kc],'descricao','tb_empresa')),'grupo','tb_grupo_designado'),
                        $this->insertNotExist($ic[$kc],'descricao','tb_ic'),
                        $this->insertNotExist($prioridade[$kc],'pri_descricao','tb_prioridade'),
                        $this->insertNotExist($sumario[$kc],'descricao','tb_sumario')
                    ));
            }

            if (unlink($this->getArquivosXml())) {

                return "Base foi atualizada!! Arquivo " . $this->getArquivosXml() . " Excluído!";

            } else {

                return "Base foi atualizada!! Erro na Exclusão do Arquivo " . $this->getArquivosXml();

            }

        } catch (\Exception $e) {

            ob_end_clean();

            exit("ERRO: ".$e->getMessage()."<br/>LINHA: ".$e->getLine()."<br/>CODE: ".$e->getCode()."<br/>ARQUIVO: ".$e->getFile());

        }


    }
    
}

?>