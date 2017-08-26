<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('DBConnect');
Model('Query');

function GetForumPages() {
    DBConnect();
    $query = "SELECT count(*) FROM ".$GLOBALS['db_forum']." WHERE thread = '0' AND NOT locked;";
    $data = Query($query);
    $var = mysqli_fetch_row($data);
    return $var[0];
}