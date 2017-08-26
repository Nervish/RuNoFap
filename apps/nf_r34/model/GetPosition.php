<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('DBConnect');
Model('Query');

function GetPosition($id) {
    DBConnect();
    $limit = time()-60*60*24*$GLOBALS['days'];
    $query = "SELECT count(*) AS n FROM nofap, (SELECT time FROM nofap WHERE id = '$id') t WHERE nofap.refresh > $limit AND nofap.ulock = '0' AND nofap.time <= t.time;";
    $data = Query($query);
    $var = mysqli_fetch_row($data);
    return $var[0];
}