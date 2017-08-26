<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('DBConnect');
Model('Query');

function GetNoFapArmies($full = true) {
    DBConnect();
    $t = time()-(3600*24*7);
    if($full) {
        $query = "SELECT * FROM armies ORDER BY id;";
    }
    else{
        $query = "SELECT nofap.army, count(*), armies.* FROM nofap, armies WHERE nofap.refresh >= '$t' AND nofap.army = armies.name GROUP BY army ORDER BY count(*) DESC, id;";
    }
    $data = Query($query);
    $result = array();
    while($var = mysqli_fetch_assoc($data)) {
        array_push($result, $var);
    }
    //var_dump($result);die;
    return $result;
}