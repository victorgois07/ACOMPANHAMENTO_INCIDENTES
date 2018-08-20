<?php

    use classes\Database\Read;

    require_once "../config/config.php";

    $read = new Read(new DateTime('now'));

    header('Access-Control-Allow-Origin: *');
    header('Content-type: application/json');
    echo json_encode($read->toStringDataBase($_GET['horas']));

?>