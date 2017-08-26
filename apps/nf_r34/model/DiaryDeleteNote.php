<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('DBConnect');
Model('Query');
Model('GetEmail');

function DiaryDeleteNote($email, $id) {
    DBConnect();
    $person = GetEmail($email);
    $pid = $person['id'];
    $e = addslashes(htmlspecialchars($email));
    $i = addslashes(htmlspecialchars($id));
    
    $query = "SELECT author_id FROM diary WHERE id = '$i';";
    $data = Query($query);
    $var = mysqli_fetch_row($data);
    if(!isset($var[0]) or $var[0] != $pid) {
        ViewErrorPage("Вы не можете удалять чужие записи.");
    }
    
    $query = "DELETE FROM diary WHERE id = '$i' OR answ = '$i';";
    Query($query);
    
    /*$query = "SELECT id FROM diary WHERE author_id = '$pid';";
    $data = Query($query);
    
    $tmp = array();
    while($var = mysqli_fetch_row($data)) {
        array_push($tmp, $var[0]);
    }
    $template = join(',', $tmp);
    if($template) {
        $template = "OR answ IN($template)"
    }
    
    $query = "DELETE FROM diary WHERE (author_id = '$pid' $template) AND id = '$i';";
    $query = "DELETE FROM diary WHERE id = '$i' ";
    Query($query);*/
}