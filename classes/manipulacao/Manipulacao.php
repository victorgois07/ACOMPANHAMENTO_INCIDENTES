<?php

namespace classes\manipulacao;

use DateTime;

class Manipulacao{
    public $now;

    public function __construct(DateTime $now){
        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');
        $this->now = $now;
    }

    public function h1Titulo():string{
        return "ACOMPANHAMENTO DE INCIDENTES - PERÍODO 01/".$this->getNow()->format("m/Y")." À ".$this->getNow()->format("d/m/Y");
    }

    public function tbMes(){
        return utf8_encode(strtoupper(strftime("%B/%Y")));
    }

    public function getNow(): DateTime{
        return $this->now;
    }

    public function setNow(DateTime $now): void{
        $this->now = $now;
    }

}

?>