<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('DBConnect');
Model('Query');

function SetIP($email) {
    DBConnect();
    $new = crc32($_SERVER['REMOTE_ADDR'].$GLOBALS['salt']);
    $query = "UPDATE ".$GLOBALS['db_table']." SET ip_hash = '$new' WHERE email = '$email';";
    Query($query);
}