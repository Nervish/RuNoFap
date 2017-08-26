<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('DBConnect');
Model('Query');

function Vote($user_id, $vote_system, $temp = array()) {
    DBConnect();
    //var_dump($temp);die;
    $vs = addslashes($vote_system);
    $query = "DELETE FROM votes WHERE user_id = '$user_id' AND vote_system = '$vs';";
    Query($query);
    //var_dump($temp);die;
    foreach($temp as $key=>$value) {
        $vote_id = addslashes($key);
        $query = "SELECT id, mult FROM vote_systems WHERE id = '$vote_id'";
        $data = Query($query);
        $var = mysqli_fetch_assoc($data);
        if(isset($var['id']) and $var['id'] = $vote_id) {
            $mult = $var['mult'];
            $query = "SELECT id FROM vote_chooses WHERE vote_system = '$vs';";
            $data = Query($query);
            $chooses = array();
            while($var = mysqli_fetch_row($data)) {
                $chooses[$var[0]] = true;
            }
            if($mult) {
                foreach($value as $k=>$val) {
                    $vote = addslashes($k);
                    if(isset($chooses[$vote])) {
                        $query = "INSERT INTO votes (user_id, vote_system, vote_choose) VALUES ('$user_id', '$vote_id', '$vote');";
                        Query($query);
                    }
                    else{
                        ViewErrorPage("Форма ссылается на несуществующий выбор в голосовании!");
                    }
                }
            }
            else{
                $vote = addslashes($value);
                if(isset($chooses[$vote])) {
                    $query = "INSERT INTO votes (user_id, vote_system, vote_choose) VALUES ('$user_id', '$vote_id', '$vote');";
                    Query($query);
                }
                else{
                    ViewErrorPage("Форма ссылается на несуществующий выбор в голосовании!");
                }
            }
        }
        else{
            ViewErrorPage("Форма ссылается на несуществующее голосование.");
        }
    }
}