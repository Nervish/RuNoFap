<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('GetEmail');
Model('MakePost');
Model('ReAddr');

if(isset($_POST['subject']) and strlen($_POST['subject']) <= 128) {
    if(isset($_POST['post']) and strlen($_POST['post']) > 0 and strlen(htmlspecialchars($_POST['post'])) <= 10000) {
    
        if($GLOBALS['forum_captcha'] or ! (isset($_SESSION['auth']) and $_SESSION['auth'])) {
            if( ! (isset($_POST['captcha']) and isset($_SESSION['captcha']) and !empty($_POST['captcha'])) ) {
                ViewErrorPage("Для постинга следует ввести капчу!");
            }
            if($_SESSION['captcha_time'] < time()-1800) {
                ViewErrorPage("Срок действия капчи истек, повторите отправку.");
            }
            if($_POST['captcha'] != $_SESSION['captcha']) {
                ViewErrorPage("Капча введена неправильно!");
            }
        }
        
        if(isset($_POST['to']) and is_numeric($_POST['to']) and $_POST['to'] >= 0) {
            if($_POST['to'] and isset($_POST['false_nick']) and ($_POST['false_nick'] == 'spy' or $_POST['false_nick'] == 'diversant')) {
                $email = $_POST['false_nick'];
            }
            else{
                if(isset($_SESSION['auth']) and $_SESSION['auth']) {
                    $email = $_SESSION['email'];
                }
                else{
                    $email = 'guest';
                }
            }
            $udata = GetEmail($email);
            $author_id = $udata['id'];
            
            $session = new BlackSession('nf_forum_post', md5($email), 'black_session/');
            if($session->Get('time') < time()-60*60) {
                $session->Set('time', time());
                $session->Set('add_count', 0);
                $session->Apply();
            }
            if($session->Get('add_count') >= $GLOBALS['forum_post_limit'])
                ViewErrorPage("Исчерпан лимит сообщений, вы постите слишком быстро!");
            
            $data = MakePost($_POST['to'], $_POST['subject'], $_POST['post'], $author_id);
            /*if(isset($_SERVER['HTTP_USER_AGENT']) and !empty($_SERVER['HTTP_USER_AGENT'])) {
                WriteLog('data/One/PostersUA.php', $_SERVER['HTTP_USER_AGENT'].substr($_POST['post'], 0, 100));
            }*/
            if(isset($_POST['false_nick']) and isset($_SESSION['auth']) and $_SESSION['auth']) {
                $user = GetEmail($_SESSION['email']);
                WriteLog('data/One/FalseNick.php', $user['email'].' ['.$user['nick'].'] '.substr($_POST['post'], 0, 100));
            }
            
            $session->Set('add_count', $session->Get('add_count')+1);
            $session->Apply();
            $page = ceil($data['count']/$GLOBALS['per_page_4thread']);
            ReAddr("v=ShowThread&thread=".$data['thread']."&page=$page#bottom");
       }
       else{
            ViewErrorPage("Форма предоставила не все данные!");
       }
    }
    else{
        ViewErrorPage("Пост слишком короткий или длинный!");
    }
}
else{
    ViewErrorPage("Тема слишком длинная!");
}