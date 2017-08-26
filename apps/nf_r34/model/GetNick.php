<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('DBConnect');
Model('Query');

function GetNick($nick) {
    DBConnect();
    $query = "SELECT * FROM ".$GLOBALS['db_table']." WHERE nick = '".addslashes(htmlspecialchars($nick))."';";
    $data = Query($query);
    while($var = mysqli_fetch_assoc($data)) {
        return $var;
    }
}