<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('DBConnect');
Model('Query');

function EditDiaryBookmark($id, $d, $for) {
    DBConnect();
    if($d == 'add') {
        $query = "SELECT count(*) FROM diary_links WHERE diary_link = '$for' AND user_id = '$id';";
        $data = Query($query);
        $var = mysqli_fetch_row($data);
        if($var[0] > 0) {
            ViewErrorPage("Этот дневник уже добавлен в закладки!");
        }
        
        $query = "SELECT count(*) FROM nofap WHERE id = '$id' OR id = '$for';";
        $data = Query($query);
        $var = mysqli_fetch_row($data);
        if($var[0] != 2) {
            ViewErrorPage("Некорректные идентификаторы пользователей!");
        }
        
        $query = "INSERT INTO diary_links (user_id, diary_link) VALUES ('$id', '$for');";
        Query($query);
    }
    elseif($d == 'delete') {
        $query = "DELETE FROM diary_links WHERE user_id = '$id' AND diary_link = '$for';";
        $data = Query($query);
    }
}