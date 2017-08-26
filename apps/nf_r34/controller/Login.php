<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('GetEmail');
Model('GetNick');
Model('ReAddr');
Model('PasswordCheck');

sleep(0.75);
if(isset($_POST['login']) and isset($_POST['pass'])) {
    $login = $_POST['login'];
    $pass = $_POST['pass'];
    $udata = GetEmail($login);
    if(empty($udata['password']))
        $udata = GetNick($login);
    if($udata['ulock']) {
        $_SESSION['auth'] = false;
        ViewErrorPage("Учетная запись заблокирована!");
    }
    if(isset($udata['password']) and PasswordCheck($udata['password'], $pass)) {
        $_SESSION['auth'] = true;
        $_SESSION['email'] = $udata['email'];
        $_SESSION['admin'] = false;
        $_SESSION['rank_system'] = $udata['rank_system'];
        
        foreach($GLOBALS['admins'] as $admin)
            if($admin == $udata['email']) {
                $_SESSION['admin'] = true;
                break;
            }
        ReAddr('v=Profile');
    }
    else{
        ViewErrorPage("Неправильный логин или пароль!");
    }
}
else{
    ViewErrorPage("Форма прислала некорректные данные!");
}
