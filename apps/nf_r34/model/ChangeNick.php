<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('DBConnect');
Model('Query');

function ChangeNick($email, $newnick) {
    DBConnect();
    $e = addslashes(htmlspecialchars($email));
    $n = $newnick;
    
    $query = "SELECT nick FROM ".$GLOBALS['db_table']." WHERE nick = '$n';";
    $data = Query($query);
    $var = mysqli_fetch_row($data);
    if(!empty($var)) {
        ViewErrorPage("Никнейм уже занят!");
    }
    
    $query = "UPDATE ".$GLOBALS['db_table']." SET nick = '$n' WHERE email = '$e';";
    Query($query);
}