<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('DBConnect');
Model('Query');

function GetTopic($id) {
    DBConnect();
    $i = addslashes($id);
    $query = "SELECT forum.*, nofap.time AS ntime, nofap.nick AS nick, nofap.army AS army FROM nofap, forum WHERE id = '$i';";
    $query = "SELECT forum.*, nofap.time AS ntime, nofap.nick AS nick, nofap.army AS army FROM nofap, forum WHERE nofap.id = forum.author_id AND forum.id = '$i';";
    $data = Query($query);
    $var = mysqli_fetch_assoc($data);
    return $var;
}