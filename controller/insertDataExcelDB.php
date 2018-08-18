<?php

    ini_set('max_execution_time', 800); //300 seconds = 5 minutes

    use app\Classes\database\Create;

    require_once "../config/config.php";

    $create = new Create();

    echo "<pre>";
    print_r($create->insertColsData());
    echo "</pre>";

?>