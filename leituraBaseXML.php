<?php

    ini_set('max_execution_time', 300); //300 seconds = 5 minutes
    require_once "class/InsertBD.php";
    
    $insert = new \Classes\InsertBD();
    
    echo json_encode($insert->implantDataDB());
    header('Content-Type: application/json');

?>