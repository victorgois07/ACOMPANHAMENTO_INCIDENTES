<?php
namespace Classes;

require_once "ConectBD.php";

class ReadBD extends ConectBD{
    public $obj,$inc;

    public function __construct($obj,$inc){
        parent::__construct();
        $this->obj = $obj;
        $this->inc = $inc;
    }

    public function col_grupo_empresa(){
        $empresa = $this->getObj()->empresa;
        $grupo = array_unique($this->getObj()->grupo);
        $key_grupo = array_keys($grupo);


        foreach ($key_grupo as $k => $g){
            $emp[] = $empresa[$g];
            $ex = explode(" ",$empresa[$g]);

            if($ex[0] == "B2BR"){
                $resul[] = $grupo[$g]." * +2X";
            }else{
                $resul[] = $grupo[$g]." * ".$ex[0];
            }
        }

        if (isset($resul)) {
            return $resul;
        }
    }

    private function calcutoArrayIncidente(){
        foreach ($this->getInc() as $v){
            $sql = $this->conectBD()->prepare("SELECT `criado`,`resolucao` FROM `tb_ocorrencia` WHERE `incidente` = '{$v}'");
            if($sql->execute()){
                $d = $sql->fetchAll(\PDO::FETCH_NUM);

                if (isset($d[0])) {
                    $result[$v] = $d[0];
                }
                
            }else{
                return $sql->errorInfo();
            }
        }

        if (isset($result)) {
            foreach ($result as $k => $r){
                $comando = $this->conectBD()->prepare("SELECT TIMESTAMPDIFF(SECOND,'{$r[0]}','{$r[1]}')");
                if($comando->execute()){
                    $f = $comando->fetchAll(\PDO::FETCH_NUM);
                    $dado[$k] = intval($f[0][0]);
                }else{
                    return $comando->errorInfo();
                }
            }
        }

        if(isset($dado)){
            return $dado;
        }
    }

    public function divisaoTempo(){
        $q = array(1,1,1,1,1);
        $hora = array(0,0,0,0,0);
        foreach ($this->calcutoArrayIncidente() as $k => $v) {
            if(7200 >= $v){
                $hora[0] = $q[0]++;
            }elseif (14400 >= $v && 7200 < $v){
                $hora[1] = $q[1]++;
            }elseif (14400 < $v && 21600 >= $v){
                $hora[2] = $q[2]++;
            }elseif (28800 >= $v && 21600 < $v){
                $hora[3] = $q[3]++;
            }elseif (28800 < $v){
                $hora[4] = $q[4]++;
            }
        }

        if (isset($hora)) {
            return $hora;
        }
    }

    public function calcPorcentagemTemp($dado,$tot){
        
        foreach ($dado as $v){
            $porcent[] = round(($v / $tot) * 100,1);
        }

        if (isset($porcent)) {
            return $porcent;
        }
    }

    public function totalIncidente($mes){
        $sql = $this->conectBD()->prepare("SELECT `tb_ocorrencia`.`incidente` FROM `tb_ocorrencia` WHERE MONTH(`resolucao`) = '{$mes}'");
        if($sql->execute()){
            return $sql->rowCount();
        }else{
            return $sql->errorInfo();
        }
    }

    public function todosIncidentes(){
        $sql = $this->conectBD()->prepare("SELECT `incidente` FROM `tb_ocorrencia` ORDER BY `incidente` ASC");

        if($sql->execute()){
            foreach ($sql->fetchAll(\PDO::FETCH_NUM) as $k => $var){
                $dado[] = $var[0];
            }

            if(isset($dado)) {
                $incidente = $this->getObj()->incidente;

                $diff = array_diff($incidente,$dado);

                return $diff;
            }
        }else{
            return $sql->errorInfo();
        }
    }

    public function getObj(){
        return $this->obj;
    }

    public function setObj($obj){
        $this->obj = $obj;
    }

    public function getInc(){
        return $this->inc;
    }

    public function setInc($inc){
        $this->inc = $inc;
    }
}

?>