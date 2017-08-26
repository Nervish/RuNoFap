<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('DBConnect');
Model('Query');
Model('GetWar');
Model('TimeCheck');

function Update($email, $status, $time = "") {
    DBConnect();
    $war = GetWar();
    $email = addslashes($email);
    
    $query = "SELECT id, time, army FROM nofap WHERE email = '$email';";
    $data = Query($query);
    $profile = mysqli_fetch_assoc($data);
    $start = $profile['time'];
    $user_id = $profile['id'];
    $army = $profile['army'];
    
    if($status == 'ok') {
        $query = "UPDATE nofap SET refresh = '".time()."' WHERE email = '$email'";
        Query($query);
        if($war and $army != 'empty') {
            $query = "UPDATE warriors SET timecheck = '".time()."' WHERE user_id = '$user_id';";
            Query($query);
        }
    }
    elseif($status == 'failtime') {
        $r = TimeCheck($time);
        $query = "INSERT INTO fails (email, time, at_day) VALUES ('$email', '".time()."', '".floor((time()-$start)/(3600*24))."')";
        Query($query);
        if($war and $army != 'empty') {
            $query = "UPDATE warriors SET status = 'lose', timecheck = '".time()."' WHERE war_id = ".$war['id']." AND user_id = '$user_id';";
            Query($query);
        }
        $query = "UPDATE nofap SET refresh = '".time()."', time = '$r' WHERE email = '$email'";
        Query($query);
    }
    elseif($status == 'update')  {
        $r = TimeCheck($time);
        if($war and $army != 'empty' and $r > $war['start']) {
            $query = "UPDATE warriors SET status = 'lose', timecheck = '".time()."' WHERE war_id = ".$war['id']." AND user_id = '$user_id';";
            Query($query);
            
            $query = "INSERT INTO fails (email, time, at_day) VALUES ('$email', '".time()."', '".floor((time()-$start)/(3600*24))."')";
            Query($query);
        }
        $query = "UPDATE nofap SET refresh = '".time()."', time = '".$r."' WHERE email = '$email'";
        Query($query);
    }
}