<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('DBConnect');
Model('Query');

function ChangeEmail($old_email, $new_email) {
    DBConnect();
    $old = addslashes($old_email);
    $new = addslashes($new_email);
    $query = "UPDATE nofap SET email = '$new' WHERE email = '$old';";
    $data = Query($query);
    if(!$data) {
        ViewErrorPage("E-mail не был изменен.");
    }
}
