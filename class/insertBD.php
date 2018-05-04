<?php

/**
 * Created by PhpStorm.
 * User: p742651
 * Date: 23/03/2018
 * Time: 08:17
 */

require_once "ConectBD.php";

class insertBD extends ConectBD{
    public $obj;

    public function __construct($obj){
        parent::__construct();
        $this->obj = $obj;
    }

    protected function firstTable($table){
        $sql = $this->conectBD()->query("DESC `$table`");
        $dado = $sql->fetchAll(\PDO::FETCH_NUM);
        return $dado[0][0];
    }

    protected function idNumTable($table){
        $comando = "SELECT `".$this->firstTable($table)."` FROM `$table` ORDER BY `".$this->firstTable($table)."` ASC";

        $sql = $this->conectBD()->query($comando);

        $order = $sql->fetchAll(\PDO::FETCH_NUM);

        $i=0;

        foreach ($order as $o){
            $d[$i] = $o[0];
            $i++;
        }

        if (isset($d)) {

            for($i=1; $i < $d[count($d)-1]; $i++){
                if(!in_array($i,$d)){
                    $exist[] = $i;
                }
            }

            if (isset($exist)) {
                return $exist[0];
            }else{
                return count($d)+1;
            }
        }else{
            return null;
        }
    }

    protected function idReturn($table,$column,$val){
        $id = $this->firstTable($table);
        $sql = $this->conectBD()->prepare("SELECT `$id` FROM `$table` WHERE `$column` = '{$val}'");

        if($sql){
            $sql->execute();
            $var = $sql->fetchAll(\PDO::FETCH_NUM);
            if (isset($var[0][0])) {
                return $var[0][0];
            }
        }else{
            $this->mysql_error($sql);
        }
    }
    
    private function db_insert_empresa(){
        $empresa = $this->getObj()->keyOrganizarOrdem($this->getObj()->empresa);
        $resgistro = 0;
        foreach ($empresa as $emp){
            $comando = $this->conectBD()->prepare("SELECT `descricao` FROM `tb_empresa` WHERE `descricao` = '{$emp}'");

            if($comando->execute()){
                if($comando->rowCount() == 0){
                    $sql = $this->conectBD()->prepare("INSERT INTO `tb_empresa` (`id_empresa`,`descricao`) VALUES ('{$this->idNumTable('tb_empresa')}','{$emp}')");

                    if($sql->execute()){
                        $resgistro++;
                    }else{
                        return $comando->errorInfo();
                        break;
                    }
                }
            }else{
                return $comando->errorInfo();
                break;
            }
        }

        return $resgistro;
    }

    private function db_insert_grupo(){
        $grupo = array_unique($this->getObj()->grupo);
        $empresa = $this->getObj()->empresa;
        $resgistro = 0;

        foreach ($grupo as $k => $g){
            $comando = $this->conectBD()->prepare("SELECT `grupo` FROM `tb_grupo_designado` WHERE `grupo` = '{$g}'");

            if($comando->execute()){
                if($comando->rowCount() == 0){
                    $sql = $this->conectBD()->prepare("INSERT INTO `tb_grupo_designado` (`id_grupo_designado`,`grupo`,`fk_empresa`) VALUES ('{$this->idNumTable('tb_grupo_designado')}','{$g}','{$this->idReturn('tb_empresa','descricao',$empresa[$k])}')");

                    if($sql->execute()){
                        $resgistro++;
                    }else{
                        return $comando->errorInfo();
                        break;
                    }
                }
            }else{
                return $comando->errorInfo();
                break;
            }
        }

        return $resgistro;
    }

    private function db_insert_ic(){
        $ic = $this->getObj()->keyOrganizarOrdem($this->getObj()->ic);
        $resgistro = 0;
        foreach ($ic as $IC){
            $comando = $this->conectBD()->prepare("SELECT `descricao` FROM `tb_ic` WHERE `descricao` = '{$IC}'");

            if($comando->execute()){
                if($comando->rowCount() == 0){
                    $sql = $this->conectBD()->prepare("INSERT INTO `tb_ic` (`id_ic`,`descricao`) VALUES ('{$this->idNumTable('tb_ic')}','{$IC}')");

                    if($sql->execute()){
                        $resgistro++;
                    }else{
                        return $comando->errorInfo();
                        break;
                    }
                }
            }else{
                return $comando->errorInfo();
                break;
            }
        }

        return $resgistro;
    }

