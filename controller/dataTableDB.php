<?php

    use classes\Database\Read;

    require_once "../config/config.php";

    $read = new Read(new DateTime('now'));

    echo json_encode($read->readTbody());
    header('Content-Type: application/json');


?>