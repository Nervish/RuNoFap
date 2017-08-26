<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('DBConnect');
Model('Query');

function GetAdminVotings() {
    DBConnect();
    $query = "SELECT * FROM vote_systems;";
    $data = Query($query);
    $result = array();
    while($var = mysqli_fetch_assoc($data)) {
        $var['chooses'] = array();
        $result[$var['id']] = $var;
    }
    $query = "SELECT vote_chooses.* FROM (SELECT id FROM vote_systems) t, vote_chooses WHERE vote_system = t.id;";
    $data = Query($query);
    while($var = mysqli_fetch_assoc($data)) {
        array_push($result[$var['vote_system']]['chooses'], $var);
    }
    //var_dump($result);die;
    return $result;
}