<?php

    function arquivosClasses():array {
        $dir = dirname(__DIR__, 1) . DIRECTORY_SEPARATOR . "classes";
        $open = opendir($dir);
        if ($open) {

            while (($item = readdir($open)) !== false) {
                if ($item != "." && $item != "..") {
                    $pastas[] = $item;
                }
            }

            foreach ($pastas as $p) {
                foreach (glob($dir . DIRECTORY_SEPARATOR . $p . DIRECTORY_SEPARATOR . "{*.php}", GLOB_BRACE) as $arq) {
                    $arquivos[] = $arq;
                }
            }

            closedir($open);
        }

        return $arquivos;
    }

    spl_autoload_register(function($class_name){

        foreach (arquivosClasses() as $filename) {
            if (file_exists(($filename))) {
                require_once($filename);
            }
        }

    });

 ?>