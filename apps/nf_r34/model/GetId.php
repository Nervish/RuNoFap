<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('DBConnect');
Model('Query');

function GetId($id) {
    DBConnect();
    $i = addslashes($id);
    $query = "SELECT * FROM nofap WHERE id = '$i';";
    $data = Query($query);
    while($var = mysqli_fetch_assoc($data)) {
        return $var;
    }
}