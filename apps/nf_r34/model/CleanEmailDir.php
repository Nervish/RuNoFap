<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

function CleanEmailDir() {
    $data = glob("email/*");
    $out = "";
    foreach($data as $file) {
        if(is_file($file)) {
            $str = file_get_contents($file) or $out .= "$file: не удалось открыть файл.\n";
            if($str) {
                $arr = json_decode($str, true);
                if($arr) {
                    if($arr['rtime'] < time()-60*60*24) {
                        if(unlink($file))
                            $out .= "$file - удален.\n";
                        else
                            $out .= "$file - ошибка при удалении.\n";
                    }
                }
            }
        }
    }
    if($out)
        $out .= "Лишние файлы успешно удалены.\n";
    else
        $out = "Лишних файлов не найдено.\n";
    ViewInfoPage(nl2br($out));
}