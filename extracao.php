<!doctype html>
<html lang="pt-br">

<head>
    <title>Acompanhamento incidentes</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="refresh" content="5000; url=index.php">
</head>
<style>

    * {
        font-family: 'Arial', sans-serif;
    }

    table#tableIncidentes {
        font-weight: 700;
    }

    th {
        background: #B8DAFF;
    }

    td, th, tr {
        border: 3px solid #000;
        text-align: center !important;
    }

    thead tr:nth-child(1){
        background-color: #fff !important;
    }

    thead{
        font-size: 35px;
    }

    tbody{
        font-size: 55px;
    }
    tbody tr:nth-child(2), tbody tr:nth-child(4), tbody tr:nth-child(6){
        background-color: #E0EFFF;
    }

    th a {
        color: #000;
    }

    th a:hover {
        color: #000;
        text-decoration: none;
    }

    h2 {
        text-align: center;
        border-top: 1px solid #000;
        border-bottom: transparent;
        border-left: 2px solid #000;
        border-right: 2px solid #000;
        font-size: 45px;
        font-weight: 700;
        margin: 0;
        padding: 5px 0;
    }

    b, strong {
        font-weight: bolder;
        font-size: 35px;
    }
</style>
<?php

header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/x-msexcel");
header ("Content-Disposition: attachment; filename=extracaoIncidente.xls" );
header ("Content-Description: PHP Generated Data" );

echo $_POST['dados_a_enviar'];

?>
</html>
