<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('DBConnect');
Model('Query');

function NoteCount($cat = false) {
    DBConnect();
    if($cat) {
        $c = addslashes($cat);
        $query = "SELECT count(*) FROM notes WHERE cat = '$c' AND softdel = 0;";
    }
    else{
        $query = "SELECT count(*) FROM notes WHERE softdel = 0;";
    }
    $data = Query($query);
    $var = mysqli_fetch_row($data);
    return $var[0];
}
