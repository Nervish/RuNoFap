<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('DBConnect');
Model('Query');
Model('GetWar');

function GetDiaryFavourite($id, $from, $num) {
    DBConnect();
    $war = GetWar();
    $time = time();
    $result = array();
    $result['list'] = array();
    $result['warrior_statuses'] = array();
    
    if($war and $war['start'] < $time and $war['finish'] > $time) {
        $query = "SELECT nofap.id AS id, warriors.status AS status FROM nofap, diary, warriors WHERE warriors.war_id = '".$war['id']."' AND diary.author_id = nofap.id AND nofap.id = warriors.user_id GROUP BY id;";
        $data = Query($query);
        while($var = mysqli_fetch_assoc($data)) {
            $result['warrior_statuses'][$var['id']] = $var['status'];
        }
    }
    
    $query = "SELECT diary.id FROM diary, (SELECT diary_link FROM diary_links WHERE user_id = '$id') t WHERE public AND answ = '0' AND diary.author_id = t.diary_link LIMIT $from, $num;";
    $data = Query($query);
    $ids = array();
    while($var = mysqli_fetch_row($data)) {
        array_push($ids, $var[0]);
    }
    $template = join(',', $ids);
    
    if($template) {
        $query = "SELECT diary.*, nofap.time AS ntime, nofap.nick AS nick, nofap.army AS army, nofap.c_time AS c_time, nofap.refresh AS refresh FROM nofap, diary WHERE diary.id IN ($template) AND nofap.id = author_id ORDER BY time DESC;";
        $data = Query($query);
        while($var = mysqli_fetch_assoc($data)) {
            $var['comments'] = array();
            $result['list'][$var['id']] = $var;
        }
        //var_dump($result);die;
        
        $query = "SELECT diary.*, nofap.time AS ntime, nofap.nick AS nick, nofap.army AS army, nofap.c_time AS c_time, nofap.refresh AS refresh FROM nofap, diary WHERE diary.answ IN ($template) AND nofap.id = author_id ORDER BY time ASC;";
        $data = Query($query);
        while($var = mysqli_fetch_assoc($data)) {
            array_push($result['list'][$var['answ']]['comments'], $var);
        }
    }
    
    return $result;
}