    private function db_insert_sumario(){
        $sumario = $this->getObj()->keyOrganizarOrdem($this->getObj()->sumario);
        $resgistro = 0;
        foreach ($sumario as $sum){
            $comando = $this->conectBD()->prepare("SELECT `descricao` FROM `tb_sumario` WHERE `descricao` = '{$sum}'");

            if($comando->execute()){
                if($comando->rowCount() == 0){
                    $sql = $this->conectBD()->prepare("INSERT INTO `tb_sumario` (`id_sumario`,`descricao`) VALUES ('{$this->idNumTable('tb_sumario')}','{$sum}')");

                    if($sql->execute()){
                        $resgistro++;
                    }else{
                        return $comando->errorInfo();
                        break;
                    }
                }
            }else{
                return $comando->errorInfo();
                break;
            }
        }

        return $resgistro;
    }

    private function dateTimeFormat($dateTime){

        $date = new DateTime();

        foreach ($dateTime as $dt){
            $format = $date->createFromFormat("d/m/Y H:i:s",$dt);
            $dataHora[] = $format->format("Y-m-d H:i:s");
        }

        if(isset($dataHora)){
            return $dataHora;
        }
    }

    public function todosIncidentes(){
        $sql = $this->conectBD()->prepare("SELECT `incidente` FROM `tb_ocorrencia` ORDER BY `incidente` ASC");

        if($sql->execute()){
            foreach ($sql->fetchAll(\PDO::FETCH_NUM) as $k => $var){
                $dado[] = $var[0];
            }

            if(isset($dado)) {
                return $dado;
            }
        }else{
            return $sql->errorInfo();
        }
    }

    private function db_insert_ocorrencia(){
        $incidente = array_diff($this->getObj()->incidente,$this->todosIncidentes());
        $criado = $this->dateTimeFormat($this->getObj()->criado);
        $resolvido = $this->dateTimeFormat($this->getObj()->resolvido);
        $nota = $this->getObj()->nota;
        $resolucao = $this->getObj()->resolucao;
        $grupo = $this->getObj()->grupo;
        $ic = $this->getObj()->ic;
        $prioridade = $this->getObj()->prioridade;
        $sumario = $this->getObj()->sumario;
        $resgistro = 0;

        foreach ($incidente as $k => $inc){
            $comando = $this->conectBD()->prepare("SELECT `incidente` FROM `tb_ocorrencia` WHERE `incidente` = '{$inc}'");
            if($comando->execute()){
                if($comando->rowCount() == 0){
                    $sql = $this->conectBD()->prepare("INSERT INTO `tb_ocorrencia` (`incidente`,`criado`,`resolucao`,`descricao_problema`,`descricao_solucao`,`fk_grupo_designado`,`fk_ic`,`fk_prioridade`,`fk_sumario`) VALUES ('{$inc}','{$criado[$k]}','{$resolvido[$k]}','{$nota[$k]}','{$resolucao[$k]}','{$this->idReturn('tb_grupo_designado','grupo',$grupo[$k])}','{$this->idReturn('tb_ic','descricao',$ic[$k])}','{$this->idReturn('tb_prioridade','pri_descricao',$prioridade[$k])}','{$this->idReturn('tb_sumario','descricao',$sumario[$k])}')");

                    if($sql->execute()){
                        $resgistro++;
                    }
                }
            }
        }

        return $resgistro;
    }

    public function cadastro_ocorrencia_base(){
        $empresa = $this->db_insert_empresa();
        $grupo = $this->db_insert_grupo();
        $ic = $this->db_insert_ic();
        $sumario = $this->db_insert_sumario();
        $ocorrencia = $this->db_insert_ocorrencia();

        if($empresa == 0 && $grupo == 0 && $ic == 0 && $sumario  == 0 && $ocorrencia == 0){
            return "BASE JA FOI ATUALIZADA";
        }else{
            return "BASE ATUALIZADA";
        }
    }
    
    public function getObj(){
        return $this->obj;
    }
    
    public function setObj($obj){
        $this->obj = $obj;
    }
    
}

?>