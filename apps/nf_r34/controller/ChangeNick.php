<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('Auth');
Model('ChangeNick');

Auth();

if(isset($_POST['nick'])) {
    $nick = addslashes(htmlspecialchars($_POST['nick']));
    
    if( ! (mb_strlen($nick, "UTF-8") >= 3 and mb_strlen($nick, "UTF-8") < 64) )
        ViewErrorPage("Ник слишком короткий или слишком длинный!");
        
    if( ! preg_match("/^[\S]+[\S\s]+[\S]+$/i", $nick) )
        ViewErrorPage("Ник не может содержать невидимые символы в начале и в конце!");    
    
    $session = new BlackSession('nf_change_nick', md5($_SESSION['email']), 'black_session/');
    if($session->Get('time') < time()-7*24*3600) {
        $session->Set('time', time());
        $session->Set('count', 0);
        $session->Apply();
    }
    if($session->Get('count') >= $GLOBALS['change_nick_limit'])
        ViewErrorPage("Ник можно менять не больше ".$GLOBALS['change_nick_limit']." раз в неделю!");
    
    ChangeNick($_SESSION['email'], $nick);
    
    $session->Set('count', $session->Get('count')+1);
    $session->Apply();
    
    ViewInfoPage("Никнейм успешно изменен.");
}
ViewErrorPage("Некорректный ник!");
