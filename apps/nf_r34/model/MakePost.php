<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('DBConnect');
Model('Query');
Model('GetThreadPages');

function MakePost($thread, $subject, $post, $author_id) {
    DBConnect();
    $t = addslashes(htmlspecialchars($thread));
    $s = addslashes(htmlspecialchars($subject));
    $p = addslashes(htmlspecialchars($post));
    
    if($t) {
        $query = "SELECT id FROM ".$GLOBALS['db_forum']." WHERE id = '$t' AND thread = '0';";
        $data = Query($query);
        $var = mysqli_fetch_row($data)[0];
        if(!$var) {
            ViewErrorPage("Форма ссылается на несуществующий тред!");
        }
    }
    
    $query = "INSERT INTO ".$GLOBALS['db_forum']." (thread, subject, post, author_id) VALUES ('$t', '$s', '$p', '$author_id')";
    
    Query($query);
    $id = mysqli_insert_id($GLOBALS['link']);
    if(!$t) {
        $thr = $id;
        $count = 1;
    }
    else{
        $query = "SELECT thread FROM ".$GLOBALS['db_forum']." WHERE id = '$id';";
        $data = Query($query);
        $thr = mysqli_fetch_assoc($data)['thread'];
        $count = GetThreadPages($thr);
        $query = "UPDATE forum SET count = (count + 1), lastmsg = '".date("Y-m-d H:i:s")."' WHERE id = '$t';";
        Query($query);
    }
    return array("thread"=>$thr, "count"=>$count, "post"=>$id);
}