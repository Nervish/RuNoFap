<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('TimeCheck');
Model('WriteEmail');
Model('GetEmail');
Model('GetNick');

$session = new BlackSession('nf_create', md5($_SERVER['REMOTE_ADDR']), 'black_session/');
if($session->Get('time') < time()-60*60*24) {
    $session->Set('time', time());
    $session->Set('add_count', 0);
    $session->Apply();
}
if($session->Get('add_count') >= $GLOBALS['add_limit'])
    ViewErrorPage("Исчерпан лимит создания учетных записей для данного IP!");
if(!isset($_SESSION['captcha']) or empty($_SESSION['captcha']) or !isset($_POST['captcha']) or empty($_POST['captcha']))
    ViewErrorPage("Без ввода капчи регистрация невозможна!");
if($_SESSION['captcha_time'] < time()-60*5)
    ViewErrorPage("Время для ввода капчи истекло!");
if($_SESSION['captcha'] != $_POST['captcha']) {
    $_SESSION['captcha'] = "";
    ViewErrorPage("Неправильная капча!");
}
if(isset($_POST['nick']) and isset($_POST['email']) and isset($_POST['pass']) and isset($_POST['date'])) {
    $nick = addslashes(htmlspecialchars($_POST['nick']));
    $email = addslashes(htmlspecialchars($_POST['email']));
    $pass = addslashes(htmlspecialchars($_POST['pass']));
    $date = addslashes(htmlspecialchars($_POST['date']));
    if(GetEmail($email))
         ViewErrorPage("Данный e-mail уже используется!");
    if(GetNick($nick))
         ViewErrorPage("Данный ник уже используется!");
    if( ! (mb_strlen($nick, "UTF-8") >= 3 and mb_strlen($nick, "UTF-8") < 64) )
        ViewErrorPage("Ник слишком короткий или слишком длинный!");
    if( ! (mb_strlen($pass, "UTF-8") >= 4 and mb_strlen($pass, "UTF-8") < 64) )
        ViewErrorPage("Пароль слишком короткий или слишком длинный!");
    if( ! (mb_strlen($email, "UTF-8") >= 3 and mb_strlen($email, "UTF-8") < 64) )
        ViewErrorPage("Email слишком короткий или слишком длинный!");
    if( ! preg_match("/^[\S]+[\S\s]+[\S]+$/i", $nick) )
        ViewErrorPage("Ник не может содержать невидимые символы в начале и в конце!");
    if( ! preg_match("/^[\S]+$/i", $pass) )
        ViewErrorPage("Пароль не может содержать невидимые символы!");
    if( ! preg_match("/^[a-z0-9\._-]+@[a-z0-9\._-]+$/i", $email) )
        ViewErrorPage("Некорректный адрес e-mail!");
    $date = TimeCheck($date);

    $id = md5($email.microtime(true).$GLOBALS['salt']);
    $fp = fopen("email/$id", "w") or ViewErrorPage("Ошибка открытия файла!");
    fwrite($fp, json_encode(array("nick"=>$nick, "email"=>$email, "pass"=>$pass, "date"=>$date, "rtime"=>time()))) or ViewErrorPage("Ошибка записи в файл!");
    fclose($fp) or ViewErrorPage("Ошибка сохранения файла!");
    $session->Set('add_count', $session->Get('add_count')+1);
    $session->Apply();
    $msg = "Если вы желаете зарегистрироваться на ".$_SERVER['HTTP_HOST'].", пройдите по ссылке: 
<a href=\"$script?c=Activate&code=$id\">Активация</a>";
    WriteEmail($GLOBALS['email'], $email, "Подтверждение регистрации", $msg) or ViewErrorPage("Ошибка отправки письма!");
    ViewInfoPage("Подтвердите регистрацию, нажав ссылку в отправленом на $email письме.");
}
