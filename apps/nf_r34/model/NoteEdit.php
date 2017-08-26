<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('DBConnect');
Model('Query');

function NoteEdit($id, $data, $timestamp = false) {
    DBConnect();
    $i = addslashes($id);
    $d = addslashes($data);
    
    if($timestamp) {
        $at = date("Y-m-d H:i:s", $timestamp); 
    }
    else{
        $at = date("Y-m-d H:i:s", time());
    }
    
    $query = "UPDATE notes SET data = '$d', at = '$at' WHERE id = '$i';";
    Query($query);
}
