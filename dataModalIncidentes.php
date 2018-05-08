<?php

    if (isset($_GET["ate"]) && !empty($_GET["ate"]) && isset($_GET["mes"]) && !empty($_GET["mes"])) {

        require_once "class/ReadBD.php";

        $read = new \Classes\ReadBD();

        /*echo "<pre>";
        print_r($read->dadosModalQuantidadeIncidente($_GET["ate"],$_GET["mes"]));
        echo "</pre>";*/

?>

        <table id="tableModalDados">
            <thead>
            <tr>
                <th>Incidente</th>
                <th>Criado em</th>
                <th>Data da Última Resolução</th>
                <th>IC</th>
                <th>Sumário</th>
                <th>Prioridade</th>
                <th>Grupo designado</th>
                <th>Empresa</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($read->dadosModalQuantidadeIncidente($_GET["ate"],$_GET["mes"]) as $key => $dado){
                echo "<tr>
                        <th>$dado[0]</th>
                        <th>$dado[1]</th>
                        <th>$dado[2]</th>
                        <th>$dado[6]</th>
                        <th>$dado[8]</th>
                        <th>$dado[7]</th>
                        <th>$dado[5]</th>
                        <th>$dado[9]</th>
                    </tr>";
            }

            ?>
            </tbody>
        </table>



<?php


    }else{

        echo json_encode("ERRO variveis GET vazias!");
        header('Content-Type: application/json');

    }

?>