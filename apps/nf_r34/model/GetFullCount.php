<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('DBConnect');
Model('Query');

function GetFullCount($ip = "") {
    DBConnect();
    if($ip != "")
        $query = "SELECT count(*) FROM ".$GLOBALS['db_table']." WHERE ip_hash = '$ip';";
    else
        $query = "SELECT count(*) FROM ".$GLOBALS['db_table'].";";
    $data = Query($query);
    $var = mysqli_fetch_row($data);
    return $var[0];
}