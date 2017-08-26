<?php global $script; ?>
<header class="legacy_header">
<div>
<ul class="menu">
<li><a href="<?=$script?>?v=Main" title="На главную">Главная</a></li>
<?php if(isset($_SESSION['admin']) and $_SESSION['admin']): ?>
<li><a href="<?=$script?>?v=Admin" title="Админка">Админка</a></li>
<?php endif; ?>
<?php if(isset($_SESSION['auth']) and $_SESSION['auth']): ?>
<li><a href="<?=$script?>?v=Profile" title="Профиль">Профиль</a></li>
<?php endif; ?>
<?php if(!isset($_SESSION['auth']) or !$_SESSION['auth']): ?>
<li><a href="<?=$script?>?v=Login" title="Войти">Войти</a></li>
<li><a href="<?=$script?>?v=Register" title="Присоединиться">Присоединиться</a></li>
<?php endif; ?>
<li>
<a href="<?=$script?>?v=NoFapWar" title="NoFap война">Война</a>
<ul class="submenu">
<li><a href="<?=$script?>?v=NoFapWarArmies" title="Армии">Армии</a></li>
<li><a href="<?=$script?>?v=WarChronicle" title="Военная хроника">Хроника</a></li>
<li><a href="<?=$script?>?v=WarMemorial" title="Военная летопись">Летопись</a></li>
</ul>
</li>
<li><a href="<?=$script?>?v=Forum" title="Форум">Форум</a></li>
<li><a href="<?=$script?>?v=News" title="Новости">Новости</a></li>
<li>
<a href="#">Дополнительно</a>
<ul class="submenu">
<li><a href="<?=$script?>?c=SetDevice&device=mobile" title="Мобильная версия">Мобильная версия</a></li>
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
</ul>
</li>
<?php if(isset($_SESSION['auth']) and $_SESSION['auth']): ?>
<li><a href="<?=$script?>?c=Quit" title="Выход">Выход</a></li>
<?php endif; ?>
</ul>
</div>
</header>
<main id="main">
