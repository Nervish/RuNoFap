<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('DBConnect');
Model('Query');
Model('CheckAdminAccess');

CheckAdminAccess();

DBConnect();

$data = file('t5.txt');
foreach($data as $var) {
    $tmp = explode(' ', $var);
    $tmp[1] = str_replace("\n", "", $tmp[1]);
    $query = "UPDATE warriors SET status = '".$tmp[1]."' WHERE id = ".$tmp[0].";";
    Query($query);
}

echo("ok");