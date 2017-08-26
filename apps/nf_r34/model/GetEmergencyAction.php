<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('DBConnect');
Model('Query');

function GetEmergencyAction($cat = "", $religious = false) {
    DBConnect();
    $cat = addslashes(htmlspecialchars($cat));
    if($religious) {
        $relig = "AND religious";
    }
    else{
        $relig = "";
    }
    if($cat != "") {
        $query = "SELECT link FROM ".$GLOBALS['db_links']." WHERE cat = '$cat' $relig ORDER BY RAND() LIMIT 1;";
    }
    else{
        $query = "SELECT link FROM ".$GLOBALS['db_links']." $relig ORDER BY RAND() LIMIT 1;";
    }
    $data = Query($query);
    while($var = mysqli_fetch_assoc($data)) {
        if(isset($var['link'])) {
            return $var['link'];
        }
    }
}