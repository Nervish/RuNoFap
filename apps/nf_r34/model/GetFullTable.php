<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('DBConnect');
Model('Query');

function GetFullTable($from, $num, $sort, $ip) {
    DBConnect();
    if($sort == 'nick' or $sort == 'email' or $sort == 'ip_hash' or $sort == 'password')
        true;
    elseif($sort == "refresh" or $sort == "c_time")
        $sort = "LENGTH($sort), $sort";
    else
        $sort = 'LENGTH(time), time';
    if($ip != "")
        $query = "SELECT * FROM ".$GLOBALS['db_table']." WHERE ip_hash = '$ip' ORDER BY ".$sort." LIMIT $from, $num;";
    else
        $query = "SELECT * FROM ".$GLOBALS['db_table']." ORDER BY ".$sort." LIMIT $from, $num;";
    $data = Query($query);
    $arr = array();
    while($var = mysqli_fetch_assoc($data)) {
        $tmp = array();
        if( ! $var['c_time'])
            $var['c_time'] = 0;
        foreach(array('nick', 'email', 'refresh', 'time', 'ip_hash', 'c_time', 'ulock', 'id') as $t)
            $tmp[$t] = $var[$t];
        array_push($arr, $tmp);
    }
    return $arr;
}