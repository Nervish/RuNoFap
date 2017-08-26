<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('DBConnect');
Model('Query');
Model('GetWar');

function GetNoFapWar() {
    DBConnect();
    $war = GetWar();
    if($war) {
        $time = time();
        if( ! ($war['start'] <= $time and $war['finish'] >= $time) ) {
            return false;
        }
        else{
            $query = "SELECT count(*) FROM warriors WHERE war_id = '".$war['id']."';";
            $data = Query($query);
            $var = mysqli_fetch_assoc($data);
            if(!$var['count(*)']) {
                $query = "UPDATE nofap SET army = 'empty' WHERE army = 'enter';";
                Query($query);
                
                $query = "SELECT nofap.id, armies.id AS army_id FROM nofap, armies WHERE nofap.army <> 'empty' AND nofap.army <> 'enter' AND nofap.army = armies.name;";
                $data = Query($query);
                $warriors = array();
                while($var = mysqli_fetch_assoc($data)) {
                    $id = $var['id'];
                    $army_id = $var['army_id'];
                    $query = "INSERT INTO warriors (user_id, war_id, army_id, status, timecheck) VALUES ('$id', '".$war['id']."', '$army_id', 'fighting', '$time');";
                    Query($query);
                }
            }
            $result = array();
            $result[$war['side_a']] = $result[$war['side_b']] = array('at_start'=>'0', 'fighting'=>'0', 'perc'=>'0', 'lose'=>'0', 'lost'=>'0', 'army_id'=>'0');
            
            $limit = time()-(3600*24*7);
            $query = "UPDATE warriors SET status = 'lost' WHERE war_id = '".$war['id']."' AND timecheck < '$limit';";
            Query($query);
            
            $query = "SELECT army_id, count(*) FROM warriors GROUP BY army_id ORDER BY id;";
            $data = Query($query);
            while($var = mysqli_fetch_assoc($data)) {
                $result[$var['army_id']]['at_start'] = $var['count(*)'];
            }
            
            $query = "SELECT id, name FROM armies WHERE id IN (".join(',', array_keys($result)).");";
            $data = Query($query);
            while($var = mysqli_fetch_assoc($data)) {
                $result[$var['id']]['name'] = $var['name'];
                $result[$var['id']]['army_id'] = $var['id'];
            }
            
            $query = "SELECT army_id, count(*) FROM warriors WHERE status = 'fighting' GROUP BY army_id;";
            $data = Query($query);
            while($var = mysqli_fetch_assoc($data)) {
                $result[$var['army_id']]['fighting'] = $var['count(*)'];
                $result[$var['army_id']]['perc'] = round($result[$var['army_id']]['fighting']/$result[$var['army_id']]['at_start']*100);
            }
            
            $query = "SELECT army_id, count(*) FROM warriors WHERE status = 'lose' GROUP BY army_id;";
            $data = Query($query);
            while($var = mysqli_fetch_assoc($data)) {
                $result[$var['army_id']]['lose'] = $var['count(*)'];
            }
            
            $query = "SELECT army_id, count(*) FROM warriors WHERE status = 'lost' GROUP BY army_id;";
            $data = Query($query);
            while($var = mysqli_fetch_assoc($data)) {
                $result[$var['army_id']]['lost'] = $var['count(*)'];
            }
            
            $result['side_a'] = $war['side_a'];
            $result['side_b'] = $war['side_b'];
            //var_dump($result);die;
            return $result;
        }
    }
    else{
        return false;
    }
}