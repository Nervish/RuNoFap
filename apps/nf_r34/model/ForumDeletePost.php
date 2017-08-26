<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('DBConnect');
Model('Query');

function ForumDeletePost($id) {
    DBConnect();
    $i = addslashes($id);
    //$query = "DELETE FROM forum WHERE id = '$i';";
    $query = "UPDATE forum SET locked = 1 WHERE id = '$i';";
    Query($query);
}