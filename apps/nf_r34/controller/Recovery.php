<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('Recover');

if(empty($_GET['code']))
    ViewErrorPage("Неправильный код активации!");
$code = str_replace(".", "", $_GET['code']);
if(file_exists("email/$code")) {
    $data = json_decode(file_get_contents("email/$code"), true);
    unlink("email/$code");
    if($data['rtime'] < time()-60*60*24)
        ViewErrorPage("Код больше недействителен, повторите попытку!");
    else{
        Recover($data['email'], $data['password']);
        ViewInfoPage("Восстановление пароля прошло успешно, можете войти в аккаунт.");
    }
}
else{
    ViewErrorPage("Неправильный код активации!");
}
