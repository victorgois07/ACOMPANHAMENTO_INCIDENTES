<?php
namespace Classes;

require_once "ConectBD.php";

class ReadBD extends ConectBD{

    protected function analiseIncidenteDB(){

        try {

            $arrayDadosXml = $this->getContainerDataXml();
            $inc = $arrayDadosXml["incidente"];
            $incReplace = str_replace("INC00000", "", $inc);

            foreach ($incReplace as $in) {
                $twoString[] = $in[0] . $in[1];
            }

            if (isset($twoString)) {
                $twoString = array_unique($twoString);

                $comando = "SELECT incidente FROM `tb_ocorrencia` WHERE ";

                foreach ($twoString as $k => $two) {
                    $finalString[] = "INC00000" . $two . "%";

                    if ((count($twoString) - 1) == $k) {
                        $comando .= "incidente LIKE ? ORDER BY incidente";
                    } else {
                        $comando .= "incidente LIKE ? OR ";
                    }
                }

                if (isset($finalString)) {

                    $sql = $this->conectBD()->prepare($comando);

                    if ($sql->execute($finalString)) {

                        foreach ($sql->fetchAll(\PDO::FETCH_NUM) as $val) {

                            $incDB[] = $val[0];

                        }

                        if (isset($incDB)) {

                            $intersect = array_intersect($inc, $incDB);

                            $diff = array_diff($inc, $intersect);

                            if (!empty($diff)) {
                                
                                foreach ($diff as $item) {

                                    $df[] = $item;

                                }

                                if (isset($df)) {

                                    return $df;

                                } else {

                                    throw new \Exception("ERRO: Variavel df encontra-se sem valores! ");

                                }
                                
                            } else {
                                
                                return false;
                                
                            }

                        }else{

                            throw new \Exception("ERRO: Variavel finalString encontra-se sem valores!");

                        }

                    } else {

                        throw new \Exception("ERRO: ".implode(" ",$sql->errorInfo()));

                    }



                }else{

                    throw new \Exception("ERRO: Variavel finalString encontra-se sem valores!");

                }

            }else{

                throw new \Exception("ERRO: Variavel twoString encontra-se sem valores!");

            }


        } catch (\Exception $e) {

            return array("ERRO: ".$e->getMessage(),"Linha: ".$e->getLine(),"Arquivos: ".$e->getFile());

        }
        
    }

    public function calculoTotal($mes){

        try {

            if (isset($mes) && !empty($mes)) {

                $sql = $this->conectBD()->prepare("SELECT COUNT(*) FROM tb_ocorrencia WHERE resolucao LIKE :MES");

                $sql->bindValue(":MES", $mes."-%");

                if ($sql->execute()) {

                    $sqlDados = $sql->fetchAll(\PDO::FETCH_NUM);

                    return intval($sqlDados[0][0]);

                } else {

                    throw new \Exception("ERRO: " . implode(" ", $sql->errorInfo()));

                }

            } else {

                throw new \Exception("ERRO: Variavel mes encontra-se sem valores ou vazia!");

            }

        } catch (\Exception $e) {

            return array("ERRO: ".$e->getMessage(),"Linha: ".$e->getLine(),"Arquivos: ".$e->getFile());

        }
    }

    protected function calculoPoncentagemAcumulado($data,$mes){

        try {

            if (isset($data) && isset($mes) && !empty($data) && !empty($mes)) {

                foreach ($data as $d) {

                    $porcentagem[] = round(($d / $this->calculoTotal($mes)) * 100);

                }

                if (isset($porcentagem)) {

                    $ac = 0;

                    foreach ($porcentagem as $key => $p) {

                        $ac += $porcentagem[$key];

                        $acumulado[] = $ac;

                    }

                    if (isset($acumulado)) {

                        return array($porcentagem, $acumulado);

                    }else{

                        throw new \Exception("ERRO: Variavel acumulado encontra-se sem valores ou vazia!");

                    }

                }else{

                    throw new \Exception("ERRO: Variavel porcentagem encontra-se sem valores ou vazia!");

                }

            }else{

                throw new \Exception("ERRO: Variavel mes e data encontra-se sem valores ou vazia!");

            }
        } catch (\Exception $e) {

            return array("ERRO: ".$e->getMessage(),"Linha: ".$e->getLine(),"Arquivos: ".$e->getFile());

        }

    }
    
