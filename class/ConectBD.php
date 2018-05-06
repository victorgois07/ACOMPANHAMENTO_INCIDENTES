<?php

namespace Classes;

require_once "ManipuladorExcel.php";

class ConectBD extends ManipuladorExcel{
    private $host, $root, $password;
    protected $bd;

    public function __construct(){
        parent::__construct();
        $this->host = "localhost";
        $this->root = "root";
        $this->password = "";
        $this->bd = "db_table_incidentes";
    }

    protected function conectBD(){
        $PDO = new \PDO('mysql:host='.$this->getHost().';dbname='.$this->getBd(),$this->getRoot(),$this->getPassword());
        $PDO->exec("set names utf8");
        if ($PDO){
            return $PDO;
        }else{
            return "Erro ao conectar com o MySQL";
        }
    }

    public function getHost(){
        return $this->host;
    }

    public function setHost($host){
        $this->host = $host;
    }

    public function getRoot(){
        return $this->root;
    }

    public function setRoot($root){
        $this->root = $root;
    }

    public function getPassword(){
        return $this->password;
    }

    public function setPassword($password){
        $this->password = $password;
    }

    public function getBd(){
        return $this->bd;
    }

    public function setBd($bd){
        $this->bd = $bd;
    }


}

?>