<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

function GetData($type, $mask = '*') {
    $data = glob("data/$type/$mask.dat");
    $result = array();
    foreach($data as $var) {
        if(is_file($var)) {
            $arr = json_decode(file_get_contents($var), true) or ViewErrorPage("Произошла ошибка при чтении $var.");
            if(!empty($arr)) {
                $arr['orig'] = md5($var);
                $arr['file'] = $var;
                $arr['id'] = str_replace("data/$type/", "", $var);
                $arr['id'] = str_replace(".dat", "", $arr['id']);
                array_push($result, $arr);
            }
        }
    }
    return $result;
}