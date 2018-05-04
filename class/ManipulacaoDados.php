<?php

class ManipulacaoDados{
    public $mes;
    public $dia;
    public $ano;
    private $caminho,$arquivo;

    public function __construct(){
        $this->mes = date("m");
        $this->dia = date("d");
        $this->ano = date("Y");
        $this->caminho = null;
    }

    public function h1InforDate(){
        $this->formatPTBR();
        return "01/".$this->mes."/".$this->ano." à ".date("d/m/Y");
    }

    private function formatPTBR(){
        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');
    }

    public function printr($data) {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }

    public function getMes(){
        return $this->mes;
    }

    public function setMes($mes){
        $this->mes = $mes;
    }

    public function getDia(){
        return $this->dia;
    }

    public function setDia($dia){
        $this->dia = $dia;
    }

    public function getAno(){
        return $this->ano;
    }

    public function setAno($ano){
        $this->ano = $ano;
    }

    public function getCaminho(){
        return $this->caminho;
    }

    public function setCaminho($caminho){
        $this->caminho = $caminho;
    }

    public function getArquivo(){
        return $this->arquivo;
    }

    public function setArquivo($arquivo){
        $this->arquivo = $arquivo;
    }
}

?>