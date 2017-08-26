<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('DBConnect');
Model('Query');

function WarMemorial() {
    DBConnect();
    $now = time();
    $query = "SELECT warriors.war_id, warriors.army_id, warriors.status, count(*) AS count FROM wars, warriors WHERE warriors.war_id = wars.id AND finish < $now GROUP BY war_id, army_id, status;";
    //$query2 = "SELECT war_id, army_id, count(*) AS count FROM warriors WHERE status = 'lose' OR status = 'lost' GROUP BY war_id, army_id;";
    $data = Query($query);
    $result = array();
    $win = array();
    $lose = array();
    $win_armies = array();
    
    $result['list'] = $result['wars'] = array();
    
    while($var = mysqli_fetch_assoc($data)) {
        if($var['status'] == 'fighting') {
            if(!isset($win[$var['war_id']])) {
                $win[$var['war_id']] = array();
            }
            $win[$var['war_id']][$var['army_id']] = $var['count'];
        }
        else{
            if(!isset($lose[$var['war_id']])) {
                $lose[$var['war_id']] = array();
            }
            if(!isset($lose[$var['war_id']][$var['army_id']])) {
                $lose[$var['war_id']][$var['army_id']] = 0;
            }
            $lose[$var['war_id']][$var['army_id']] += $var['count'];
        }
    }
    
    foreach($lose as $war_key=>$war_value) {
        $tmp = array();
        foreach($war_value as $army_key=>$army_value) {
            if(!isset($win[$war_key][$army_key])) {
                $a = 0;
            }
            else{
                $a = $win[$war_key][$army_key];
            }
            if(!isset($lose[$war_key][$army_key])) {
                $b = 0;
            }
            else{
                $b = $lose[$war_key][$army_key];
            }
            $sum = $a+$b;
            if($b) {
                $perc = $a/$sum;
            }
            else{
                $perc = 0;
            }
            $tmp[] = array('army'=>$army_key, 'perc'=>$perc);
        }
        $win_side = array();
        if($tmp[0]['perc'] > $tmp[1]['perc']) {
            $w_side = $tmp[0]['army'];
            $l_side = $tmp[1]['army'];
        }
        else{
            $w_side = $tmp[1]['army'];
            $l_side = $tmp[0]['army'];
        }
        
        $win_side['war'] = $war_key;
        $win_side['army'] = $w_side;
        $win_armies[] = $w_side;
        
        $win_side['alive'] = 0;
        $win_side['play'] = 0;
        
        if(isset($win[$war_key][$w_side])) $win_side['alive'] += $win[$war_key][$w_side];
        if(isset($win[$war_key][$l_side])) $win_side['alive'] += $win[$war_key][$l_side];
        
        $win_side['play'] = $win_side['alive'];
        if(isset($lose[$war_key][$w_side])) $win_side['play'] += $lose[$war_key][$w_side];
        if(isset($lose[$war_key][$l_side])) $win_side['play'] += $lose[$war_key][$l_side];
        
        $result['list'][$w_side] = $win_side;
    }
    
    $query = "SELECT id, name FROM armies WHERE id IN (".join(',', $win_armies).") ORDER BY id;";
    $data = Query($query);
    while($var = mysqli_fetch_assoc($data)) {
        $result['list'][$var['id']]['name'] = $var['name'];
    }
    
    $query = "SELECT id, start, finish FROM wars;";
    $data = Query($query);
    while($var = mysqli_fetch_assoc($data)) {
        $result['wars'][$var['id']] = $var;
    }
    
    //var_dump($result);die;
    return $result;
}
