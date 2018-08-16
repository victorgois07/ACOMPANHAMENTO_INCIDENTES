<?php

namespace classes\Database;

use DateTime;
use PDOException;

final class Create extends Dao {

    protected function comandoInsertMult($table,$cols,$values):string{

        $comando = "INSERT INTO $table ";

        if (count($cols) > 1) {
            foreach ($cols as $key => $c) {

                if ($key == 0) {

                    $comando .= "(" . $c . ",";

                } elseif (count($cols) - 1 == $key) {

                    $comando .= $c . ") VALUES (";

                } else {

                    $comando .= $c . ",";

                }

            }
        }else{
            $comando .= "(".$cols.") VALUES ";
        }

        if(count($cols) == 1){

            foreach ($values as $key => $value){

                if(count($values)-1 == $key){

                    $comando .= "(?)";

                }else{

                    $comando .= "(?),";

                }

            }

        }else{

            foreach ($values as $key => $value){

                foreach ($cols as $k => $c){

                    if(count($cols)-1 == $k){

                        $comando .= "?)";

                    }else{

                        $comando .= "?,";

                    }

                }

                if (count($values)-1 != $key) {
                    $comando .= ",(";
                }

            }

        }

        return $comando;

    }

    protected function dataColExcel($key){

        $excelData = $this->excelData->organizeArrayExcel();

        $indice = $this->excelData->getIndice();

        foreach ($excelData as $excel) {
            $data[] = $excel[array_search($key,$indice)];
        }

        // Remove os valores nulos
        $array = array_filter(array_unique($data));

        // Recria as chaves do array
        $array = array_values($array);

        return $array;

    }

    protected function filtroExistArrayExcelData($key,$table,$col){

        foreach ($this->dataColExcel($key) as $data){
            if($this->dataExist("SELECT * FROM $table WHERE $col = ?",array($data)) == false){
                $noExist[] = $data;
            }
        }

        if(!empty($noExist) && isset($noExist)){

            return $noExist;

        }else{

            return false;

        }

    }

    protected function filtroGrupoDesignadoExcelData() {

        try {

            $excelData = $this->excelData->organizeArrayExcel();

            $indice = $this->excelData->getIndice();

            foreach ($excelData as $excel) {
                $dataEmpresa[] = $excel[array_search("Empresa de Suporte*", $indice)];
                $dataGrupo[] = $excel[array_search("Grupo Designado*+", $indice)];
            }

            $dataGrupo = array_unique($dataGrupo);

            foreach (array_unique($dataGrupo) as $key => $unique) {

                if ($this->dataExist("SELECT * FROM bip_grs_grupo_designado WHERE grs_descricao = ?", array($unique)) == false) {

                    $dataUniqueGrupoEmpresa[] = array($unique,$this->idValueReturn("bip_emp_empresa", "emp_descricao", $dataEmpresa[$key]));

                }

            }

            if (!empty($dataUniqueGrupoEmpresa) && isset($dataUniqueGrupoEmpresa)) {

                return $dataUniqueGrupoEmpresa;

            } else {

                return false;

            }

        } catch (PDOException $e) {

            ob_end_clean();

            $arrayTry = implode(", ",$dataUniqueGrupoEmpresa);

            exit("ERRO: ".$e->getMessage()."<br/>LINHA: ".$e->getLine()."<br/>CODE: ".$e->getCode()."<br/>ARQUIVO: ".$e->getFile()."<br/>DATA: ".$arrayTry);

        }

    }


    protected function insertColsDataGrupos():string {

        foreach ($this->filtroGrupoDesignadoExcelData() as $key => $insert) {
            $this->insert("INSERT INTO bip_grs_grupo_designado (grs_descricao, grs_emp_empresa_id) VALUES (?,?)", $insert);
        }

        return true;
    }

