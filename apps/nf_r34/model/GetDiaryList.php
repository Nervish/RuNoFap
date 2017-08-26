<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('DBConnect');
Model('Query');

function GetDiaryList() {
    DBConnect();
    $query = "SELECT diary.author_id, nofap.nick AS nick, nofap.time AS time FROM nofap, diary WHERE diary.author_id = nofap.id AND diary.public AND diary.answ = '0' GROUP BY nofap.nick ORDER BY nofap.time;";
    $data = Query($query);
    $result = array();
    $time = time();
    while($var = mysqli_fetch_assoc($data)) {
        $var['days'] = floor(($time-$var['time'])/(3600*24));
        array_push($result, $var);
    }
    return $result;
}