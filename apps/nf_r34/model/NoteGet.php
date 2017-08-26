<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('DBConnect');
Model('Query');

function NoteGet($cat, $start, $limit) {
    DBConnect();
    $c = addslashes($cat);
    $s = addslashes($start);
    $l = addslashes($limit);
    $query = "SELECT * FROM notes WHERE cat = '$c' AND softdel = 0 ORDER BY id DESC LIMIT $s, $l;";
    $data = Query($query);
    $result = array();
    while($var = mysqli_fetch_assoc($data)) {
        array_push($result, $var);
    }
    return $result;
}
