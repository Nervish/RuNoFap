<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('DBConnect');
Model('Query');

function GetField($table, $field, $email) {
    DBConnect();
    $t = addslashes(htmlspecialchars($table));
    $f = addslashes(htmlspecialchars($field));
    $e = addslashes(htmlspecialchars($email));
    $query = "SELECT $f FROM $t WHERE email = '$e';";
    $data = Query($query);
    $var = mysqli_fetch_row($data)[0];
    return $var;
}