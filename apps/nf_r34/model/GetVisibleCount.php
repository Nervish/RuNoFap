<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('DBConnect');
Model('Query');

function GetVisibleCount() {
    DBConnect();
    $query = "SELECT count(*) FROM ".$GLOBALS['db_table']." WHERE refresh > ".(time()-60*60*24*$GLOBALS['days'])." AND ulock = '0';";
    $data = Query($query);
    $var = mysqli_fetch_row($data);
    return $var[0];
}