    protected function dataInsertFinal():array {

        $excelData = $this->excelData->organizeArrayExcel();

        $indice = $this->excelData->getIndice();

        $datetime = new DateTime();

        foreach ($excelData as $excel) {

            if ($this->dataExist("SELECT * FROM bip_inc_incidente WHERE inc_codigo_incidente = ?",array($excel[array_search("ID do Incidente*+", $indice)])) == false) {
                $c = $datetime::createFromFormat("d/m/Y H:i:s", $excel[array_search("Criado em", $indice)]);
                $r = $datetime::createFromFormat("d/m/Y H:i:s", $excel[array_search("Data da Última Resolução", $indice)]);

                $dataIncidente[] = array(
                    $excel[array_search("ID do Incidente*+", $indice)],
                    $c->format("Y-m-d H:i:s"),
                    $r->format("Y-m-d H:i:s"),
                    $excel[array_search("Notas", $indice)],
                    $excel[array_search("Resolução", $indice)],
                    $this->idValueReturn("bip_sum_sumario", "sum_descricao", $excel[array_search("Sumário*", $indice)]),
                    $this->idValueReturn("bip_grs_grupo_designado", "grs_descricao", $excel[array_search("Grupo Designado*+", $indice)]),
                    $this->idValueReturn("bip_pri_prioridade", "pri_descricao", $excel[array_search("Prioridade*", $indice)]),
                    $this->idValueReturn("bip_coi_codigo_ic", "coi_descricao", $excel[array_search("IC+", $indice)])
                );
            }

        }

        if (isset($dataIncidente) && !empty($dataIncidente)) {

            return $dataIncidente;

        }else{

            return null;

        }
    }


    protected function insertIncidenteFinal(){

        foreach ($this->dataInsertFinal() as $insert){
            $this->insert("INSERT INTO bip_inc_incidente (inc_codigo_incidente, inc_criado, inc_resolvido, inc_decricao_problema, inc_descricao_resolucao, inc_sum_sumario_id, inc_grs_grupo_designado_id, inc_pri_prioridade_id, inc_coi_codigo_ic_id) VALUES (?,?,?,?,?,?,?,?,?)",$insert);
        }

        return true;
    }

    public function insertColsData():string{

        $e=0;

        if ($this->filtroExistArrayExcelData("IC+","bip_coi_codigo_ic","coi_descricao") != false) {

            $this->insert($this->comandoInsertMult("bip_coi_codigo_ic", "coi_descricao", $this->filtroExistArrayExcelData("IC+", "bip_coi_codigo_ic", "coi_descricao")), $this->filtroExistArrayExcelData("IC+", "bip_coi_codigo_ic", "coi_descricao"));

        }else{

            $e++;

        }

        if ($this->filtroExistArrayExcelData("Empresa de Suporte*", "bip_emp_empresa", "emp_descricao") != false) {

            $this->insert($this->comandoInsertMult("bip_emp_empresa", "emp_descricao", $this->filtroExistArrayExcelData("Empresa de Suporte*", "bip_emp_empresa", "emp_descricao")), $this->filtroExistArrayExcelData("Empresa de Suporte*", "bip_emp_empresa", "emp_descricao"));

        }else{

            $e++;

        }

        if ($this->filtroExistArrayExcelData("Prioridade*", "bip_pri_prioridade", "pri_descricao") != false) {

            $this->insert($this->comandoInsertMult("bip_pri_prioridade", "pri_descricao", $this->filtroExistArrayExcelData("Prioridade*", "bip_pri_prioridade", "pri_descricao")), $this->filtroExistArrayExcelData("Prioridade*", "bip_pri_prioridade", "pri_descricao"));

        }else{

            $e++;

        }

        if ($this->filtroExistArrayExcelData("Sumário*", "bip_sum_sumario", "sum_descricao") != false) {

            $this->insert($this->comandoInsertMult("bip_sum_sumario", "sum_descricao", $this->filtroExistArrayExcelData("Sumário*", "bip_sum_sumario", "sum_descricao")), $this->filtroExistArrayExcelData("Sumário*", "bip_sum_sumario", "sum_descricao"));

        }else{

            $e++;
        }

        if ($this->filtroGrupoDesignadoExcelData() !=  false) {

            $this->insertColsDataGrupos();

        }else{

            $e++;
        }

        if ($this->dataInsertFinal() !=  null) {

            $this->insertIncidenteFinal();

        }else{

            $e++;
        }

        return $e == 6?"BASE JÁ FOI ATUALIZADA":"BASE ATUALIZADA COM SUCESSO!";



    }

}

?>