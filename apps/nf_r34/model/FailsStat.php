<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('DBConnect');
Model('Query');

function FailsStat($mask = "") {
    DBConnect();
    $mask = addslashes(htmlspecialchars($mask));
    if($mask) {
       $q = "WHERE email = '$mask' AND at_day >= 0" ;
    }
    else{
        $q = "WHERE at_day >= 0";
    }
    $query = "SELECT at_day, count(*) FROM ".$GLOBALS['db_fails']." $q GROUP BY at_day ORDER BY at_day;";
    $data = Query($query);
    
    $result = array();
    while($var = mysqli_fetch_assoc($data)) {
        array_push($result, $var);
    }
    return $result;
}