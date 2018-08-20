<?php

namespace classes\Database;

use DateTime;
use Exception;

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

    protected function testVencido(DateTime $horas,String $prioridade):string{

        $dBaixo = new DateTime('08:00:00');
        $dAlto = new DateTime('04:00:00');
        $dMedia = new DateTime('06:00:00');
        $dCritico = new DateTime('02:00:00');


        switch ($prioridade){

            case "Baixo":

                return $horas > $dBaixo?$horas->diff($dBaixo)->format('%H:%I:%S'):"NO PRAZO";

                break;

            case "Média":

                return $horas > $dMedia?$horas->diff($dBaixo)->format('%H:%I:%S'):"NO PRAZO";

                break;

            case "Alto":

                return $horas > $dAlto?$horas->diff($dBaixo)->format('%H:%I:%S'):"NO PRAZO";

                break;

            case "Crítico":

                return $horas > $dCritico?$horas->diff($dBaixo)->format('%H:%I:%S'):"NO PRAZO";

                break;

        }
    }

    protected function arrangingArrayMultDB(Array $array):array {

        $datetime = new DateTime();

        try {

            foreach ($array as $key => $v) {

                $venc8 = $this->testVencido(new DateTime($v[3]),'Baixo');
                $vencP = $this->testVencido(new DateTime($v[3]),$v[7]);
                $empresa = explode(" ",$v[6]);
                $empresa = count($empresa) == 1?$empresa[0]:$empresa[0]." ".$empresa[1];

                $p[] = array(
                    $v[0],
                    $v[8],
                    $v[4],
                    $v[7],
                    $datetime::createFromFormat('Y-m-d H:i:s',$v[1])->format('d/m/Y H:i:s'),
                    $datetime::createFromFormat('Y-m-d H:i:s',$v[2])->format('d/m/Y H:i:s'),
                    $v[3],
                    $venc8,
                    $vencP,
                    $v[5],
                    $empresa
                );

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


    public function toStringDataBase($stringData){

        switch ($stringData){

            case "Até 2h":

                $comando = $this->arrangingArrayMultDB($this->select("CALL dataTableDB(?,?,?,?)",array('Até 2h',7200,0,$this->getNow()->format("Y-m-%"))));

                break;

            case "Até 4h":

                $comando = $this->arrangingArrayMultDB($this->select("CALL dataTableDB(?,?,?,?)",array('Até 4h',14400,7200,$this->getNow()->format("Y-m-%"))));

                break;

            case "Até 6h":

                $comando = $this->arrangingArrayMultDB($this->select("CALL dataTableDB(?,?,?,?)",array('Até 6h',21600,14400,$this->getNow()->format("Y-m-%"))));

                break;

            case "Até 8h":

                $comando = $this->arrangingArrayMultDB($this->select("CALL dataTableDB(?,?,?,?)",array('Até 8h',28800,21600,$this->getNow()->format("Y-m-%"))));

                break;

            case "Superior à 8h":

                $comando = $this->arrangingArrayMultDB($this->select("CALL dataTableDB(?,?,?,?)",array('Superior à 8h',28800,0,$this->getNow()->format("Y-m-%"))));

                break;

            case "TOTAL":

                $comando = $this->arrangingArrayMultDB($this->select("CALL dataTableDB(?,?,?,?)",array('TOTAL',0,0,$this->getNow()->format("Y-m-%"))));

                break;

        }

        return $comando;

    }

    private function selectMesesJson(){
        return $this->arrangingArrayDB($this->select("SELECT DISTINCT(DATE_FORMAT(inc_resolvido,'%M-%Y')) as meses FROM bip_inc_incidente ORDER BY inc_resolvido"));
    }

    public function view_json_meses(){
        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json');
        echo json_encode($this->selectMesesJson());
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