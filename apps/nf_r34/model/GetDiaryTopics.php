<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('DBConnect');
Model('Query');
Model('GetWar');

function GetDiaryTopics($author_id, $from, $num, $public = true) {
    DBConnect();
    $a = addslashes(htmlspecialchars($author_id));
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
    
    $query = "SELECT count(*) FROM nofap WHERE id = '$a';";
    $data = Query($query);
    $var = mysqli_fetch_row($data);
    if(!$var[0] and $a != 0) {
        ViewErrorPage("Пользователь с таким ником не найден!");
    }
    
    if($public) {
        $p = "AND public";
    }
    else{
        $p = "";
    }
    
    if($author_id) {
        $a = "(author_id = '$a' AND answ = '0')";
    }
    else{
        $a = "answ = '0'";
    }
    
    $query = "SELECT id FROM diary WHERE $a $p ORDER BY time DESC LIMIT $from, $num;";
    $data = Query($query);
    
    $id = array();
    while($var = mysqli_fetch_row($data)) {
        array_push($id, $var[0]);
    }
    $template = join(',', $id);
    
    if($template) {
        $query = "SELECT diary.*, nofap.time AS ntime, nofap.nick AS nick, nofap.army AS army, nofap.c_time AS c_time, nofap.refresh AS refresh FROM nofap, diary WHERE diary.id IN ($template) AND nofap.id = diary.author_id ORDER BY diary.time DESC;";
        $data = Query($query);

        while($var = mysqli_fetch_assoc($data)) {
            $var['comments'] = array();
            $result['list'][$var['id']] = $var;
        }
        //var_dump($result);die;
        
        $query = "SELECT diary.*, nofap.time AS ntime, nofap.nick AS nick, nofap.army AS army, nofap.c_time AS c_time, nofap.refresh AS refresh FROM nofap, diary WHERE diary.answ IN ($template) AND nofap.id = diary.author_id ORDER BY diary.time ASC;";
        $data = Query($query);
        
        while($var = mysqli_fetch_assoc($data)) {
            array_push($result['list'][$var['answ']]['comments'], $var);
        }
    }

    return $result;
}