    public function calculoEntreHoras($mes){

        try {

            if (!empty($mes)) {
                $comando = array(
                    "SELECT COUNT(*) FROM tb_ocorrencia WHERE resolucao LIKE '" . $mes . "-%' AND TIMESTAMPDIFF(SECOND, criado,resolucao) <= 7200",

                    "SELECT COUNT(*) FROM tb_ocorrencia WHERE resolucao LIKE '" . $mes . "-%' AND TIMESTAMPDIFF(SECOND, criado,resolucao) <= 14400 AND TIMESTAMPDIFF(SECOND, criado,resolucao) > 7200",

                    "SELECT COUNT(*) FROM tb_ocorrencia WHERE resolucao LIKE '" . $mes . "-%' AND TIMESTAMPDIFF(SECOND, criado,resolucao) <= 21600 AND TIMESTAMPDIFF(SECOND, criado,resolucao) > 14400",

                    "SELECT COUNT(*) FROM tb_ocorrencia WHERE resolucao LIKE '" . $mes . "-%' AND TIMESTAMPDIFF(SECOND, criado,resolucao) <= 28800 AND TIMESTAMPDIFF(SECOND, criado,resolucao) > 21600",

                    "SELECT COUNT(*) FROM tb_ocorrencia WHERE resolucao LIKE '" . $mes . "-%' AND TIMESTAMPDIFF(SECOND, criado,resolucao) > 28800"
                );

                foreach ($comando as $key => $cmd) {
                    $sql = $this->conectBD()->prepare($cmd);


                    if ($sql->execute()) {

                        foreach ($sql->fetchAll(\PDO::FETCH_NUM) as $val) {

                            $dataCount[$key] = intval($val[0]);

                        }

                    } else {

                        throw new \Exception("ERRO: ".implode(" ",$sql->errorInfo()));

                        break;

                    }

                }

                if (isset($dataCount)) {

                    $data = $this->calculoPoncentagemAcumulado($dataCount,$mes);

                    array_unshift($data,$dataCount);

                    return $data;

                }else{

                    throw new \Exception("ERRO: Variavel dataCount encontra-se sem valores!");

                }

            } else {

                throw new \Exception("ERRO: Variavel mes encontra-se vazia!");

            }

        } catch (\Exception $e) {

            return array("ERRO: ".$e->getMessage(),"Linha: ".$e->getLine(),"Arquivos: ".$e->getFile());

        }
        
    }
    
