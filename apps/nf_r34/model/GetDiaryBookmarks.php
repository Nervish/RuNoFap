<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('DBConnect');
Model('Query');

function GetDiaryBookmarks($id, $for = '') {
    DBConnect();
    if($for) {
        $query = "SELECT count(*) FROM diary_links WHERE user_id = '$id' AND diary_link = '$for';";
        $data = Query($query);
        $var = mysqli_fetch_row($data);
        return ($var[0]) ? true : false;
    }
    else{
        $query = "SELECT diary_links.*, nofap.nick AS nick, nofap.time AS time FROM nofap, diary_links WHERE diary_links.user_id = '$id' AND nofap.id = diary_links.diary_link ORDER BY nofap.time;";
        $data = Query($query);
        $time = time();
        $result = array();
        while($var = mysqli_fetch_assoc($data)) {
            $var['days'] = floor(($time-$var['time'])/(3600*24));
            array_push($result, $var);
        }
        return $result;
    }
}