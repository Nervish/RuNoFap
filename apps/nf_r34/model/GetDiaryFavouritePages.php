<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('DBConnect');
Model('Query');

function GetDiaryFavouritePages($id) {
    DBConnect();
    $query = "SELECT count(*) FROM diary, (SELECT diary_link FROM diary_links WHERE user_id = '$id') t WHERE public AND answ = '0' AND diary.author_id = t.diary_link;";
    $data = Query($query);
    $var = mysqli_fetch_row($data);
    return $var[0];
}