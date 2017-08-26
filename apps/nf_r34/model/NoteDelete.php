<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('DBConnect');
Model('Query');

function NoteDelete($id) {
    DBConnect();
    $i = addslashes($id);
    $query = "UPDATE notes SET softdel = 1 WHERE id = '$i';";
    Query($query);
}