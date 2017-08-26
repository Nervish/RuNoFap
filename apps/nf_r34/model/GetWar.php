<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('DBConnect');
Model('Query');
Model('GetNoFapWar');

function GetWar() {
    DBConnect();
    $time = time();
    $query = "SELECT * FROM wars WHERE recruting OR (start <= '$time' AND finish >= '$time') ORDER BY finish DESC LIMIT 1;";
    $data = Query($query);
    if($var = mysqli_fetch_assoc($data)) {
        $result = $var;
    }
    else{
        $result = false;
    }
    return $result;
}