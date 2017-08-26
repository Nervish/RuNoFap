<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('GetEmail');
Model('DiaryWriteNote');
Model('ReAddr');

if( ! (isset($_SESSION['auth']) and $_SESSION['auth']) ) {
    ViewErrorPage("Необходимо войти для добавления записи в дневник.");
}

$udata = GetEmail($_SESSION['email']);

if(isset($_POST['note']) and strlen($_POST['note']) > 0 and strlen(htmlspecialchars($_POST['note'])) <= 10000) {
    
    if(isset($_POST['public']) and $_POST['public'] == 'on') {
        $public = true;
    }
    else{
        $public = false;
    }
    
    $session = new BlackSession('nf_diary_post', md5($udata['email']), 'black_session/');
    if($session->Get('time') < time()-3600) {
        $session->Set('time', time());
        $session->Set('add_count', 0);
        $session->Apply();
    }
    if($session->Get('add_count') >= $GLOBALS['diary_post_limit'])
        ViewErrorPage("Исчерпан лимит записей, вы пишете слишком быстро!");
    
    DiaryWriteNote($udata['id'], $_POST['note'], $public);
    
    $session->Set('add_count', $session->Get('add_count')+1);
    $session->Apply();
    ReAddr('v=Diary&for='.$udata['id']);
}
else{
    ViewErrorPage("Пост слишком короткий или длинный!");
}