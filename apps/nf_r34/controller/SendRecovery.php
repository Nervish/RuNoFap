<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('WriteEmail');
Model('GetEmail');

if(!isset($_SESSION['captcha']) or empty($_SESSION['captcha']) or !isset($_POST['captcha']))
    ViewErrorPage("Без ввода капчи нельзя восстановить пароль!");
if($_SESSION['captcha'] != $_POST['captcha'])
    ViewErrorPage("Неправильная капча!");
sleep(1);
$email = addslashes(htmlspecialchars($_POST['email']));
$pass = addslashes(htmlspecialchars($_POST['pass']));
if( ! (strlen($pass) >= 4 and strlen($pass) < 64) )
    ViewErrorPage("Пароль слишком короткий или слишком длинный!");
if( ! (strlen($email) >= 3 and strlen($email) < 64) )
    ViewErrorPage("Email слишком короткий или слишком длинный!");
if( ! $udata = GetEmail($email) )
    ViewErrorPage("Учетной записи с e-mail $email не существует!");
$session = new BlackSession('nf_recover_limit', md5($email), 'black_session/');
if($session->Get('time') < time()-60*60*24) {
    $session->Set('time', time());
    $session->Set('recover_count', 0);
    $session->Apply();
}
if($session->Get('recover_count') >= $GLOBALS['recover_limit'])
    ViewErrorPage("Исчерпан лимит попыток восстановления пароля!");
$id = md5($email.microtime(true).$GLOBALS['salt']);
$fp = fopen("email/$id", "w") or ViewErrorPage("Ошибка открытия файла!");
fwrite($fp, json_encode(array("email"=>$email, "password"=>$pass, "rtime"=>time()))) or ViewErrorPage("Ошибка записи в файл!");
fclose($fp) or ViewErrorPage("Ошибка сохранения файла!");
$session->Set('recover_count', $session->Get('recover_count')+1);
$session->Apply();
$msg = "Если вы желаете восстановить пароль на ".$_SERVER['HTTP_HOST'].", пройдите по ссылке: 
<a href=\"$script?c=Recovery&code=$id\">Восстановление пароля</a>
Ваш ник: ".$udata['nick'];
WriteEmail($GLOBALS['email'], $email, "Восстановление пароля", $msg) or ViewErrorPage("Ошибка отправки письма!");
ViewInfoPage("Для восстановления пароля пройдите по ссылке, отправленной на $email письме.");
