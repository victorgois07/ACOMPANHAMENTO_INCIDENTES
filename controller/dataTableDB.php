<?php

    use classes\Database\Read;

    require_once "../config/config.php";

    $read = new Read(new DateTime('2018-08-30'));

    echo json_encode($read->readTbody());
    header('Content-Type: application/json');


?>