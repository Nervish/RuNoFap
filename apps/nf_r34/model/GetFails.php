<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('DBConnect');
Model('Query');

function GetFails($email) {
    DBConnect();
    $fails = array();
    
    $query = "SELECT count(*) FROM ".$GLOBALS['db_fails']." WHERE time >= '".(time()-3600*24)."' AND email = '".addslashes(htmlspecialchars($email))."';";
    $data = Query($query);
    $fails['day'] = mysqli_fetch_row($data)[0];
    
    $query = "SELECT count(*) FROM ".$GLOBALS['db_fails']." WHERE time >= '".(time()-3600*24*7)."' AND email = '".addslashes(htmlspecialchars($email))."';";
    $data = Query($query);
    $fails['week'] = mysqli_fetch_row($data)[0];
    
    $query = "SELECT count(*) FROM ".$GLOBALS['db_fails']." WHERE time >= '".(time()-3600*24*30)."' AND email = '".addslashes(htmlspecialchars($email))."';";
    $data = Query($query);
    $fails['month'] = mysqli_fetch_row($data)[0];
    
    $query = "SELECT count(*) FROM ".$GLOBALS['db_fails']." WHERE email = '".addslashes(htmlspecialchars($email))."';";
    $data = Query($query);
    $fails['all'] = mysqli_fetch_row($data)[0];
    
    return $fails;
}