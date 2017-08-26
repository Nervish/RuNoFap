<?php global $script; ?>
<script type="text/javascript">
var show = false;
function click_menu() {
    var menu = document.getElementById("hmenu");
    var mbutton = document.getElementById("mbutton");
    menu.style.left = menu.offsetWidth*(-1)+'px';
    if(!show) {
        show_menu(menu, mbutton);
    }
    else{
        hide_menu(menu, mbutton);
    }
}
function show_menu(menu, button) {
    menu.style.left = '0';
    button.style.transform = 'rotate(180deg)';
    show = true;
}
function hide_menu(menu, button) {
    menu.style.left = menu.offsetWidth*(-1)+'px';
    button.style.transform = 'rotate(0deg)';
    show = false;
}
function onmain() {
    var menu = document.getElementById("hmenu");
    var mbutton = document.getElementById("mbutton");
    hide_menu(menu, mbutton);
}
</script>
<header class="legacy_header">
<div>
<img id="mbutton" onclick="click_menu();" class="little-img" src="img/menu.png"><a class="mainlink" href="<?=$script?>">NF</a>
</div>
<div id="hmenu" class="hmenu left"><br /><br />
<li><a href="<?=$script?>?v=Main" title="На главную">Главная</a></li>
<?php if(isset($_SESSION['admin']) and $_SESSION['admin']): ?>
<li><a href="<?=$script?>?v=Admin" title="Админка">Админка</a></li>
<?php endif; ?>
<?php if(isset($_SESSION['auth']) and $_SESSION['auth']): ?>
<li><a href="<?=$script?>?v=Profile" title="Профиль">Профиль</a></li>
<?php endif; ?>
<?php if(!isset($_SESSION['auth']) or !$_SESSION['auth']): ?>
<li><a href="<?=$script?>?v=Login" title="Войти">Войти</a></li>
<li><a href="<?=$script?>?v=Register" title="Подключиться">Регистрация</a></li>
<?php endif; ?>
<li><a href="<?=$script?>?v=Forum" title="Форум">Форум</a></li>
<li><a href="<?=$script?>?v=NoFapWar" title="NoFap война">Война</a></li>
<li><a href="<?=$script?>?v=News" title="Новости">Новости</a></li>
<?php if(isset($_SESSION['auth']) and $_SESSION['auth']): ?>
<li><a href="<?=$script?>?c=Quit" title="Выход">Выход</a></li>
<?php endif; ?>
<br />
<li><a href="<?=$script?>?c=SetDevice&device=desktop" title="Версия для ПК">Версия для ПК</a></li>
<li><a href="<?=$script?>?v=NoFapWarArmies" title="Армии">Армии</a></li>
<li><a href="<?=$script?>?v=WarChronicle" title="Военная хроника">Военная хроника</a></li>
<li><a href="<?=$script?>?v=WarMemorial" title="Военная летопись">Летопись</a></li>
<li><a href="<?=$script?>?v=Files" title="Файлы">Файлы</a></li>
<li><a href="<?=$script?>?v=Links" title="Ссылки">Ссылки</a></li>
<li><a href="<?=$script?>?v=Question" title="Предложения">Предложения</a></li>
<li><a href="<?=$script?>?v=FailsInfo" title="Статистика сервера">Статистика сервера</a></li>
<li><a href="<?=$script?>?v=DiaryList" title="Список дневников">Список дневников</a></li>
<li><a href="<?=$script?>?v=Diary" title="Лента дневников">Лента дневников</a></li>
<?php if(isset($_SESSION['auth']) and $_SESSION['auth']): ?>
<li><a href="<?=$script?>?v=DiaryBookmarks" title="Список избранных">Список избранных</a></li>
<li><a href="<?=$script?>?v=DiaryFavourite" title="Лента избранных">Лента избранных</a></li>
<?php endif; ?>
</div>
</header>
<main id="main" onmouseover="onmain();">
