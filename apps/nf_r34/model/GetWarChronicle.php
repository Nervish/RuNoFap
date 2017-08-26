<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('DBConnect');
Model('Query');
Model('GetWar');

function GetWarChronicle() {
    DBConnect();
    $war = GetWar();
    if($war) {
        $query = "SELECT nofap.nick, nofap.army, fails.time, fails.at_day FROM nofap, fails, warriors WHERE warriors.war_id = '".$war['id']."' AND warriors.user_id = nofap.id AND fails.email = nofap.email AND fails.time >= ".$war['start']." AND fails.time <= ".$war['finish']." GROUP BY fails.email ORDER BY fails.time DESC;";
        $data = Query($query);
        $result = array();
        while($var = mysqli_fetch_assoc($data)) {
            array_push($result, $var);
        }
        //var_dump($result);die;
        return $result;
    }
    else{
        return false;
    }
}
    