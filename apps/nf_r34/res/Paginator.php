<?php

function Paginator($act, $page, $pages, $additional = "") {
    global $script;
    if($pages < 2) {
        return;
    }
    if($additional) {
        $add = "&$additional";
    }
    else{
        $add = "";
    }
    $p1 = $p2 = "navigation__hidden";
    if($page > 1) {
        $p1 = "navigation__link";
    }
    if($page < $pages) {
        $p2 = "navigation__link";
    }
    echo "<div class=\"wrapper\">
  <div class=\"navigation\">
    <a class=\"navigation__paginator $p1\" href=\"$script?v=$act&page=1$add\">&lt;&lt;</a>
    <a class=\"navigation__paginator $p1\" href=\"$script?v=$act&page=".($page-1)."$add\">&lt;</a>
    <a class=\"navigation__paginator $p2\" href=\"$script?v=$act&page=".($page+1)."$add\">&gt;</a>
    <a class=\"navigation__paginator $p2\" href=\"$script?v=$act&page=$pages$add\">&gt;&gt;</a>
  </div>
</div>\n";
}

?>
