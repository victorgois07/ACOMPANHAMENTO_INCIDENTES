<?php
    use classes\Database\Read;

    require_once "../config/config.php";

    $read = new Read(new DateTime('now'));

    $read->view_json_meses();

?>