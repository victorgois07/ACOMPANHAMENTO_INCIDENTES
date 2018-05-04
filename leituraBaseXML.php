<?php
    ini_set('max_execution_time', 300); //300 seconds = 5 minutes
    use SimpleExcel\SimpleExcel;
    require_once "lib/SimpleExcel/SimpleExcel.php";
    require_once "class/ManipuladorExcel.php";
    require_once "class/insertBD.php";

    if(isset($_FILES['fileUpload'])){
      date_default_timezone_set("Brazil/East");
      $ext = strtolower(substr($_FILES['fileUpload']['name'],-4));

      if($ext == ".xml"){
          $new_name = "Base_".date("d-m-Y").$ext;
          $dir = 'files/';

          while(is_file($dir.$new_name)) {
              unlink($dir . $new_name);
          }

          if(!is_file($dir.$new_name)){
              if(move_uploaded_file($_FILES['fileUpload']['tmp_name'], $dir . $new_name)){
                  $insert = new insertBD(new ManipuladorExcel(new SimpleExcel('xml')));
                  echo json_encode($insert->cadastro_ocorrencia_base());
              }
          }
      }

   }



?>