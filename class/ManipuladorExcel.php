<?php


class ManipuladorExcel{
    protected $diretorio, $arquivos, $nameXML;
    private $dados;
    public $teste;

    public function __construct($obj){
        $this->diretorio = "files/";
        $this->arquivos = glob($this->getDiretorio()."{*.xml}", GLOB_BRACE);
        $this->nameXML = array();
        $this->obj = $obj;
        $this->prioridade = $this->organizeARRAY($this->obj->parser->getColumn($this->localizarColuna("Prioridade*")));
        $this->criado = $this->organizeARRAY($this->obj->parser->getColumn($this->localizarColuna("Criado em")));
        $this->resolvido = $this->organizeARRAY($this->obj->parser->getColumn($this->localizarColuna("Data da Última Resolução")));
        $this->empresa = $this->organizeARRAY($this->obj->parser->getColumn($this->localizarColuna("Empresa de Suporte*")));
        $this->grupo = $this->organizeARRAY($this->obj->parser->getColumn($this->localizarColuna("Grupo Designado*+")));
        $this->incidente = $this->organizeARRAY($this->obj->parser->getColumn($this->localizarColuna("ID do Incidente*+")));
        $this->resolucao = $this->organizeARRAY($this->obj->parser->getColumn($this->localizarColuna("Resolução")));
        $this->ic = $this->organizeARRAY($this->obj->parser->getColumn($this->localizarColuna("IC+")));
        $this->sumario = $this->organizeARRAY($this->obj->parser->getColumn($this->localizarColuna("Sumário*")));
        $this->nota = $this->organizeARRAY($this->obj->parser->getColumn($this->localizarColuna("Notas")));
        $this->total = count($this->getCriado());
    }

    /*
     * Função para verificar quantos arquivos tem no diretorio;
     */
    private function verificarDiretorio(){
        $i=0;
        foreach ($this->arquivos as $nome){
            $arrayDados[$i] = $nome;
            $i++;
        }

        if (isset($arrayDados)) {
            $this->setNameXML($arrayDados);
        }
    }
    
    /*
     * Função de comparação para saber o arquivos mais novo para extração dos dados
     */

    private function compararData($data1,$data2){
        if(strtotime($data1) > strtotime($data2)) {
            return $data1;
        }
        elseif(strtotime($data1) < strtotime($data2)){
            return $data2;
        }
        elseif(strtotime($data1) == strtotime($data2)){
            return "Arquivo Duplicado";
        }
    }
    
    /*
     * Retorno o valor maior para extração do dados
     */
    
    private function dataMaiorLaco(){
        $this->verificarDiretorio();
        $arrayDatas = $this->stringDataValor();
        
        $k=1;
        for($i=0; $i<count($arrayDatas); $i++){
            if(strtotime($arrayDatas[$k]) > strtotime($arrayDatas[$i])){
                $posicao = $k;
            }
            elseif (strtotime($arrayDatas[$k]) < strtotime($arrayDatas[$i])){
                $k = $i;
                $posicao = $k;
            }            
        }

        if (isset($posicao)) {
            return $posicao;
        }
    }

    public function teste(){
        return $this->getTeste();
    }

    private function stringDataValor(){

        $file = $this->getNameXML();

        if(isset($file)){
            for($i=0; $i<count($file); $i++){
                if (file_exists($file[$i])){
                    $fileExplode[$i] = explode("_",$file[$i]);
                    $valorData[$i] = $fileExplode[$i][1];
                }else{
                    return "ERRO ARQUIVOS NÃO EXISTEM";
                }
            }
        }

        if (isset($valorData)) {
            for ($i = 0; $i < count($valorData); $i++) {
                $exValorData[$i] = explode(".", $valorData[$i]);
                $finalValor[$i] = $exValorData[$i][0];
            }

            if (isset($finalValor)) {
                return $finalValor;
            }
        }        
    }
    
    public function arquivosLocal(){
        $this->verificarDiretorio();
        $file = $this->getNameXML();
        return $file[$this->dataMaiorLaco()];
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
        $this->obj->parser->loadFile($this->arquivosLocal());
        $row = $this->obj->parser->getRow(1);
        for($i=0; $i<count($row); $i++){
            if($row[$i] == $col) {
                return $i+1;
            }
        }
    }
    
    public function getDados(){
        return $this->dados;
    }
    
    public function setDados($dados){
        $this->dados = $dados;
    }
    
    public function getNameXML(){
        return $this->nameXML;
    }
    
    public function setNameXML($nameXML){
        $this->nameXML = $nameXML;
    }
    
    public function getDiretorio(){
        return $this->diretorio;
    }
    
    public function setDiretorio($diretorio){
        $this->diretorio = $diretorio;
    }
    
    public function getArquivos(){
        return $this->arquivos;
    }
    
    public function setArquivos($arquivos){
        $this->arquivos = $arquivos;
    }
    
    public function getTeste(){
        return $this->teste;
    }
    
    public function setTeste($teste){
        $this->teste = $teste;
    }
    
    public function getCriado(){
        return $this->criado;
    }
    
    public function setCriado($criado){
        $this->criado = $criado;
    }
    
    public function getEmpresa(){
        return $this->empresa;
    }
    
    public function setEmpresa($empresa){
        $this->empresa = $empresa;
    }
    
    public function getGrupo(){
        return $this->grupo;
    }
    
    public function setGrupo($grupo){
        $this->grupo = $grupo;
    }
    
    public function getIc(){
        return $this->ic;
    }
    
    public function setIc($ic){
        $this->ic = $ic;
    }
    
    public function getIncidente(){
        return $this->incidente;
    }
    
    public function setIncidente($incidente){
        $this->incidente = $incidente;
    }
    
    public function getNota(){
        return $this->nota;
    }
    
    public function setNota($nota){
        $this->nota = $nota;
    }
    
    public function getObj(){
        return $this->obj;
    }
    
    public function setObj($obj){
        $this->obj = $obj;
    }
    
    public function getPrioridade(){
        return $this->prioridade;
    }
    
    public function setPrioridade($prioridade){
        $this->prioridade = $prioridade;
    }
    
    public function getResolucao(){
        return $this->resolucao;
    }
    
    public function setResolucao($resolucao){
        $this->resolucao = $resolucao;
    }
    
    public function getResolvido(){
        return $this->resolvido;
    }
    
    public function setResolvido($resolvido){
        $this->resolvido = $resolvido;
    }
    
    public function getSumario(){
        return $this->sumario;
    }

    public function setSumario($sumario){
        $this->sumario = $sumario;
    }
    
    public function getTotal(){
        return $this->total;
    }
    
    public function setTotal($total){
        $this->total = $total;
    }

}

?>