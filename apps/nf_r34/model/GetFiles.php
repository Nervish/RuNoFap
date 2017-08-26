<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('GetData');

function GetFiles($dir) {
    $text = GetData('One', 'Files');
    $data = glob("$dir/*");
    $result = array();
    foreach($data as $d)
        if(is_file($d)) {
            $filename = explode('/', $d);
            $filename = $filename[count($filename)-1];
            if(isset($text[0]['files'][$filename]))
                $comment = $text[0]['files'][$filename];
            else
                $comment = "";
            array_push($result, array($d, $filename, $comment));
        }
    return $result;
}