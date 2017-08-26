<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('DBConnect');
Model('Query');

function GetVoting($id, $user_id = "") {
    DBConnect();
    $i = addslashes($id);
    $u = addslashes($user_id);
    
    $query = "SELECT * FROM vote_systems WHERE id = '$i';";
    $data = Query($query);
    $result = array();
    
    $var = mysqli_fetch_assoc($data);
    if($var) {
        $result = $var;
        $result['chooses'] = array();
        $query = "SELECT vote_chooses.id, vote_chooses.choose FROM vote_chooses WHERE vote_chooses.vote_system = '$i' ORDER BY choose;";
        $data = Query($query);

        while($var = mysqli_fetch_assoc($data)) {
            $result['chooses'][$var['id']] = $var;
        }
        
        $query = "SELECT vote_choose, count(*) FROM votes WHERE vote_system = '$i' GROUP BY vote_choose ORDER BY count(*) DESC;";
        $data = Query($query);
        $result['votes'] = array();
        $result['nums'] = array();
        while($var = mysqli_fetch_assoc($data)) {
            $result['votes'][$var['vote_choose']] = $var['count(*)'];
            array_push($result['nums'], $var['vote_choose']);
        }
        
        if($user_id) {
            $query = "SELECT vote_choose FROM votes WHERE user_id = '$u' AND vote_system = '$i';";
            $data = Query($query);
            $result['user_chooses'] = array();
            while($var = mysqli_fetch_assoc($data)) {
                $result['user_chooses'][$var['vote_choose']] = true;
            }
        }
    }
    //var_dump($result);die;
    return $result;
}