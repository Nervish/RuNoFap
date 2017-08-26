<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('DBConnect');
Model('Query');
Model('PasswordGen');

function ChangePass($email, $newpass) {
    DBConnect();
    $e = addslashes(htmlspecialchars($email));
    $new = PasswordGen(addslashes(htmlspecialchars($newpass)));
    
    $query = "UPDATE ".$GLOBALS['db_table']." SET password = '$new' WHERE email = '$e';";
    Query($query);
    
    if(mysqli_affected_rows($GLOBALS['link']) == 1) {
        ViewInfoPage("Пароль успешно изменен.");
    }
    else{
        ViewErrorPage("Произошла ошибка при смене пароля. \nВозможно, старый пароль был введен неверно.");
    }
}