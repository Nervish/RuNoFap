<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('DBConnect');
Model('Query');

function DiaryWriteNote($id, $note, $public = false) {
    DBConnect();
    $i = addslashes(htmlspecialchars($id));
    $no =addslashes(htmlspecialchars($note));
    if($public) {
        $pub = true;
    }
    else{
        $pub = false;
    }
    
    $query = "INSERT INTO ".$GLOBALS['db_diary']." (author_id, note, public) VALUES ('$i', '$no', '$pub');";
    Query($query);
    $id = mysqli_insert_id($GLOBALS['link']);
    if(!$id) {
        ViewErrorPage("Произошла ошибка при добавлении записи.");
    }
}