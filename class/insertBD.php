<?php

namespace Classes;

require_once "ReadBD.php";

class InsertBD extends \Classes\ReadBD{

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

                throw new \Exception("ERRO: " . implode(" ", $sql->errorInfo())."COMANDO: ".$comando);

            }

        } catch (\Exception $e) {

            return array("ERRO: ".$e->getMessage(),"Linha: ".$e->getLine(),"Arquivos: ".$e->getFile());

        }


        
    }
    
    public function implantDataDB(){
        
        $arrayDadosXml = $this->getContainerDataXml();
        $inc = $arrayDadosXml["incidente"];
        $emp = $arrayDadosXml["empresa"];
        $ic = $arrayDadosXml["ic"];
        $sumario = $arrayDadosXml["sumario"];
        
        $incidentes = $this->analiseIncidenteDB();

        foreach ($incidentes as $incident){
            $keySearch[] = array_search($incident, $inc);
        }

        if (isset($keySearch)) {

            foreach ($keySearch as $key => $ks) {
                if ($this->tryDataDB('tb_empresa', 'descricao', $emp[$ks])) {

                    $empresa[] = $this->idReturn('tb_empresa', 'descricao', $emp[$ks]);

                }else{

                    $this->insertIntoData('tb_empresa',$emp[$ks]);

                    $empresa[] = $this->idReturn('tb_empresa', 'descricao', $emp[$ks]);

                }
            }

            if (isset($empresa)) {

                foreach ($keySearch as $key => $ks) {
                    if ($this->tryDataDB('tb_ic', 'descricao', $ic[$ks])) {

                        $idIC[] = $this->idReturn('tb_ic', 'descricao', $ic[$ks]);

                    }else{

                        $this->insertIntoData('tb_ic',$ic[$ks]);

                        $idIC[] = $this->idReturn('tb_ic', 'descricao', $ic[$ks]);

                    }
                }

                if(isset($idIC)){

                    /*foreach ($keySearch as $key => $ks) {
                        if ($this->tryDataDB('tb_sumario', 'descricao', $sumario[$ks])) {

                            $sum[] = $this->idReturn('tb_sumario', 'descricao', $sumario[$ks]);

                        }else{

                            $this->insertIntoData('tb_sumario',$ic[$ks]);

                            $sum[] = $this->idReturn('tb_sumario', 'descricao', $sumario[$ks]);

                        }
                    }*/

                    if(isset($sum)){
                        return $this->idNumTable('tb_sumario');
                    }

                }

            }


        }
        
    }
    
}

?>