<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('DBConnect');
Model('Query');

function GetVisibleTable($from, $num, $lastpage = false, $alter = false) {
    DBConnect();
    if(!$alter) {
        $query = "SELECT * FROM nofap WHERE refresh > ".(time()-60*60*24*$GLOBALS['days'])." AND ulock = '0' ORDER BY LENGTH(time), time LIMIT $from,$num;";
    }
    else{
        $query = "SELECT * FROM nofap WHERE refresh > ".(time()-60*60*24*$GLOBALS['days'])." AND ulock = '0' ORDER BY LENGTH(time), time LIMIT $from,$num;";
        //$query = "SELECT * FROM nofap WHERE refresh > ".(time()-60*60*24*$GLOBALS['days'])." AND ulock = '0' ORDER BY LENGTH(time), time LIMIT $from,$num;";
        //$query = "SELECT * FROM nofap, (SELECT email, count(*) as c FROM fails GROUP BY email) t WHERE t.email = nofap.email AND refresh > ".(time()-60*60*24*$GLOBALS['days'])." AND ulock = '0' ORDER BY t.c, LENGTH(time), time LIMIT $from,$num;";
    }
    $data = Query($query);
    $count = $from+1;
    
    if(isset($_SESSION['rank_system']) and array_key_exists($_SESSION['rank_system'], $GLOBALS['rank_systems'])) {
        $rank_system = $_SESSION['rank_system'];
    }
    else{
        $rank_system = $GLOBALS['rank_system'];
    }
    include_once("data/Ranks/$rank_system.dat");
    
    $arr = array();
    while($var = mysqli_fetch_assoc($data)) {
        $t = (time()-$var["time"])/(3600*24);
        $r = floor($t);
        
        $z = rank($r);
        if(!$r) {
            $r = '&lt;1';
        }
        
        $tmp = array();
        array_push($tmp, $count, $var['nick'], $r, $z, $var['id']);
        array_push($arr, $tmp);
        $count++;
    }
    $r = -1;
    if($lastpage and $last = rank($r)) {
        $el = array_pop($arr);
        $el[3] = $last;
        array_push($arr, $el);
    }
    return $arr;
}
