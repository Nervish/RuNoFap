<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('DBConnect');
Model('Query');

function GetThreadPages($thread) {
    DBConnect();
    $t = addslashes(htmlspecialchars($thread));
    $query = "SELECT count(*) FROM ".$GLOBALS['db_forum']." WHERE (id = '$t' OR thread = '$t');";
    $data = Query($query);
    $var = mysqli_fetch_row($data);
    return $var[0];
}