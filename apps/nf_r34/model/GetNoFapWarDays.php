<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('DBConnect');
Model('Query');
Model('GetWar');

function GetNoFapWarDays() {
    DBConnect();
    $war = GetWar();
    if($war) {
        $time = time();
        if( ! ($war['start'] <= $time and $war['finish'] >= $time) ) {
            return false;
        }
        else{
            $query = "SELECT SUM(nofap.time) as s, count(*) FROM warriors WHERE warriors.status = 'fighting' GROUP BY army;";
        }
    }
}