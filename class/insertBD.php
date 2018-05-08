<?php

namespace Classes;

require_once "ReadBD.php";

class InsertBD extends \Classes\ReadBD{

    protected function xml2js($xmlnode) {
        $root = (func_num_args() > 1 ? false : true);
        $jsnode = array();

        if (!$root) {
            if (count($xmlnode->attributes()) > 0){
                $jsnode["$"] = array();
                foreach($xmlnode->attributes() as $key => $value)
                    $jsnode["$"][$key] = (string)$value;
            }

            $textcontent = trim((string)$xmlnode);
            if (count($textcontent) > 0)
                $jsnode["_"] = $textcontent;

            foreach ($xmlnode->children() as $childxmlnode) {
                $childname = $childxmlnode->getName();
                if (!array_key_exists($childname, $jsnode))
                    $jsnode[$childname] = array();
                array_push($jsnode[$childname], xml2js($childxmlnode, true));
            }
            return $jsnode;
        } else {
            $nodename = $xmlnode->getName();
            $jsnode[$nodename] = array();
            array_push($jsnode[$nodename], xml2js($xmlnode, true));
            return json_encode($jsnode);
        }
    }

    protected function firstTable($table){
        try {
            
            $sql = $this->conectBD()->prepare("DESC `$table`");
            
            if ($sql->execute()) {
                
                $dado = $sql->fetchAll(\PDO::FETCH_NUM);
                
                return $dado[0][0];
                
            } else {
                
                throw new \Exception("ERRO: ".implode(" ",$sql->errorInfo()));
                
            }
        } catch (\Exception $e) {
            
            return array("ERRO: ".$e->getMessage(),"Linha: ".$e->getLine(),"Arquivos: ".$e->getFile());
        }
    }

    protected function idNumTable($table){

        try {

            $sql = $this->conectBD()->prepare("SELECT `".$this->firstTable($table)."` FROM `$table` ORDER BY `".$this->firstTable($table)."` ASC");

            if ($sql->execute()) {

                foreach ($sql->fetchAll(\PDO::FETCH_NUM) as $o) {
                    $d[] = $o[0];
                }

                if (isset($d)) {

                    for ($i = 1; $i < $d[count($d) - 1]; $i++) {
                        if (!in_array($i, $d)) {
                            $exist[] = $i;
                        }
                    }

                    if (isset($exist)) {
                        
                        return $exist[0];
                        
                    } else {
                        
                        return count($d) + 1;
                        
                    }
                    
                } else {
                    
                    throw new \Exception("ERRO: Variavel d encontra-se sem valores!");
                    
                }
                
            } else {

                throw new \Exception("ERRO: ".implode(" ",$sql->errorInfo()));
                
            }
            
        } catch (\Exception $e) {
            
            return array("ERRO: ".$e->getMessage(),"Linha: ".$e->getLine(),"Arquivos: ".$e->getFile());
            
        }
        
    }

    protected function idReturn($table,$column,$val){

        try {
            $sql = $this->conectBD()->prepare("SELECT `" . $this->firstTable($table) . "` FROM `$table` WHERE `$column` = :VAL");

            $sql->bindValue(":VAL", $val);

            if ($sql->execute()) {
                
                $var = $sql->fetchAll(\PDO::FETCH_NUM);

                if (isset($var[0][0])) {
                    
                    return $var[0][0];
                    
                }else{

                    throw new \Exception("ERRO: Variavel var encontra-se sem valores!");
                    
                }

            }else{
                
                throw new \Exception("ERRO: ".implode(" ",$sql->errorInfo()));
                
            }            
            
        } catch (\Exception $e) {

            return array("ERRO: ".$e->getMessage(),"Linha: ".$e->getLine(),"Arquivos: ".$e->getFile());
            
        }
    }

    protected function tryDataDB($table, $where, $values){

        try {

            $sql = $this->conectBD()->prepare("SELECT * FROM $table WHERE $where = :WH");

            $sql->bindValue(":WH", $values);

            if ($sql->execute()) {

                if($sql->rowCount() > 0){
                    return true;
                }else{
                    return false;
                }

            } else {

                throw new \Exception("ERRO: ".implode(" ",$sql->errorInfo()));

            }

        } catch (\Exception $e) {

            return array("ERRO: ".$e->getMessage(),"Linha: ".$e->getLine(),"Arquivos: ".$e->getFile());

        }

    }
    
    protected function tableColumn($table){
        
        try {
            
            $sql = $this->conectBD()->prepare("DESC $table");

            if ($sql->execute()) {

                foreach ($sql->fetchAll(\PDO::FETCH_NUM) as $item) {
                    $col[] = $item[0];
                }

                if (isset($col)) {
                    
                    return $col;
                    
                } else {
                    
                    throw new \Exception("ERRO: Variavel col encontra-se sem valores!");
                    
                }
                
            } else {

                throw new \Exception("ERRO: " . implode(" ", $sql->errorInfo()));

            }
        } catch (\Exception $e) {

            return array("ERRO: ".$e->getMessage(),"Linha: ".$e->getLine(),"Arquivos: ".$e->getFile());
            
        }
        
    }

