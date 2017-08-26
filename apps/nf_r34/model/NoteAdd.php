<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('DBConnect');
Model('Query');

function NoteAdd($cat, $data, $timestamp = false) {
    DBConnect();
    $c = addslashes($cat);
    $d = addslashes($data);
    if($timestamp) {
       $at = date("Y-m-d H:i:s", $timestamp); 
    }
    else{
        $at = date("Y-m-d H:i:s", time());
    }
    $query = "INSERT INTO notes (cat, data, at) VALUES ('$c', '$d', '$at');";
    //echo $query;die;
    Query($query);
}
