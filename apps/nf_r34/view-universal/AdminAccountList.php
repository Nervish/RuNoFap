<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('CheckAdminAccess');
Model('GetFullCount');
Model('GetFullTable');

CheckAdminAccess();

if(isset($_GET['page']) and is_numeric($_GET['page']))
    $page = $_GET['page'];
else
    $page = 1;
if(isset($_GET['ip']))
    $ip = addslashes(htmlspecialchars($_GET['ip']));
else
    $ip = "";
if(isset($_GET['sort']))
    $sort = addslashes(htmlspecialchars($_GET['sort']));
else
    $sort = "time";
$pages = ceil(GetFullCount($ip)/$GLOBALS['per_page_4admin']);

if($GLOBALS['full_ip_detecting']) {
    $ip_list = array();
    if($ip != "")
        $ip_list[$ip] = 2;
    else{
        $arr = GetFullTable(0, GetFullCount(''), $sort, $ip);
        foreach($arr as $var) {
            if(isset($ip_list[$var['ip_hash']]))
                $ip_list[$var['ip_hash']]++;
            else
                $ip_list[$var['ip_hash']] = 1;
        }
    }
}

$arr = GetFullTable(($page-1)*$GLOBALS['per_page_4admin'], $GLOBALS['per_page_4admin'], $sort, $ip);
$count = 0;
ViewHtmlTop("Список аккаунтов", 'AdminAccountList.css');
ViewHeader();

?>

<form name="f" id="f" method="POST" action="<?=$script?>?c=MassiveEdit"></form>
<div class="wrapper">
  <div class="acc-list">
    <div class="acc-list__row acc-list__row_head">
      <div class="acc-list__element acc-list__element_ban">Бан</div>
      <div class="acc-list__element acc-list__element_edit">Правка</div>
      <div class="acc-list__element acc-list__element_nick"><a class="link" href="<?=$script?>?v=AdminAccountList&sort=nick&ip=<?=$ip?>">nick</a></div>
      <div class="acc-list__element acc-list__element_email"><a class="link" href="<?=$script?>?v=AdminAccountList&sort=email&ip=<?=$ip?>">email</a></div>
      <div class="acc-list__element acc-list__element_refresh"><a class="link" href="<?=$script?>?v=AdminAccountList&sort=refresh&ip=<?=$ip?>">refresh</a></div>
      <div class="acc-list__element acc-list__element_time"><a class="link" href="<?=$script?>?v=AdminAccountList&sort=time&ip=<?=$ip?>">time</a></div>
      <div class="acc-list__element acc-list__element_iphash"><a class="link" href="<?=$script?>?v=AdminAccountList&sort=ip_hash&ip=<?=$ip?>">ip_hash</a></div>
      <div class="acc-list__element acc-list__element_ctime"><a class="link" href="<?=$script?>?v=AdminAccountList&sort=c_time&ip=<?=$ip?>">c_time</a></div>
    </div>
<?php foreach($arr as $var): ?>
<?php
    if($var['refresh'] < time()-60*60*24*$GLOBALS['days']) {
        $color=' acc-list__row_old';
    } else{
        $color='';
    }
    if($GLOBALS['full_ip_detecting']) {
        if($ip_list[$var['ip_hash']] > 1)
            $bg_color = ' acc-list__element_iphash_retry';
        else
            $bg_color = '';
    } else{
        $bg_color = "";
        if(isset($arr[$count+1]) && $arr[$count+1]['ip_hash'] == $var['ip_hash']) {
            $bg_color = ' acc-list__element_iphash_retry';
        } elseif(isset($arr[$count-1]) && $arr[$count-1]['ip_hash'] == $var['ip_hash']) {
            $bg_color = ' acc-list__element_iphash_retry';
        }
    }
    if($var['ulock'])
        $str = "checked";
    else
        $str = "";
?>
    <div class="acc-list__row<?=$color?>">
      <div class="acc-list__element acc-list__element_ban"><input type="checkbox" name="l[<?=$count?>]" form="f" <?=$str?> /></div>
      <div class="acc-list__element acc-list__element_edit"><a class="link" href="<?=$script?>?v=AdminEdit&target=<?=$var['id']?>">[+]</a></div>
      <div class="acc-list__element acc-list__element_nick"><?=$var['nick']?></div>
      <div class="acc-list__element acc-list__element_email"><?=$var['email']?></div>
      <div class="acc-list__element acc-list__element_refresh"><?=date("d.m.Y H:i:s", $var['refresh'])?></div>
      <div class="acc-list__element acc-list__element_time"><?=date("d.m.Y H:i:s", $var['time'])?></div>
      <div class="acc-list__element acc-list__element_iphash<?=$bg_color?>"><a class="link" href="<?=$script?>?v=AdminAccountList&sort=<?=$sort?>&ip=<?=$var['ip_hash']?>"><?=$var['ip_hash']?></a></div>
      <div class="acc-list__element acc-list__element_ctime"><?=date("d.m.Y H:i:s", $var['c_time'])?></div>
      <div class="acc-list__id"><input type="text" name="e[<?=$count?>]" form="f" value="<?=addslashes(htmlspecialchars($var['email']))?>" /></div>
    </div>
<?php $count++; ?>
<?php endforeach; ?>
  </div>
</div>

<div class="wrapper">
  <input type="submit" form="f" value="Отправить" />
</div>

<?php
Resource("Paginator.php");
Paginator("AdminAccountList", $page, $pages, "sort=$sort&ip=$ip");
?>
<!--<div class="navigation navigation__paginator navigation__link navigation__hidden"></div>-->
<!--<div class="acc-list__row_old acc-list__element_iphash_retry"></div>-->
</main>
</body>
</html>
<?php die; ?>

<tbody>
    
<tr bgcolor="<?=$color?>">
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td <?=$bg_color?>></td>
    <td></td>
    <td hidden></td>
</tr>
