<?php

namespace classes\manipulacao;

use classes\Database\Create;
use DateTime;
use Exception;

class Files{
    private $file,$now,$extensao,$temp,$newName,$message,$create,$destino;

    public function __construct($file, DateTime $now, Create $create){
        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');
        $this->file = $file;
        $this->now = $now;
        $this->extensao = pathinfo($this->file["name"], PATHINFO_EXTENSION);
        $this->newName = "Base_" . $this->getNow()->format("d-m-Y") . "." . $this->getExtensao();
        $this->message = "Upload Realizado com sucesso! Arquivos: ".$this->getNewName()." foi criado!";
        $this->temp = $this->file['tmp_name'];
        $this->create = $create;
        $this->destino = dirname(__FILE__,3).DIRECTORY_SEPARATOR."files".DIRECTORY_SEPARATOR. $this->getNewName();
    }

    private function testFile(){

        try {

            if ($this->getExtensao() == "xls") {

                if (move_uploaded_file($this->getTemp(),$this->getDestino())) {

                    if ($this->getCreate()->insertColsData() == "BASE ATUALIZADA COM SUCESSO!") {

                        if (unlink($this->getDestino())) {

                            $this->setMessage($this->getMessage()."<br/> Base foi atualizada!! Arquivo ".$this->getCreate()->getExcelData()->validateFilesName()." Excluído!");

                            return $this->getMessage();

                        } else {

                            throw new Exception("Base foi atualizada!! Erro na Exclusão do Arquivo ".$this->getCreate()->getExcelData()->validateFilesName());

                        }
                    }else{

                        return "BASE JÁ FOI ATUALIZADA";

                    }

                }else {

                    throw new Exception("Erro durante o upload do arquivos!!");

                }
            }else {

                throw new Exception("Extensão do arquivos inválida!! Favor converter arquivos para XLS (EXCEL2003)");

            }

        } catch (Exception $e) {

            ob_end_clean();

            exit("ERRO: ".$e->getMessage()."<br/>LINHA: ".$e->getLine()."<br/>CODE: ".$e->getCode()."<br/>ARQUIVO: ".$e->getFile());

        }
    }

    public function resultInsertData(){
        try {

            return $this->testFile();

        } catch (Exception $e) {

            ob_end_clean();

            json_encode("ERRO: ".$e->getMessage()."<br/>LINHA: ".$e->getLine()."<br/>CODE: ".$e->getCode()."<br/>ARQUIVO: ".$e->getFile());
        }
    }


    public function getFile(){
        return $this->file;
    }

    public function setFile($file): void{
        $this->file = $file;
    }

    public function getNow(): DateTime{
        return $this->now;
    }

    public function setNow(DateTime $now): void{
        $this->now = $now;
    }

    public function getExtensao(){
        return $this->extensao;
    }

    public function setExtensao($extensao): void{
        $this->extensao = $extensao;
    }

    public function getTemp(){
        return $this->temp;
    }

    public function setTemp($temp): void{
        $this->temp = $temp;
    }

    public function getNewName(): string{
        return $this->newName;
    }

    public function setNewName(string $newName): void{
        $this->newName = $newName;
    }

    public function getMessage(): string{
        return $this->message;
    }

    public function setMessage(string $message): void{
        $this->message = $message;
    }

    public function getCreate(): Create{
        return $this->create;
    }

    public function setCreate(Create $create): void{
        $this->create = $create;
    }

    public function getDestino(): string{
        return $this->destino;
    }

    public function setDestino(string $destino): void{
        $this->destino = $destino;
    }



}

?>