    protected function insertIntoData($table, $values){

        if ($table != "tb_ocorrencia") {
            $values =  count($values) == 1?array($values):$values;
            array_unshift($values, $this->idNumTable($table));
        }

        $comando = "INSERT INTO $table (";
        
        foreach ($this->tableColumn($table) as $key => $tab){
            if((count($this->tableColumn($table)) - 1) == $key){
                $comando .= $tab.") VALUES (";
            }else{
                $comando .= $tab.", ";
            }
        }
        
        foreach ($values as $key => $val){
            if((count($values) - 1) == $key){
                $comando .= "?)";
            }else{
                $comando .= "?,";
            }
        }

        $sql = $this->conectBD()->prepare($comando);


        try {

            $this->conectBD()->beginTransaction();

            if ($table != "tb_ocorrencia") {

                foreach ($values as $key => $v) {

                    if ($key == 0) {

                        $sql->bindValue(($key + 1), $v, \PDO::PARAM_INT);

                    } else {

                        $sql->bindValue(($key + 1), $v, \PDO::PARAM_STR);

                    }

                }

            } else {

                foreach ($values as $key => $v) {

                    $sql->bindValue(($key + 1), $v, \PDO::PARAM_STR);
                }
            }


            if ($sql->execute()) {

                $this->conectBD()->commit();

                return true;

            }else{

                $this->conectBD()->rollBack();

                throw new \Exception("ERRO: " . implode(" ", $sql->errorInfo()));

            }

        } catch (\Exception $e) {

            return array("ERRO: ".$e->getMessage(),"Linha: ".$e->getLine(),"Arquivos: ".$e->getFile(),"COMANDO: ".$comando,"VALOR: " => $values);

        }
    }
    
