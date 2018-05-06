<?php

require_once "ConectBD.php";

class ManipulacaoDados extends \Classes\ConectBD{
    public $mes;
    public $dia;
    public $ano;
    private $caminho,$arquivo;

    public function __construct(){
        parent::__construct();
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
    
    public function optionSqlData(){
        
        try {
            
            $sql = $this->conectBD()->prepare("SELECT DISTINCT(CONCAT(MONTHNAME(resolucao),'/',YEAR(resolucao))),CONCAT(YEAR(resolucao),'-',LPAD(MONTH(resolucao), 2, '0')) FROM tb_ocorrencia ORDER BY resolucao");

            if ($sql->execute()) {

                foreach ($sql->fetchAll(\PDO::FETCH_NUM) as $val) {

                    $dado[] = array($val[0],$val[1]);

                }
                
                if(isset($dado)){
                    
                    return $dado;
                    
                }else{

                    throw new \Exception("ERRO: Variavel dado encontra-se sem valores!");
                    
                }

            } else {

                throw new \Exception("ERRO: " . implode(" ", $sql->errorInfo()));

            }
        } catch (\Exception $e) {

            return array("ERRO: ".$e->getMessage(),"Linha: ".$e->getLine(),"Arquivos: ".$e->getFile());
            
        }
        
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