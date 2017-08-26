<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('DBConnect');
Model('Query');
Model('GetWar');

function GetForumTopics($from, $num) {
    DBConnect();
    $t = array();
    $war = GetWar();
    $time = time();
    $result = array();
    $result['list'] = array();
    $result['warrior_statuses'] = array();
    
    if($war and $war['start'] < $time and $war['finish'] > $time) {
        $query = "SELECT forum.author_id AS id, warriors.status AS status FROM nofap, forum, warriors WHERE thread = '0' AND warriors.war_id = '".$war['id']."' AND nofap.id = forum.author_id AND forum.author_id = warriors.user_id GROUP BY id;";
        $data = Query($query);
        while($var = mysqli_fetch_assoc($data)) {
            $result['warrior_statuses'][$var['id']] = $var['status'];
        }
    }
    
    $query = "SELECT forum.*, nofap.time AS ntime, nofap.nick AS nick, nofap.army AS army, nofap.c_time AS c_time, nofap.refresh AS refresh FROM nofap, forum WHERE thread = '0' AND NOT locked AND nofap.id = forum.author_id ORDER BY fixed DESC, lastmsg DESC LIMIT $from, $num;";
    $data = Query($query);
    while($var = mysqli_fetch_assoc($data)) {
        array_push($result['list'], $var);
    }
    return $result;
}