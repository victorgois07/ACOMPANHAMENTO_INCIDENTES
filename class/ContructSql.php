<?php
/**
 * Created by PhpStorm.
 * User: p742651
 * Date: 05/07/2018
 * Time: 10:50
 */

namespace Classes;

require_once "ConectBD.php";

abstract class ContructSql extends ConectBD {

    private function setParams($statement, $parameters = array()){

        foreach ($parameters as $key => $value) {

            $statement->bindValue($key+1, $value);

        }

    }

    private function setParam($statement, $key, $value){

        $statement->bindValue($key+1, $value);

    }

    protected function query($rawQuery, $params = null){

        try {

            $stmt = $this->conectBD()->prepare($rawQuery);

            if (is_string($params)) {

                $this->setParam($stmt, 0, $params);

            } elseif (is_array($params)) {

                $this->setParams($stmt, $params);

            }

            $stmt->execute();

            return $stmt;

        } catch (\PDOException $e) {

            ob_end_clean();

            exit("ERRO: ".$e->getMessage()."<br/>LINHA: ".$e->getLine()."<br/>CODE: ".$e->getCode()."<br/>ARQUIVO: ".$e->getFile()."<br/>COMANDO: ".$rawQuery);

        }

    }

    protected function select($rawQuery, $params = array()):array {

        $stmt = $this->query($rawQuery, $params);

        return $stmt->fetchAll(\PDO::FETCH_NUM);
    }

    protected function insert($rawQuery, $params = array()):bool {

        try {

            $stmt = $this->conectBD()->prepare($rawQuery);

            if (is_array($params)) {

                $this->setParams($stmt, $params);

            }elseif(is_string($params)) {

                $this->setParam($stmt, 1, $params);

            }

            return $stmt->execute();

        } catch (\PDOException $e) {

            ob_end_clean();

            exit("ERRO: ".$e->getMessage()."<br/>LINHA: ".$e->getLine()."<br/>CODE: ".$e->getCode()."<br/>ARQUIVO: ".$e->getFile()."<br/>COMANDO: ".$rawQuery);

        }

    }

    protected function firstColumn($table):string{
        $dado = $this->select("DESC $table");
        return $dado[0][0];
    }

    protected function jailNumberId($table){

        $col = $this->firstColumn($table);

        $jail = $this->select("call db_table_incidentes.number_id_jail('{$col}','{$table}')");

        if (!empty($jail[0][0])) {

            return $jail[0][0];

        } else {

            return null;

        }
    }

    protected function idValueReturn($table,$column,$val){
        $col = $this->firstColumn($table);
        $jail = $this->select("SELECT $col FROM $table WHERE $column = ?",strval($val));
        if (isset($jail[0][0])) {
            return $jail[0][0];
        }
    }

    protected function dataExist($rawQuery, $params = array()):bool {

        $query = $this->query($rawQuery,$params);

        if($query->rowCount() == 0){

            return false;

        }else{

            return true;

        }
    }

    protected function arrangingArrayDB($array){
        foreach ($array as $v){
            $p[] = $v[0];
        }

        return $p;
    }

    protected function dataTimeFormatInsertDB($data):array {

        foreach($data as $dt){
            $d[] = \DateTime::createFromFormat('d/m/Y H:i:s', $dt)->format('Y-m-d h:i:s');
        }

        return $d;

    }

}

?>