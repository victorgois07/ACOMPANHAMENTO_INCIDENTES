<?php

namespace classes\Database;

use ExcelData;
use PDO;
use PDOException;

abstract class Database extends PDO {
    protected $conn,$excelData;

    public function __construct(){

        try {

            $this->conn = new PDO("mysql:host=localhost;dbname=bip_base_incidente_painel","root","",
                array(
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"
                )
            );

            $this->conn->exec("SET lc_time_names = 'pt_BR'");

            $this->excelData = new ExcelData();

        } catch (PDOException $e) {

            ob_end_clean();

            exit("ERRO: ".$e->getMessage()."<br/>LINHA: ".$e->getLine()."<br/>CODE: ".$e->getCode()."<br/>ARQUIVO: ".$e->getFile());

        }

    }

    public function getExcelData(): ExcelData{
        return $this->excelData;
    }

    public function setExcelData(ExcelData $excelData): void{
        $this->excelData = $excelData;
    }

}