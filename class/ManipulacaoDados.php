<?php

class ManipulacaoDados{
    public $mes;
    public $dia;
    public $ano;
    private $caminho,$arquivo;

    public function __construct(){
        $this->mes = date("m");
        $this->dia = date("d");
        $this->ano = date("Y");
        $this->caminho = null;
    }

    public function h1InforDate(){
        $this->formatPTBR();

        $date = "01/".$this->mes."/".$this->ano." à ";

        /*if(date("d") == 1){
            return "01/".$this->mes."/".$this->ano." à ".date("d/m/Y");
        }else{
            if(date("N") == 1){
                return "01/".$this->mes."/".$this->ano." à ".date("d/m/Y");
            }else{
                return "01/".$this->mes."/".$this->ano." à ".date("d/m/Y",mktime (0, 0, 0, date("m"), date("d")-(date("N")-1),  date("Y")));
            }            
        }*/

        return "01/".$this->mes."/".$this->ano." à ".date("d/m/Y");
    }

    private function formatPTBR(){
        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');
    }

    public function printr($data) {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }
	
	public function semvirgula($v){
		if($v % 10 == 0){
			return number_format($v,0,",",".");
		}else{
			return $v;
		}
	}
    
    public function extracaoExcel($port,$countTemp){
        $arquivo = 'base_inc.xls';
        $table = "";

        $table .= "<table id='example' cellspacing='0' width='100%'>";

        $table .= "<thead>";
        $table .= "<tr>";
        $table .= "<th COLSPAN='4'>";
        $table .= "<h3>".strtoupper(strftime('%B/%Y'))."</h3>";
        $table .= "</th>";
        $table .= "</tr>";
        $table .= "<tr class='blueTr'>";
        $table .= "<th>Tempo de Resolução</th>";
        $table .= "<th>Quantidade</th>";
        $table .= "<th>%</th>";
        $table .= "<th>Acumulado</th>";
        $table .= "</tr>";
        $table .= "</thead>";
        $table .= "<tbody>";


        for($i=1; $i<=4; $i++){
            $table .= "<tr>";
            $table .= "<th>";
            $table .= "<strong>Até ".($i*2)."h</strong>";
            $table .= "</th>";
            $table .= "<th>". $countTemp[$i-1] ."</th>";            
            $table .= "<th>".str_replace('.',',',$port[$i-1])."%</th>";            
            $table .= "<th>";

            switch ($i){
                case 1:
                    $swTotal = $port[0];
                    $table .= number_format($swTotal,1,',','.');
                    break;
                case 2:
                    $swTotal = $port[0] + $port[1];
                    $table .= number_format($swTotal,1,',','.');
                    break;
                case 3:
                    $swTotal = $port[0] + $port[1] + $port[2];
                    $table .= number_format($swTotal,1,',','.');
                    break;
                case 4:
                    $swTotal = $port[0] + $port[1] + $port[2] + $port[3];
                    $table .= number_format($swTotal,1,',','.');
                    break;
            }

            $table .= "%</th>";
            $table .= "</tr>";
        }


        $table .= "<tr>";
        $table .= "<th>";
        $table .= "<strong>Superior a 8h</strong>";
        $table .= "</th>";
        $table .= "<th>". $countTemp[count($countTemp)-1] ."</th>";
        $table .= "<th>". str_replace('.',',',$port[4]) ."%</th>";
        $table .= "<th>";


        if(array_sum($port) > 100){

            $table .= floatval(100);

        }elseif(array_sum($port) < 100){

            $table .= floatval(100);

        }else{

            $table .= number_format(array_sum($port),2,',','.');
        }

        $table .= "%</th>";
        $table .= "</tr>";
        $table .= "<tr class='blueTr'>";
        $table .= "<th>TOTAL</th>";
        $table .= "<th>". array_sum($countTemp) ."</th>";
        $table .= "<th COLSPAN='2'>". array_sum($port).'%' ."</th>";
        $table .= "</tr>";
        $table .= "</tbody>";
        $table .= "</table>";

        // Força o Download do Arquivo Gerado
        header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
        header ("Cache-Control: no-cache, must-revalidate");
        header ("Pragma: no-cache");
        header ("Content-type: application/x-msexcel");
        header ("Content-Disposition: attachment; filename={$arquivo}" );
        header ("Content-Description: PHP Generated Data" );
        echo $table;
    }

    /**
     * @return bool|string
     */
    public function getMes()
    {
        return $this->mes;
    }

    /**
     * @param bool|string $mes
     */
    public function setMes($mes)
    {
        $this->mes = $mes;
    }

    /**
     * @return bool|string
     */
    public function getDia()
    {
        return $this->dia;
    }

    /**
     * @param bool|string $dia
     */
    public function setDia($dia)
    {
        $this->dia = $dia;
    }

    /**
     * @return bool|string
     */
    public function getAno()
    {
        return $this->ano;
    }

    /**
     * @param bool|string $ano
     */
    public function setAno($ano)
    {
        $this->ano = $ano;
    }

    /**
     * @return array
     */
    public function getCaminho()
    {
        return $this->caminho;
    }

    /**
     * @param array $caminho
     */
    public function setCaminho($caminho)
    {
        $this->caminho = $caminho;
    }

    /**
     * @return mixed
     */
    public function getArquivo()
    {
        return $this->arquivo;
    }

    /**
     * @param mixed $arquivo
     */
    public function setArquivo($arquivo)
    {
        $this->arquivo = $arquivo;
    }
}

?>