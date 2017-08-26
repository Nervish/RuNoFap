<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('DBConnect');
Model('Query');

function Clean($ip) {
    DBConnect();
    $query = "DELETE FROM ".$GLOBALS['db_table']." WHERE ip_hash = '$ip'";
    Query($query);
}