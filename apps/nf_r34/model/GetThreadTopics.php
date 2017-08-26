<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('DBConnect');
Model('Query');
Model('GetWar');

function GetThreadTopics($thread, $from, $num) {
    DBConnect();
    $war = GetWar();
    $time = time();
    $t = addslashes(htmlspecialchars($thread));
    $result = array();
    $result['warrior_statuses'] = array();
    
    if($war and $war['start'] < $time and $war['finish'] > $time) {
        $query = "SELECT forum.author_id AS id, warriors.status AS status FROM forum, warriors WHERE warriors.war_id = '".$war['id']."' AND (forum.id = '$thread' OR forum.thread = '$thread') AND forum.author_id = warriors.user_id GROUP BY id;";
        $data = Query($query);
        while($var = mysqli_fetch_assoc($data)) {
            $result['warrior_statuses'][$var['id']] = $var['status'];
        }
    }
    
    $query = "SELECT id, subject, war_thread FROM forum WHERE id = '$t';";
    $data = Query($query);
    $var = mysqli_fetch_assoc($data);
    
    $result['id'] = $var['id'];
    $result['subject'] = $var['subject'];
    $result['war_thread'] = $var['war_thread'];
    $result['list'] = array();
    
    $query = "SELECT forum.*, nofap.time AS ntime, nofap.nick AS nick, nofap.army AS army, nofap.c_time AS c_time, nofap.refresh AS refresh FROM nofap, forum WHERE (forum.id = '$thread' OR forum.thread = '$thread') AND nofap.id = forum.author_id GROUP BY id ORDER BY time LIMIT $from, $num;";
    $data = Query("$query");
    $count = $from+1;
    while($var = mysqli_fetch_assoc($data)) {
        $var['num'] = $count;
        if($var['locked']) {
            $var['subject'] = '';
            $var['post'] = '<i>(сообщение удалено)</i>';
        }
        array_push($result['list'], $var);
        $count++;
    }
    return $result;
}