<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('DBConnect');
Model('Query');
Model('GetWar');

function GetWarrior($user_id) {
    DBConnect();
    $war = GetWar();
    $uid = addslashes($user_id);
    $query = "SELECT * FROM warriors WHERE user_id = '$uid' AND war_id = '".$war['id']."';";
    $data = Query($query);
    $var = mysqli_fetch_assoc($data);
    if($var) {
        return $var;
    }
    else{
        return false;
    }
}