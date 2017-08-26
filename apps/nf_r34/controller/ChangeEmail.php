<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('Auth');
Model('WriteEmail');
Model('ChangeEmail');
Model('PasswordCheck');

$udata = Auth();

if(isset($_POST['old_email'])) {
    
    $fields = array('old_email', 'new_email', 'pass', 'captcha');
    foreach($fields as $f) {
        if( ! (isset($_POST[$f]) and !empty($_POST[$f]))) {
            ViewErrorPage("Все поля должны быть заполнены!");
        }
    }
    
    $session = new BlackSession('nf_change_email', md5($_SESSION['email']), 'black_session/');
    if($session->Get('time') < time()-7*24*3600) {
        $session->Set('time', time());
        $session->Set('count', 0);
        $session->Apply();
    }
    
    if($session->Get('count') >= $GLOBALS['change_email_limit'])
        ViewErrorPage("E-mail можно менять не больше ".$GLOBALS['change_email_limit']." раз в неделю!");
    
    if(!isset($_SESSION['captcha']) or $_POST['captcha'] != $_SESSION['captcha']) {
        ViewErrorPage("Капча введена неправильно!");
    }
    
    if( ! preg_match("/^[a-z0-9\._-]+@[a-z0-9\._-]+$/i", $_POST['new_email']) ) {
        ViewErrorPage("Некорректный адрес нового e-mail!");
    }
    
    if($_POST['old_email'] != $udata['email']) {
        ViewErrorPage("Старый e-mail указан неверно!");
    }
    
    if( ! PasswordCheck($udata['password'], $_POST['pass']) ) {
        ViewErrorPage("Пароль введен неверно!");
    }
    
    $id = md5($udata['email'].microtime(true).$GLOBALS['salt']);
    $fp = fopen("email/change_email_$id", "w") or ViewErrorPage("Ошибка открытия файла!");
    fwrite($fp, json_encode(array("old_email"=>$_POST['old_email'],"new_email"=>$_POST['new_email'], "rtime"=>time()))) or ViewErrorPage("Ошибка записи в файл!");
    fclose($fp) or ViewErrorPage("Ошибка сохранения файла!");
    
    $msg = "Если вы желаете сменить e-mail на ".$_SERVER['HTTP_HOST'].", пройдите по ссылке: 
<a href=\"$script?c=ChangeEmail&code=$id\">Смена e-mail</a>
Ваш ник: ".$udata['nick'];
    WriteEmail($GLOBALS['email'], $_POST['old_email'], "Cмена e-mail", $msg) or ViewErrorPage("Ошибка отправки письма!");
    
    $session->Set('count', $session->Get('count')+1);
    $session->Apply();
    
    ViewInfoPage("Подтвердите смену e-mail переходом по ссылке, отправленой на старый почтовый ящик.");
}
else if(isset($_GET['code'])) {
    if(empty($_GET['code'])) {
        ViewErrorPage("Не указан код активации!");
    }
    $code = str_replace(".", "", $_GET['code']);
    if(file_exists("email/change_email_$code")) {
        $data = json_decode(file_get_contents("email/change_email_$code"), true);
        unlink("email/change_email_$code");
        if($data['rtime'] < time()-60*60*24) {
            ViewErrorPage("Код больше недействителен, повторите попытку!");
        }
        else{
            ChangeEmail($data['old_email'], $data['new_email']);
            session_destroy();
            ViewInfoPage("Смена e-mail прошла успешно. Можете войти в аккаунт.");
        }
    }
    else{
        ViewErrorPage("Неправильный код активации!");
    }
}

ViewErrorPage("Все поля должны быть заполнены!");
