<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('DBConnect');
Model('Query');

function GetDiaryPages($for, $public = true) {
    DBConnect();
    $f = addslashes(htmlspecialchars($for));
    
    if($for) {
        $a = "author_id = '$f'";
    }
    else{
        $a = "";
    }
    
    if($public) {
        if($a) {
            $p = " AND";
        }
        else{
            $p = "";
        }
        $p = "$p public";
    }
    else{
        $p = "";
    }
    
    $query = "SELECT count(*) FROM diary WHERE answ = 0 AND $a $p;";
    $data = Query($query);
    $var = mysqli_fetch_row($data);
    return $var[0];
}