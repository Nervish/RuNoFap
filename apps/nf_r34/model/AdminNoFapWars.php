<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('DBConnect');
Model('Query');

function AdminNoFapWars() {
    DBConnect();
    $query = "SELECT * FROM wars ORDER BY id DESC;";
    $result = array();
    $data = Query($query);
    while($var = mysqli_fetch_assoc($data)) {
        array_push($result, $var);
    }
    return $result;
}