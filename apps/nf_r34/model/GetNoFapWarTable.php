<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('DBConnect');
Model('Query');
Model('GetWar');

function GetNoFapWarTable() {
    DBConnect();
    $war = GetWar();
    if($war) {
        $sa = addslashes($war['side_a']);
        $sb = addslashes($war['side_b']);
        $query = "SELECT * FROM armies WHERE id = '$sa' OR id = '$sb';";
        $data = Query($query);
        $result = array();
        while($var = mysqli_fetch_assoc($data)) {
            if($var['id'] == $sa) {
                $side_a = $var;
            }
            else{
                $side_b = $var;
            }
        }
        $result['side_a'] = $side_a;
        $result['side_b'] = $side_b;
        $result['side_a']['members'] = $result['side_b']['members'] = array();
        
        $sa = addslashes($side_a['name']);
        $sb = addslashes($side_b['name']);
        $start = $war['start'];
        $query = "SELECT nofap.id, nofap.nick, nofap.army, nofap.time, warriors.status FROM nofap, warriors WHERE warriors.war_id = '".$war['id']."' AND nofap.id = warriors.user_id AND (nofap.army = '$sa' OR nofap.army = '$sb') ORDER BY time;";
        $data = Query($query);
        while($var = mysqli_fetch_assoc($data)) {
            if($var['army'] == $side_a['name']) {
                array_push($result['side_a']['members'], $var);
            }
            else{
                array_push($result['side_b']['members'], $var);
            }
        }
        return $result;
    }
    else{
        return false;
    }
}