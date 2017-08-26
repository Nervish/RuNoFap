<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('DBConnect');
Model('Query');

function AdminEditWars($temp) {
    DBConnect();
    if(isset($temp['add']) and !empty($temp['add']) and is_numeric($temp['add']) and $temp['add'] > 0) {
        $query = "INSERT INTO wars (start, finish, side_a, side_b, recruting) VALUES ".join(',', array_fill(0, $temp['add'], "('0', '0', '1', '1', '0')")).";";
        Query($query);
    }
    
    if(isset($temp['e']) and !empty($temp['e'])) {
        foreach($temp['e'] as $key=>$value) {
            echo "e[$key] <br />\n";
            $times = array();
            foreach(array($temp['start'][$key], $temp['finish'][$key]) as $value) {
                $s1 = explode(' ', $value);
                $s2 = explode('.', $s1[0]);
                $s3 = explode(':', $s1[1]);
                $t = mktime($s3[0], $s3[1], $s3[2], $s2[1], $s2[0], $s2[2]);
                array_push($times, $t);
            }
            $start = $times[0];
            $finish = $times[1];
            $side_a = $temp['side_a'][$key];
            $side_b = $temp['side_b'][$key];
            if($side_a == $side_b) {
                ViewErrorPage("В войне не может одна армия сражаться сама с собой!");
            }
            if(isset($temp['recruting'][$key]) and $temp['recruting'][$key]) {
                $r = '1';
            }
            else{
                $r = '0';
            }
            $k = addslashes($key);
            $query = "UPDATE wars SET start = '$start', finish = '$finish', side_a = '$side_a', side_b = '$side_b', recruting = '$r' WHERE id = '$k';";
            Query($query);
        }
    }
    if(isset($temp['d']) and !empty($temp['d'])) {
        foreach($temp['d'] as $key=>$value) {
            $k = addslashes($key);
            $query = "DELETE FROM wars WHERE id = '$k';";
            Query($query);
        }
    }
}