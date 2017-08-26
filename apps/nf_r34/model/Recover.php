<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('DBConnect');
Model('Query');
Model('PasswordGen');

function Recover($email, $pass) {
    DBConnect();
    sleep(1);
    $new = PasswordGen($pass);
    $query = "UPDATE ".$GLOBALS['db_table']." SET password = '$new' WHERE email = '$email'";
    Query($query);
}
