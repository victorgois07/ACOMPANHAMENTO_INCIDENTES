<?php

namespace Classes;

use SimpleExcel\SimpleExcel;
require_once dirname(__FILE__)."/../lib/SimpleExcel/SimpleExcel.php";

abstract class ManipuladorExcel extends SimpleExcel{
    public $arquivosXml, $containerDataXml, $total;

    public function __construct(){
        parent::__construct();
        $this->arquivosXml = $this->arquivosLocal();
        $this->containerDataXml = array(
            "prioridade" => $this->organizeARRAY($this->parser->getColumn($this->localizarColuna("Prioridade*"))),
            "criado" => $this->organizeARRAY($this->parser->getColumn($this->localizarColuna("Criado em"))),
            "resolvido" => $this->organizeARRAY($this->parser->getColumn($this->localizarColuna("Data da Última Resolução"))),
            "empresa" => $this->organizeARRAY($this->parser->getColumn($this->localizarColuna("Empresa de Suporte*"))),
            "grupo" => $this->organizeARRAY($this->parser->getColumn($this->localizarColuna("Grupo Designado*+"))),
            "incidente" => $this->organizeARRAY($this->parser->getColumn($this->localizarColuna("ID do Incidente*+"))),
            "resolucao" => $this->organizeARRAY($this->parser->getColumn($this->localizarColuna("Resolução"))),
            "sumario" => $this->organizeARRAY($this->parser->getColumn($this->localizarColuna("Sumário*"))),
            "nota" => $this->organizeARRAY($this->parser->getColumn($this->localizarColuna("Notas"))),
            "ic" => $this->organizeARRAY($this->parser->getColumn($this->localizarColuna("IC+")))
        );
        $this->total = count($this->organizeARRAY($this->parser->getColumn($this->localizarColuna("Prioridade*"))));
    }
    
    protected function validateFilesName():array{

        try {

            if (is_dir(dirname(__FILE__,2).DIRECTORY_SEPARATOR."files")) {

                $arquivos = glob("files/" . "{*.xml}", GLOB_BRACE);

                if (!empty($arquivos)) {

                    foreach ($arquivos as $nome) {
                        
                        $arrayDados[] = $nome;
                        
                    }

                    if (isset($arrayDados)) {
                        
                        return $arrayDados;
                        
                    }else{

                        throw new \Exception("ERRO: Variavel arrayDados encontra-se sem valores!");

                    }

                } else {

                    throw new \Exception("Não Existem arquivos dentro do diretorio files");

                }

            } else {

                throw new \Exception("O Diretorio files não existe!");

            }
        } catch (\Exception $e) {

            return array("ERRO: ".$e->getMessage(),"Linha: ".$e->getLine(),"Arquivos: ".$e->getFile());

        }
    }

    protected function separatorStringRenameFile(){

        try {

            $file = $this->validateFilesName();

            if(!preg_match("/ERRO:/i", $file[0])){

                foreach ($file as $k => $f) {

                    $fileExplode = explode("_", $f);

                    if (isset($fileExplode[1])) {

                        $ponto = explode(".", $fileExplode[1]);

                        if (isset($ponto[0])) {

                            $valorData[] = $ponto[0];

                        }else{

                            throw new \Exception("ERRO: Variavel ponto encontra-se sem valores!");

                        }

                    }else{

                        throw new \Exception("ERRO: Variavel fileExplode encontra-se sem valores!");

                    }
                }

                if (isset($valorData)) {

                    $k=1;

                    for($i=0; $i<count($valorData); $i++){
                        if(strtotime($valorData[$k]) > strtotime($valorData[$i])){
                            $posicao = $k;
                        }
                        elseif (strtotime($valorData[$k]) < strtotime($valorData[$i])){
                            $k = $i;
                            $posicao = $k;
                        }
                    }

                    if (isset($posicao)) {

                        return $posicao;

                    }else{

                        throw new \Exception("ERRO: Variavel posicao encontra-se sem valores!");

                    }

                }else{

                    throw new \Exception("ERRO: Variavel valorData encontra-se sem valores!");

                }

            }else{

                throw new \Exception($file[0]);

            }

        } catch (\Exception $e) {

            $dado = array("ERRO: ".$e->getMessage(),"Linha: ".$e->getLine(),"Arquivos: ".$e->getFile());

            array_map("utf8_encode",$dado);

            return json_encode($dado);

        }
    }
    
    protected function arquivosLocal():string{
        try {
            $file = $this->validateFilesName();

            if(!preg_match("/ERRO:/i", $file[0])){

                return $file[$this->separatorStringRenameFile()];

            }else{

                throw new \Exception($file[0]);
                
            }

        } catch (\Exception $e) {

            $dado = array("ERRO: ".$e->getMessage(),"Linha: ".$e->getLine(),"Arquivos: ".$e->getFile());

            array_map("utf8_encode",$dado);

            return json_encode($dado);

        }
    }

    public function keyOrganizarOrdem($var){
        $var = array_unique($var);

        asort($var);

        foreach ($var as $v){
            $dados[] = $v;
        }

        if (isset($dados)) {
            return $dados;
        }
    }

    private function organizeARRAY($array){
        unset($array[0]);

        $i=0;
        foreach ($array as $ar){
            $ay[$i] = $ar;
            $i++;
        }

        if (isset($ay)) {
            return $ay;
        }
    }

    private function localizarColuna($col){
        $this->parser->loadFile($this->arquivosLocal());
        $row = $this->parser->getRow(1);
        for($i=0; $i<count($row); $i++){
            if($row[$i] == $col) {
                return $i+1;
            }
        }
    }

    public function printr($data) {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }
    
    public function getArquivosXml(){
        return $this->arquivosXml;
    }
    
    public function setArquivosXml($arquivosXml){
        $this->arquivosXml = $arquivosXml;
    }

    public function getContainerDataXml(){
        return $this->containerDataXml;
    }

    public function setContainerDataXml($containerDataXml){
        $this->containerDataXml = $containerDataXml;
    }
    
    public function getTotal(){
        return $this->total;
    }
    
    public function setTotal($total){
        $this->total = $total;
    }

}

?>