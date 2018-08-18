<?php

namespace classes\Database;

use DateTime;

require_once "Dao.php";

final class Read extends Dao {

    public $now,$datetime,$total;

    public function __construct(DateTime $dateTime){
        parent::__construct();
        $tot = $this->select("SELECT COUNT(*) FROM bip_inc_incidente WHERE inc_resolvido LIKE ?",array($dateTime->format("Y-m-%")));
        $this->now = $dateTime;
        $this->total = $tot[0][0];
    }


    protected function switchDataTimeCol(int $time):int{

        switch ($time){

            case 7200:

                $comando = $this->select("SELECT COUNT(*) FROM bip_inc_incidente WHERE inc_resolvido LIKE ? AND TIMESTAMPDIFF(SECOND, inc_criado,inc_resolvido) <= 7200",array($this->getNow()->format("Y-m-%")));

                return !empty($comando[0][0]) && isset($comando[0][0])?$comando[0][0]:0;

                break;

            case 14400:

                $comando = $this->select("SELECT COUNT(*) FROM bip_inc_incidente WHERE inc_resolvido LIKE ? AND TIMESTAMPDIFF(SECOND, inc_criado,inc_resolvido) <= 14400 AND TIMESTAMPDIFF(SECOND, inc_criado,inc_resolvido) > 7200",array($this->getNow()->format("Y-m-%")));

                return !empty($comando[0][0]) && isset($comando[0][0])?$comando[0][0]:0;

                break;

            case 21600:

                $comando = $this->select("SELECT COUNT(*) FROM bip_inc_incidente WHERE inc_resolvido LIKE ? AND TIMESTAMPDIFF(SECOND, inc_criado,inc_resolvido) <= 21600 AND TIMESTAMPDIFF(SECOND, inc_criado,inc_resolvido) > 14400",array($this->getNow()->format("Y-m-%")));

                return !empty($comando[0][0]) && isset($comando[0][0])?$comando[0][0]:0;

                break;

            case 28800:

                $comando = $this->select("SELECT COUNT(*) FROM bip_inc_incidente WHERE inc_resolvido LIKE ? AND TIMESTAMPDIFF(SECOND, inc_criado,inc_resolvido) <= 28800 AND TIMESTAMPDIFF(SECOND, inc_criado,inc_resolvido) > 21600",array($this->getNow()->format("Y-m-%")));

                return !empty($comando[0][0]) && isset($comando[0][0])?$comando[0][0]:0;

                break;

            default:

                $comando = $this->select("SELECT COUNT(*) FROM bip_inc_incidente WHERE inc_resolvido LIKE ? AND TIMESTAMPDIFF(SECOND, inc_criado,inc_resolvido) > 28800",array($this->getNow()->format("Y-m-%")));

                return !empty($comando[0][0]) && isset($comando[0][0])?$comando[0][0]:0;

                break;

        }

    }

    protected function stringhoras(int $key){
        if($key == 0){
            return "Até 2h";
        }elseif ($key == 1){
            return "Até 4h";
        }elseif ($key == 2){
            return "Até 6h";
        }elseif ($key == 3){
            return "Até 8h";
        }elseif ($key == 4){
            return "Superior à 8h";
        }
    }

    protected function acumuladoData(int $value){
        if($value > 100){
            return "100%";
        }else{
            return $value."%";
        }
    }

    protected function countScheduleIncidenteCol():array {

        $comando = array(
            $this->switchDataTimeCol(7200),
            $this->switchDataTimeCol(14400),
            $this->switchDataTimeCol(21600),
            $this->switchDataTimeCol(28800),
            $this->switchDataTimeCol(0),
        );

        $porc = 0;

        foreach ($comando as $key => $cmd){

            $arrayPost[] = array(
                $this->stringhoras($key),
                $cmd,
                round(($cmd / $this->getTotal())*100)."%",
                $this->acumuladoData(($porc += round(($cmd / $this->getTotal()) * 100)))
            );

        }

        $tot = array(
            "TOTAL",
            "TOTAL",
            $this->getTotal(),
            "100%"
        );

        array_push($arrayPost,$tot);

        return $arrayPost;

    }

    public function readTbody(){

        return $this->countScheduleIncidenteCol();

    }

    public function getNow(): DateTime{
        return $this->now;
    }

    public function setNow(DateTime $now): void{
        $this->now = $now;
    }

    public function getTotal(){
        return $this->total;
    }

    public function setTotal($total): void{
        $this->total = $total;
    }


}

?>