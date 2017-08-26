<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('DBConnect');
Model('Query');

function MassiveEdit($arr) {    
    DBConnect();
    foreach($arr['e'] as $key=>$email) {
        $query = "SELECT * FROM ".$GLOBALS['db_table']." WHERE email = '".addslashes(htmlspecialchars($email))."';";
        $data = Query($query);
        while($var = mysqli_fetch_assoc($data)) {
            $next = true;
            break;
        }
        if(!$next)
            ViewErrorPage("E-mail $email не существует!");
        /*if(isset($arr['d'][$key]) && $arr['d'][$key] == 'on') {
            $query = "DELETE FROM ".$GLOBALS['db_table']." WHERE email = '".addslashes(htmlspecialchars($email))."';";
            Query($query);
            continue;
        }*/
        if(isset($arr['l'][$key]) && $arr['l'][$key] == 'on')
            $lock = '1';
        else
            $lock = '0';
        $query = "UPDATE ".$GLOBALS['db_table']." SET ulock='$lock' WHERE email = '".addslashes(htmlspecialchars($email))."'";
        Query($query);
    }
}