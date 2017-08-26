<?php

include('config.php');
include('black_session.php');

$app = "nf_r34";
$default_action = "Main";

function rw_fmeow() {
    global $app, $default_action, $host, $script, $secure_connection, $device, $rw_fmeow;
    $rw_fmeow = true;
    
    if(basename($_SERVER['SCRIPT_NAME']) == 'nossl.php') {
        $nossl = true;
        $host = 'http://';
    }
    else{
        $nossl = false;
        if($secure_connection) {
            $host = 'https://';
        }
        else{
            $host = 'http://';
        }
    }
    $host .= $_SERVER['HTTP_HOST'];
    $script = $host.$_SERVER['SCRIPT_NAME'];
    
    if($secure_connection and $_SERVER['SERVER_PORT'] == 80 and !$nossl) {
        header("Location: $script?".$_SERVER['QUERY_STRING']);
    }
    
    //session_set_cookie_params(259200);
    ini_set('session.save_path', $GLOBALS['sessions_save_path']);
    ini_set('session.gc_maxlifetime', 432000);
    session_start();
    date_default_timezone_set($GLOBALS['timezone']);
    
    if(isset($_SESSION['device']) and !empty($_SESSION['device'])) {
        $device = $_SESSION['device'];
    }
    else{
        $phone = false;
        $phones = array('Android', 'iPhone', 'BlackBerry', 'Windows CE', 'MIDP', 'J2ME', 'WAP', 'Symbian', 'Smartphone', 'Nokia');
        
        if(isset($_SERVER['HTTP_USER_AGENT']) and $_SERVER['HTTP_USER_AGENT']) {
            foreach($phones as $str) {
                if(stripos($_SERVER['HTTP_USER_AGENT'], $str) !== false) {
                    $phone = true;
                    break;
                }
            }
        }
    
        if($phone) {
            $device = 'mobile';
        }
        else{
            $device = 'desktop';
        }
        //$device = 'mobile';
    }
    $_SESSION['device'] = $device;
    
    
    if($GLOBALS['maintenance'] and !isset($_SESSION['admin'])) {
        ViewInfoPage("Сайт находится на техническом обслуживании, подождите несколько минут.");
    }
    
    if(empty($_SESSION['auth'])) {
        $_SESSION['auth'] = false;
    }
    $type = "View";
    
    if(isset($_GET['v']) and !empty($_GET['v']) and strlen($_GET['v']) < 32) {
        $route = str_replace(".", "", $_GET['v']);
        $path = "apps/$app/view-$device/$route.php";
        if(!file_exists($path)) {
            $path="apps/$app/view-universal/$route.php";
            if(!file_exists($path)) {
                $route = $default_action;
                $path = "apps/$app/view-$device/$route.php";
                if(!file_exists($path)) {
                    $path = "apps/$app/view-universal/$route.php";
                }
            }
        }
    }
    elseif(isset($_GET['c']) and !empty($_GET['c']) and strlen($_GET['c']) < 32) {
        $route = str_replace(".", "", $_GET['c']);
        $path = "apps/$app/controller/$route.php";
        if(file_exists($path)) {
            $type = "Controller";
        }
        else{
            $route = $default_action;
            $path = "apps/$app/view-$device/$default_action.php";
            if(!file_exists($path)) {
                $path = "apps/$app/view-universal/$default_action.php";
            }
        }
    }
    else{
        $route = $default_action;
        $path = "apps/$app/view-$device/$default_action.php";
        if(!file_exists($path)) {
            $path = "apps/$app/view-universal/$route.php";
        }
    }
    if(file_exists($path)) {
        include_once($path);
    }
    else{
        die('Error: resources was not found.');
    }
}

// Model

function DBConnect() {
    if(isset($GLOBALS['link'])) {
        return true;
    }
    $link = mysqli_connect($GLOBALS['db_host'], $GLOBALS['db_user'], $GLOBALS['db_pass'], $GLOBALS['db_name']);  
    if(!$link) {
        ErrorLog("Произошла ошибка при подключении к СУБД.");
        ViewErrorPage("Произошла ошибка при подключении к СУБД.");
    }
    $GLOBALS['link'] = $link;
}
function Query($query = "") {
    $result = mysqli_query($GLOBALS['link'], $query);
    if(!$result) {
        ErrorLog("Ошибка СУБД: ".mysqli_error($GLOBALS['link'])."; query: $query; request: ".$_SERVER['QUERY_STRING']);
        ViewErrorPage("Произошла ошибка при обработке запроса к СУБД.");
    }
    return $result;
}
function WriteLog($logfile, $text) {
    $fp = fopen($logfile, 'a+');
    if(!filesize($logfile)) {
        fwrite($fp, "<?php\n");
    }
    fwrite($fp, date("#  d.m.Y H:i:s    ").str_replace(array("\n", "\r"), ' ', $text)."\n");
    fclose($fp);
}
function ErrorLog($error = "") {
    WriteLog($GLOBALS['error_log'], $error);
}
function ReAddr($to = "", $to_ref = false) {
    global $script, $options;
    if($to_ref) {
        if(isset($_SERVER['HTTP_REFERER']) and !empty($_SERVER['HTTP_REFERER'])) {
            header("Location: ".$_SERVER['HTTP_REFERER']);
            die;
        }
    }
    
    if($to) {
        header("Location: $script?$to");
    }
    else{
        header("Location: $script");
    }
    die;
}

function Model($model) {
    if(!function_exists($model)) {
        global $app;
        if(file_exists("apps/$app/model/$model.php")) {
            include_once("apps/$app/model/$model.php");
        }
        else{
            die("Error: resource model/$model not found.");
        }
    }
}

function Resource($res = "") {
    global $app;
    if(file_exists("apps/$app/res/$res")) {
        include("apps/$app/res/$res");
    }
    else{
        ViewErrorPage("Ошибка: ресурс не найден.");
    }
}

// View

function ViewHtmlTop($title = "NF", $style = false) {
    global $app, $device;
    //$list = array("universal-style.css", "$device-style.css", "universal-header.css", "$device-header.css", "my.css");
    $list = array('style.css', 'universal-header.css', "$device-header.css");
    if($style) {
        if(is_array($style)) {
            foreach($style as $s) {
                array_push($list, $s);
            }
        }
        else{
            array_push($list, "style/$style");
        }
    }
    echo "<!DOCTYPE html>
<html lang=\"ru\">
<head>
<meta charset=\"utf-8\">
<meta name=viewport content=\"width=device-width, initial-scale=1\">
<title>$title</title>
<style type=\"text/css\">\n";

    foreach($list as $somestyle) {
        if(file_exists("apps/$app/res/$somestyle")) {
            echo file_get_contents("apps/$app/res/$somestyle");
        }
    }
echo "</style>
</head>
<body class=\"legacy\">\n";
}
function ViewHeader() {
    global $app, $device;
    include("apps/$app/res/$device-header.php");
}
function ViewPage($title = "NF", $text = "...") {
    ViewHtmlTop($title);
    ViewHeader();
    echo "<div>\n".nl2br("$text\n")."</div>\n</main>\n</body>\n</html>";
    die();
}
function ViewErrorPage($text = "Произошла ошибка.") {
    ViewPage("Ошибка", $text);
}
function ViewInfoPage($text = "...") {
    ViewPage("NF", $text);
}

try{
    rw_fmeow();
}
catch(Exception $e) {
    ErrorLog("Сгенерировано исключение: ".$e->getMessage());
    ViewErrorPage("Произошла ошибка. Повторите запрос, и сообщите администратору о неполадке.");
}

?>
