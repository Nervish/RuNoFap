<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('DBConnect');
Model('Query');
Model('GetEmail');

function DiaryAnswer($email, $id, $answer) {
    DBConnect();    
    
    $poster = GetEmail($email);
    $e = addslashes(htmlspecialchars($email));
    $i = addslashes(htmlspecialchars($id));
    $a = addslashes(htmlspecialchars($answer));
    
    $query = "SELECT author_id FROM diary WHERE id = '$i';";
    $data = Query($query);
    $author_id = mysqli_fetch_row($data)[0];
    
    $query = "SELECT id, allow_diary_comments FROM nofap WHERE id = '$author_id';";
    $data = Query($query);
    $var = mysqli_fetch_assoc($data);
    
    if($author_id != $poster['id'] and !$var['allow_diary_comments']) {
        ViewErrorPage("Пользователь запретил комментировать свой дневник!");
    }
    
    $query = "INSERT INTO diary (answ, author_id, note, public) VALUES ('$i', '".$poster['id']."', '$a', '1');";
    Query($query);
    
    return $author_id;
}