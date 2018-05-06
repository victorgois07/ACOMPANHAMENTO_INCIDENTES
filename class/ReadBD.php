<?php
namespace Classes;

require_once "ConectBD.php";

class ReadBD extends ConectBD{
    protected function identical_values( $arrayA , $arrayB ) {
        sort($arrayA);
        sort($arrayB);
        return $arrayA == $arrayB;
    }

    public function analiseIncidenteDB(){
        $arrayDadosXml = $this->getContainerDataXml();
        $inc = $arrayDadosXml["incidente"];
        $incReplace = str_replace("INC00000", "", $inc);

        foreach ($incReplace as $in){
            $twoString[] = $in[0].$in[1];
        }

        if (isset($twoString)) {
            $twoString = array_unique($twoString);

            $comando = "SELECT incidente FROM `tb_ocorrencia` WHERE ";

            foreach ($twoString as $k => $two){
                $finalString[] = "INC00000".$two."%";

                if ((count($twoString) - 1) == $k) {
                    $comando .= "incidente LIKE ? ORDER BY incidente";
                } else {
                    $comando .= "incidente LIKE ? OR ";
                }
            }

            if(isset($finalString)){
                $sql = $this->conectBD()->prepare($comando);

                $sql->execute($finalString);

                foreach ($sql->fetchAll(\PDO::FETCH_NUM) as $val){
                    $incDB[] = $val[0];
                }

                if (isset($incDB)) {
                    if ($this->identical_values($incDB, $inc)) {
                        $result = array_diff($incDB, $inc);
                        return $result;
                    }else{
                        return false;
                    }
                }

            }

        }
        
    }
}

?>