    public function implantDataDB(){
        
        $arrayDadosXml = $this->getContainerDataXml();
        $inc = $arrayDadosXml["incidente"];
        $emp = $arrayDadosXml["empresa"];
        $ic = $arrayDadosXml["ic"];
        $sumario = $arrayDadosXml["sumario"];
        $prioridade = $arrayDadosXml["prioridade"];
        $grupoDesignado = $arrayDadosXml["grupo"];
        $criado = $arrayDadosXml["criado"];
        $resolvido = $arrayDadosXml["resolvido"];
        $descricaoProblema = $arrayDadosXml["nota"];
        $descricaoResolvido = $arrayDadosXml["resolucao"];
        
        $incidentes = $this->analiseIncidenteDB();

        try {

            if ((!empty($inc) && isset($inc) &&  (!empty($emp) && isset($emp)) && (!empty($ic) && isset($ic)) && (!empty($sumario) && isset($sumario)) && (!empty($prioridade) && isset($prioridade)) && (!empty($grupoDesignado) && isset($grupoDesignado)) && (!empty($criado) && isset($criado)) && (!empty($resolvido) && isset($resolvido)) && (!empty($descricaoProblema) && isset($descricaoProblema)) && (!empty($descricaoResolvido) && isset($descricaoResolvido)))) {

                if ($incidentes != false) {
                    foreach ($incidentes as $incident) {
                        $keySearch[] = array_search($incident, $inc);
                    }

                    if (isset($keySearch)) {

                        foreach ($keySearch as $key => $ks) {
                            if ($this->tryDataDB('tb_empresa', 'descricao', $emp[$ks])) {

                                $empresa[] = $this->idReturn('tb_empresa', 'descricao', $emp[$ks]);

                            } else {

                                $testeErro["EMPRESA"][] = $this->insertIntoData('tb_empresa', $emp[$ks]);

                                $empresa[] = $this->idReturn('tb_empresa', 'descricao', $emp[$ks]);

                            }
                        }

                        if (isset($empresa)) {

                            foreach ($keySearch as $key => $ks) {
                                if ($this->tryDataDB('tb_ic', 'descricao', $ic[$ks])) {

                                    $idIC[] = $this->idReturn('tb_ic', 'descricao', $ic[$ks]);

                                } else {

                                    $testeErro["IC"][] = $this->insertIntoData('tb_ic', $ic[$ks]);

                                    $idIC[] = $this->idReturn('tb_ic', 'descricao', $ic[$ks]);

                                }
                            }

                            if (isset($idIC)) {

                                foreach ($keySearch as $key => $ks) {
                                    if ($this->tryDataDB('tb_sumario', 'descricao', $sumario[$ks])) {

                                        $sum[] = $this->idReturn('tb_sumario', 'descricao', $sumario[$ks]);

                                    } else {

                                        $testeErro["SUMARIO"][] = $this->insertIntoData('tb_sumario', $sumario[$ks]);

                                        $sum[] = $this->idReturn('tb_sumario', 'descricao', $sumario[$ks]);

                                    }
                                }

                                if (isset($sum)) {

                                    foreach ($keySearch as $key => $ks) {
                                        if ($this->tryDataDB('tb_prioridade', 'pri_descricao', $prioridade[$ks])) {

                                            $prio[] = $this->idReturn('tb_prioridade', 'pri_descricao', $prioridade[$ks]);

                                        } else {

                                            $testeErro["PRIORIDADE"][] = $this->insertIntoData('tb_prioridade', $prioridade[$ks]);

                                            $prio[] = $this->idReturn('tb_prioridade', 'pri_descricao', $prioridade[$ks]);

                                        }
                                    }

                                    if (isset($prio)) {

                                        foreach ($keySearch as $key => $ks) {
                                            if ($this->tryDataDB('tb_grupo_designado', 'grupo', $grupoDesignado[$ks])) {

                                                $grupo[] = $this->idReturn('tb_grupo_designado', 'grupo', $grupoDesignado[$ks]);

                                            } else {

                                                $testeErro["GRUPO_DESIGNADO"][] = $this->insertIntoData('tb_grupo_designado', array($grupoDesignado[$ks], $empresa[$key]));

                                                $grupo[] = $this->idReturn('tb_grupo_designado', 'grupo', $grupoDesignado[$ks]);

                                            }
                                        }

                                        if (isset($grupo)) {

                                            $data = new \DateTime();
                                            $now = new \DateTime('now');

                                            foreach ($keySearch as $key => $ks) {
                                                if ($this->tryDataDB('tb_ocorrencia', 'incidente', $incidentes[$key])) {
                                                    $testeErro["OCORRENCIA"][] = true;
                                                } else {
                                                    $cr = $data->createFromFormat("d/m/Y H:i:s", $criado[$ks]);
                                                    $rs = $data->createFromFormat("d/m/Y H:i:s", $resolvido[$ks]);

                                                    $testeErro["OCORRENCIA"][] = $this->insertIntoData(
                                                        'tb_ocorrencia',
                                                        array(
                                                            $incidentes[$key],
                                                            $cr->format("Y-m-d H:i:s"),
                                                            $rs->format("Y-m-d H:i:s"),
                                                            $descricaoProblema[$ks],
                                                            $descricaoResolvido[$ks],
                                                            $grupo[$key],
                                                            $idIC[$key],
                                                            $prio[$key],
                                                            $sum[$key],
                                                            $now->format("Y-m-d H:i:s")
                                                        )
                                                    );
                                                }
                                            }

                                            if (isset($testeErro)) {

                                                if (in_array(true, $testeErro["OCORRENCIA"])) {

                                                    if (unlink($this->getArquivosXml())) {

                                                        return "Base foi atualizada!! Arquivo " . $this->getArquivosXml() . " Excluído!";

                                                    } else {

                                                        return "Base foi atualizada!! Erro na Exclusão do Arquivo " . $this->getArquivosXml();

                                                    }
                                                }

                                            } else {

                                                throw new \Exception("ERRO: Variavel testeErro encontra-se sem valores!");

                                            }

                                        } else {

                                            throw new \Exception("ERRO: Variavel Grupo encontra-se sem valores!");

                                        }
                                    } else {

                                        throw new \Exception("ERRO: Variavel prioridade encontra-se sem valores!");

                                    }
                                } else {

                                    throw new \Exception("ERRO: Variavel sum encontra-se sem valores!");

                                }

                            } else {

                                throw new \Exception("ERRO: Variavel idIC encontra-se sem valores!");

                            }

                        } else {

                            throw new \Exception("ERRO: Variavel empresa encontra-se sem valores!");

                        }


                    } else {

                        throw new \Exception("ERRO: Variavel keySearch encontra-se sem valores!");

                    }
                } else {

                    if (unlink($this->getArquivosXml())) {
                        return "Atualização da base já foi realizada!! Arquivo " . $this->getArquivosXml() . " Excluído!";
                    } else {
                        return "Atualização da base já foi realizada!! Erro na Exclusão do Arquivo " . $this->getArquivosXml();
                    }

                }
            } else {

                $col = array("ID do Incidente*+","ID da Solicitação","Nome*+","Nome do Meio","Sumário*","Status*","Criado em","Site+","Prioridade*","Data da Última Resolução","Data de Fechamento","IC+","Empresa*+","Grupo Designado*+","Empresa de Suporte*","Grupo Proprietário+","Empresa de Suporte do Proprietário","Organização de Suporte*","Notas","Modificado por","Nível de Categorização do Produto 3","Resolução");

                throw new \Exception("ERRO: Faltam colunas na planilha XML!! \n".implode(" , ",$col));

            }
        } catch (\Exception $e) {

            return array("ERRO: ".$e->getMessage(),"Linha: ".$e->getLine(),"Arquivos: ".$e->getFile());

        }
        
    }
    
}

?>