<?php

//      Параметры MYSQL базы данных
$db_host = 'localhost';
$db_name = 'test';
$db_user = 'root';
$db_pass = 'password';
$db_table = 'nofap';
$db_links = 'links';
$db_fails = 'fails';
$db_forum = 'forum';
$db_diary = 'diary';

$timezone = "Europe/Moscow";
$timezone_fix = 3600*3;                         //  Смещение времени в секундах относительно Гринвича
$email = "NF <noreply@nofap.ru>";               //  Мыло для рассылки сообщений
$admin_email = "Админ <admin@nofap.ru>";        //  Мыло админа
$files_dir = "files";                           //  Директория с файлами
$error_log = "data/One/Error.php";              //  Лог-файл
$sessions_save_path = $_SERVER['DOCUMENT_ROOT'].'/../sessions/';  // Директория для хранения сессий

$admins = array("admin@localhost");          // Мыло админа, из числа зарегистрированных пользователей
$salt = "something must be here";                         // Соль для хеширования айпи
$days = 7;                                      // Сколько дней запись держится в таблице, если юзер на жал кнопки на коне/сорвал/обновить в профиле

$add_limit = 5; // add limit for 24h            // Ограничение на кол-во регистраций в сутки, для айпи
$question_limit = 5;                            // Ограничение кол-ва предложений
$suggest_limit = 20;                            // Ограничение кол-ва предлагаемых для кнопки угрозы ссылок
$recover_limit = 3;                             // Ограничение на кол-во восстановлений пароля
$change_nick_limit = 3;                         // Ограничение на кол-во смены ника для пользователя, в неделю
$forum_post_limit = 5;                          // Ограничение кол-ва сообщений на форуме за час, для пользователя
$diary_post_limit = 20;                         // Ограничение кол-ва создаваемых за час записей в дневнике
$change_email_limit = 2;                        // Ограничение на кол-во изменений e-mail в неделю
$max_days_at_start = 1000;                      // Макс. кол-во дней, которые можно вручную выставить в профиле

//      Кол-во страниц/записей для форума, треда и т.д.
$per_page_4notes = 1;                          // Кол-во новостей/вопросов/ответов на страницах
$per_page_4diary = 25;
$per_page_4forum = 25;
$per_page_4thread = 500;
$per_page_4admin = 15;
$per_page_4main = 300;
$full_ip_detecting = true;                      // Включить продвинутое определение одинаковых айпи в админке
$news_at_main = 3;
$diary_news = 15;                               // Кол-во строк в обновлениях дневников на главной

$forum_captcha = false;         // Использовать ли капчу на форуме
$diary_captcha = false;         // Использовать ли капчу в дневнике
$rebell_army = "Амбидекстры";   // Третья сторона в войне
$rank_system = 'RussianArmy';   // Система рангов по умолчанию
$rank_systems = array('RussianArmy'=>'Армейская', 'TableOfRanks'=>'Табель о рангах',
'Blat'=>'Воровская', 'FeodalEurope'=>'Феодальная', 'Church'=>'Церковная',
'WH40k_imperium'=>'WH40k Империум', 'Deutsch'=>'Deutsch', 'Dvosch'=>'Двощерская',
'SS'=>'SS');

$maintenance = false; // true чтобы включить техобслуживание
$secure_connection = false; // true, чтобы перенаправляло на https, и в ссылках указывало https

?>
