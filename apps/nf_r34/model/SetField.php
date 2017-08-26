<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('DBConnect');
Model('Query');

function SetField($table, $field, $value, $email) {
    DBConnect();
    $t = addslashes(htmlspecialchars($table));
    $f = addslashes(htmlspecialchars($field));
    $v = addslashes(htmlspecialchars($value));
    $e = addslashes(htmlspecialchars($email));
    $query = "UPDATE $t SET $f = '$v' WHERE email = '$e';";
    Query($query);
}