    public function dadosModalQuantidadeIncidente($tipo, $mes){

        try {
            
            switch ($tipo) {
                case "td_Até_2h":
                    $sql = $this->conectBD()->prepare("SELECT o.incidente, o.criado, o.resolucao, o.descricao_problema, o.descricao_solucao, d.grupo, i.descricao, p.pri_descricao, s.descricao, e.descricao FROM tb_ocorrencia o inner join tb_grupo_designado d on o.fk_grupo_designado = d.id_grupo_designado inner join tb_ic i on o.fk_ic = i.id_ic inner join tb_prioridade p on p.id_prioridade = o.fk_prioridade inner join tb_sumario s on s.id_sumario = o.fk_sumario inner join tb_empresa e on e.id_empresa = d.fk_empresa WHERE o.resolucao LIKE '" . $mes . "-%' AND TIMESTAMPDIFF(SECOND, o.criado,o.resolucao) <= 7200");
                    break;
                case "td_Até_4h":
                    $sql = $this->conectBD()->prepare("SELECT o.incidente, o.criado, o.resolucao, o.descricao_problema, o.descricao_solucao, d.grupo, i.descricao, p.pri_descricao, s.descricao, e.descricao FROM tb_ocorrencia o inner join tb_grupo_designado d on o.fk_grupo_designado = d.id_grupo_designado inner join tb_ic i on o.fk_ic = i.id_ic inner join tb_prioridade p on p.id_prioridade = o.fk_prioridade inner join tb_sumario s on s.id_sumario = o.fk_sumario inner join tb_empresa e on e.id_empresa = d.fk_empresa WHERE o.resolucao LIKE '" . $mes . "-%' AND TIMESTAMPDIFF(SECOND, o.criado,o.resolucao) <= 14400 AND TIMESTAMPDIFF(SECOND, o.criado,o.resolucao) > 7200");
                    break;
                case "td_Até_6h":
                    $sql = $this->conectBD()->prepare("SELECT o.incidente, o.criado, o.resolucao, o.descricao_problema, o.descricao_solucao, d.grupo, i.descricao, p.pri_descricao, s.descricao, e.descricao FROM tb_ocorrencia o inner join tb_grupo_designado d on o.fk_grupo_designado = d.id_grupo_designado inner join tb_ic i on o.fk_ic = i.id_ic inner join tb_prioridade p on p.id_prioridade = o.fk_prioridade inner join tb_sumario s on s.id_sumario = o.fk_sumario inner join tb_empresa e on e.id_empresa = d.fk_empresa WHERE o.resolucao LIKE '" . $mes . "-%' AND TIMESTAMPDIFF(SECOND, criado,resolucao) <= 21600 AND TIMESTAMPDIFF(SECOND, o.criado,o.resolucao) > 14400");
                    break;
                case "td_Até_8h":
                    $sql = $this->conectBD()->prepare("SELECT o.incidente, o.criado, o.resolucao, o.descricao_problema, o.descricao_solucao, d.grupo, i.descricao, p.pri_descricao, s.descricao, e.descricao FROM tb_ocorrencia o inner join tb_grupo_designado d on o.fk_grupo_designado = d.id_grupo_designado inner join tb_ic i on o.fk_ic = i.id_ic inner join tb_prioridade p on p.id_prioridade = o.fk_prioridade inner join tb_sumario s on s.id_sumario = o.fk_sumario inner join tb_empresa e on e.id_empresa = d.fk_empresa WHERE o.resolucao LIKE '" . $mes . "-%' AND TIMESTAMPDIFF(SECOND, o.criado,o.resolucao) <= 28800 AND TIMESTAMPDIFF(SECOND, o.criado,o.resolucao) > 21600");
                    break;
                case "td_Superior_a_8h":
                    $sql = $this->conectBD()->prepare("SELECT o.incidente, o.criado, o.resolucao, o.descricao_problema, o.descricao_solucao, d.grupo, i.descricao, p.pri_descricao, s.descricao, e.descricao FROM tb_ocorrencia o inner join tb_grupo_designado d on o.fk_grupo_designado = d.id_grupo_designado inner join tb_ic i on o.fk_ic = i.id_ic inner join tb_prioridade p on p.id_prioridade = o.fk_prioridade inner join tb_sumario s on s.id_sumario = o.fk_sumario inner join tb_empresa e on e.id_empresa = d.fk_empresa WHERE o.resolucao LIKE '" . $mes . "-%' AND TIMESTAMPDIFF(SECOND, o.criado,o.resolucao) > 28800");
                    break;
                case "td_total":
                    $sql = $this->conectBD()->prepare("SELECT o.incidente, o.criado, o.resolucao, o.descricao_problema, o.descricao_solucao, d.grupo, i.descricao, p.pri_descricao, s.descricao, e.descricao FROM tb_ocorrencia o inner join tb_grupo_designado d on o.fk_grupo_designado = d.id_grupo_designado inner join tb_ic i on o.fk_ic = i.id_ic inner join tb_prioridade p on p.id_prioridade = o.fk_prioridade inner join tb_sumario s on s.id_sumario = o.fk_sumario inner join tb_empresa e on e.id_empresa = d.fk_empresa WHERE o.resolucao LIKE '" . $mes . "-%'");
                    break;
            }

            if (isset($sql)) {
                
                if ($sql->execute()) {
                    
                    return $sql->fetchAll(\PDO::FETCH_NUM);
                    
                } else {
                    
                    throw new \Exception("ERRO: ".implode(" ",$sql->errorInfo()));
                    
                }
                
            }else{

                throw new \Exception("ERRO: Variavel sql encontra-se vazia!");
                
            }
            
        } catch (\Exception $e) {

            return array("ERRO: ".$e->getMessage(),"Linha: ".$e->getLine(),"Arquivos: ".$e->getFile());
            
        }
        
        

        
    }
}

?>