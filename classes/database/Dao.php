<?php

namespace classes\database;

use DateTime;
use Exception;
use PDO;
use PDOException;
use PDOStatement;

require_once "Database.php";

abstract class Dao extends Database {

    protected function setParams(PDOStatement $statement, $parameters = array()){

        try {

            foreach ($parameters as $key => $value) {

                $statement->bindValue($key+1, $value);

            }

        } catch (PDOException $e) {

            ob_end_clean();

            $par = implode(", ",$parameters);

            exit("ERRO: ".$e->getMessage()."<br/>LINHA: ".$e->getLine()."<br/>CODE: ".$e->getCode()."<br/>ARQUIVO: ".$e->getFile()."<br/>PARAMETERS: ".$par);

        }

    }

    protected function setParam(PDOStatement $statement, int $key, String $value){

        try {

            $statement->bindValue($key, $value);

        } catch (PDOException $e) {

            ob_end_clean();

            exit("ERRO: ".$e->getMessage()."<br/>LINHA: ".$e->getLine()."<br/>CODE: ".$e->getCode()."<br/>ARQUIVO: ".$e->getFile()."<br/>PARAMETERS: ".$value);

        }

    }

    protected function funcQuery(String $rawQuery, $params = array()){

        try {

            $stmt = $this->conn->prepare($rawQuery);

            if (is_array($params)) {

                $this->setParams($stmt, $params);

            }elseif(is_string($params)) {

                $this->setParam($stmt, 1, $params);

            }

            $stmt->execute();

            return $stmt;

        } catch (PDOException $e) {

            ob_end_clean();

            exit("ERRO: ".$e->getMessage()."<br/>LINHA: ".$e->getLine()."<br/>CODE: ".$e->getCode()."<br/>ARQUIVO: ".$e->getFile()."<br/>COMANDO: ".$rawQuery);

        }

    }

    protected function select(String $rawQuery, Array $params = array()):array{

        $stmt = $this->funcQuery($rawQuery, $params);

        return $stmt->fetchAll(PDO::FETCH_BOTH);

    }

    protected function insert($rawQuery, $params = array()):bool {

        try {

            $this->conn->beginTransaction();

            $stmt = $this->conn->prepare($rawQuery);

            if (is_array($params)) {

                $this->setParams($stmt, $params);

            }elseif(is_string($params)) {

                $this->setParam($stmt, 1, $params);

            }

            $this->conn->commit();

            return $stmt->execute();

        } catch (PDOException $e) {

            try {

                $this->conn->rollBack();

            } catch (PDOException $e) {

                ob_end_clean();

                $arrayTry = implode(", ",$params);

                $error = implode(", ",$stmt->errorInfo());


                exit("ERRO: ".$e->getMessage()."<br/>LINHA: ".$e->getLine()."<br/>CODE: ".$e->getCode()."<br/>ARQUIVO: ".$e->getFile()."<br/>COMANDO: ".$rawQuery."<br/>ERROSQL: ".$error."<br/>DATA: ".$arrayTry);
            }

            ob_end_clean();

            exit("ERRO: ".$e->getMessage()."<br/>LINHA: ".$e->getLine()."<br/>CODE: ".$e->getCode()."<br/>ARQUIVO: ".$e->getFile()."<br/>COMANDO: ".$rawQuery);

        }

    }

    protected function firstColumn(String $table):string{

        $dado = $this->select("DESC $table");

        return $dado[0][0];

    }

    protected function jailNumberId(String $table):int{

        try {

            $col = $this->firstColumn($table);

            $jail = $this->select("SELECT COUNT($col) FROM $table");

            if (!empty($jail[0][0])) {

                for ($i = 1; $i < $jail[0][0]; $i++) {

                    if ($this->dataExist("SELECT * FROM $col WHERE $col = ?", strval($i)) == false) {

                        $num = $i;

                        break;

                    }

                }

                return $num;

            } else {

                return null;

            }

        } catch (Exception $e) {

            ob_end_clean();

            exit("ERRO: ".$e->getMessage()."<br/>LINHA: ".$e->getLine()."<br/>CODE: ".$e->getCode()."<br/>ARQUIVO: ".$e->getFile());

        }

    }

    protected function idValueReturn(String $table, String $column, String $val):string {

        try {

            $col = $this->firstColumn($table);

            $jail = $this->select("SELECT $col FROM $table WHERE $column = ?", array($val));

            if (isset($jail[0][0])) {

                return $jail[0][0];

            }else{

                throw new Exception("ERRO: Variavel jail encontra-se sem valores!");

            }

        } catch (Exception $e) {

            ob_end_clean();

            exit("ERRO: ".$e->getMessage()."<br/>LINHA: ".$e->getLine()."<br/>CODE: ".$e->getCode()."<br/>ARQUIVO: ".$e->getFile());

        }

    }

    protected function dataExist(String $rawQuery, $params = array()):bool {

        try {

            $query = $this->funcQuery($rawQuery, $params);

            if ($query->rowCount() == 0) {

                return false;

            } else {

                return true;

            }

        } catch (Exception $e) {

            ob_end_clean();

            exit("ERRO: ".$e->getMessage()."<br/>LINHA: ".$e->getLine()."<br/>CODE: ".$e->getCode()."<br/>ARQUIVO: ".$e->getFile());

        }

    }

    protected function arrangingArrayDB(Array $array):array {

        try {

            foreach ($array as $v) {

                $p[] = $v[0];

            }

            if (isset($p)) {

                return $p;

            }else{

                throw new Exception("ERRO: Variavel p encontra-se sem valores!");

            }

        } catch (Exception $e) {

            ob_end_clean();

            exit("ERRO: ".$e->getMessage()."<br/>LINHA: ".$e->getLine()."<br/>CODE: ".$e->getCode()."<br/>ARQUIVO: ".$e->getFile());

        }

    }

    protected function dataTimeFormatInsertDB(Array $data):array {

        try {

            foreach ($data as $dt) {

                $d[] = DateTime::createFromFormat('d/m/Y H:i:s', $dt)->format('Y-m-d h:i:s');

            }

            if (isset($d)) {

                return $d;

            }else{

                throw new Exception("ERRO: Variavel d encontra-se sem valores!");

            }

        } catch (Exception $e) {

            ob_end_clean();

            exit("ERRO: ".$e->getMessage()."<br/>LINHA: ".$e->getLine()."<br/>CODE: ".$e->getCode()."<br/>ARQUIVO: ".$e->getFile());

        }

    }

    protected function removeString(String $string, Array $caractere):string{

        try {

            return str_replace($caractere, "", $string);

        } catch (Exception $e) {

            ob_end_clean();

            exit("ERRO: ".$e->getMessage()."<br/>LINHA: ".$e->getLine()."<br/>CODE: ".$e->getCode()."<br/>ARQUIVO: ".$e->getFile());

        }
    }

}

?>