<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

if(!isset($_SESSION['religious'])) {
    $_SESSION['religious'] = false;
}
ViewHtmlTop("Угроза", "style-emergency.css");

?>

<button onclick="location.href='?c=Emergency&cat=em'" id="emergency" class="pbutton"><img class="little-img" src="images/redcross.png" class="cross">Угроза</button>
<button onclick="location.href='?c=Emergency&cat=rej'" id="rejection" class="pbutton">Отказ</button>
<button onclick="location.href='?c=Emergency&cat=dep'" id="depression" class="pbutton">Депрессия</button>
<button onclick="location.href='?c=Emergency&cat=rel'" id="relapsed" class="pbutton">Рецидив</button>

<button onclick="location.href='?v=EmergencySuggestor'" id="suggest" class="footer-button">Предложить</button>
<button onclick="location.href='?v=Main'" id="nofap" class="footer-button">На главную</button>

</div>
</body>
</html>