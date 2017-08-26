<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('DBConnect');
Model('Query');

function GetEmail($email) {
    DBConnect();
    $query = "SELECT * FROM ".$GLOBALS['db_table']." WHERE email = '".addslashes(htmlspecialchars($email))."';";
    $data = Query($query);
    while($var = mysqli_fetch_assoc($data)) {
        return $var;
    }
}