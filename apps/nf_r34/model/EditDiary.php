<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('DBConnect');
Model('Query');

function EditDiary($author_id, $id, $public) {
    DBConnect();
    $i = addslashes(htmlspecialchars($author_id));
    $query = "UPDATE ".$GLOBALS['db_diary']." SET public = '$public' WHERE author_id = '$i' AND id = '$id';";
    Query($query);
}