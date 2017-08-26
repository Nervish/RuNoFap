<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('Auth');
Model('ChangePass');
Model('PasswordCheck');

$udata = Auth();

if(isset($_POST['pass']) and isset($_POST['newpass']) and isset($_POST['newpass2'])) {
    $pass = addslashes(htmlspecialchars($_POST['pass']));
    $newpass = addslashes(htmlspecialchars($_POST['newpass']));
    $newpass2 = addslashes(htmlspecialchars($_POST['newpass2']));
    
    if( ! PasswordCheck($udata['password'], $pass) ) {
        ViewErrorPage('Пароль введен неверно!');
    }
    
    if($newpass != $newpass2) {
        ViewErrorPage("Пароли не совпадают!");
    }
    
    if($pass == $newpass) {
        ViewErrorPage("Старый и новый пароль совпадают.");
    }
    
    if( ! (mb_strlen($newpass, "UTF-8") >= 4 and mb_strlen($pass, "UTF-8") < 64) )
        ViewErrorPage("Пароль слишком короткий или слишком длинный!");
    
    if( ! preg_match("/^[\S]+$/i", $newpass) )
        ViewErrorPage("Пароль не может содержать невидимые символы!");  
    
    ChangePass($_SESSION['email'], $newpass);
    
    ViewInfoPage("Пароль успешно изменен.");
}
ViewErrorPage("Некорректные данные!");
