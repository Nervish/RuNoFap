<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('Auth');
Model('GetNoFapWar');
Model('GetWar');
Model('GetWarrior');

$war = GetWar();
$time = time();

if(!$data = GetNoFapWar()) {
    if($war['recruting'] and $time < $war['start']) {
        ViewInfoPage("В данный момент ведется <a class=\"link\" href=\"$script?v=EnterNoFapWar\">набор участников</a> для войны.");
    }
    else{
        ViewInfoPage("В данный момент война не ведется.");
    }
}
$side_a = $data[$data['side_a']];
$side_b = $data[$data['side_b']];

if(isset($_SESSION['auth']) and $_SESSION['auth']) {
    $udata = Auth();
    $warrior = GetWarrior($udata['id']);
}

ViewHtmlTop('NoFap война', 'NoFapWar.css');
ViewHeader();

?>

<?php Resource('WarStatStyle.php'); ?>

  <div class="war-stat">
    <div class="war-stat__title">Статистика</div>
    <div class="war-stat-remain-wrapper">
      <div class="war-stat__remain war-stat__remain--army<?=$side_a['army_id']?>"><?=$side_a['fighting']?> воюют</div>
      <div class="war-stat__remain war-stat__remain--army<?=$side_b['army_id']?>"><?=$side_b['fighting']?> воюют</div>
    </div>
<?php if(isset($warrior) and $warrior and $warrior['status'] == 'fighting'): ?>
    <div class="war-report">
      <a href="<?=$script?>?c=WarriorStatus&s=fighting" class="war-report__button war-report__button--check-in">Отметиться</a>
      <a href="<?=$script?>?c=WarriorStatus&s=lose"  onclick="return confirm('Подтверждение срыва. Ты точно сорвался?')" class="war-report__button war-report__button--casualty">Сообщить о потере</a>
    </div>
<?php endif; ?>
    <div class="war-stat-table">
      <div class="war-stat-table__row war-stat-table__row--head">
        <div class="war-stat-table__item war-stat-table__item--corner"></div>
        <div class="war-stat-table__item war-stat-table__item--army<?=$side_a['army_id']?>"><?=$side_a['name']?></div>
        <div class="war-stat-table__item war-stat-table__item--army<?=$side_b['army_id']?>"><?=$side_b['name']?></div>
      </div>
      <div class="war-stat-table__row">
        <div class="war-stat-table__item war-stat-table__item--category">Старт</div>
        <div class="war-stat-table__item"><?=$side_a['at_start']?></div>
        <div class="war-stat-table__item"><?=$side_b['at_start']?></div>
      </div>
      <div class="war-stat-table__row">
        <div class="war-stat-table__item war-stat-table__item--category">Погиб&shy;ших</div>
        <div class="war-stat-table__item"><?=$side_a['lose']?></div>
        <div class="war-stat-table__item"><?=$side_b['lose']?></div>
      </div>
      <div class="war-stat-table__row">
        <div class="war-stat-table__item war-stat-table__item--category">Пропав&shy;ших</div>
        <div class="war-stat-table__item"><?=$side_a['lost']?></div>
        <div class="war-stat-table__item"><?=$side_b['lost']?></div>
      </div>
      <div class="war-stat-table__row">
        <div class="war-stat-table__item war-stat-table__item--category">Оста&shy;лось</div>
        <div class="war-stat-table__item"><?=$side_a['fighting']?></div>
        <div class="war-stat-table__item"><?=$side_b['fighting']?></div>
      </div>
      <div class="war-stat-table__row">
        <div class="war-stat-table__item war-stat-table__item--category">%</div>
        <div class="war-stat-table__item"><?=$side_a['perc']?></div>
        <div class="war-stat-table__item"><?=$side_b['perc']?></div>
      </div>
    </div>
  </div>
  <div class="faq faq__section">
      <h2 class="faq__title">Правила</h2>
      <ol class="faq__ol">
        <li>
          <p class="faq__text">Никакого порно, мастурбации и того, что называется edging. Секс, как занятие здоровое, разрешен.</p>
          <p class="faq__text">Наиболее распространенные формы edging:</p>
          <ul class="faq__ul">
            <li>
              <p class="faq__text">просмотр порно без мастурбации</p>
            </li>
            <li>
              <p class="faq__text">просмотр порно с мастурбацией, но без эякуляции</p>
            </li>
            <li>
              <p class="faq__text">мастурбация без порно и без эякуляции</p>
            </li>
          </ul>
          <p class="faq__text">Множество солдат нуждается в определении той линии, которую нельзя переступать. Для кого-то просмотр эротической сцены в фильме и при этом трогание себя является нормой в пределах правил, для кого-то это срыв. Солдат должен сам для себя решить,
            что является для него целью на этой войне и обозначить рамки в соответствии с существующими правилами. Это личная война.</p>
          <p class="faq__text">Основополагающий принцип таков: <strong>если ты умышленно возбуждаешь себя без партнера, то, по всей видимости, ты переступил черту.</strong></p>
        </li>
        <li>
          <p class="faq__text">Сообщай о срыве. Если срываешься, как можно скорее сообщи о потере. Такой поступок требует честности и мужества, но это война.</p>
        </li>
        <li>
          <p class="faq__text">Не провоцируй "противника". Война войной, но мы здесь не для того, чтобы вредить друг другу. Воюй с честью. Любой, замеченный в грязной игре выбывает.</p>
        </li>
      </ol>
    </div>
    <div class="faq faq__section">
      <h2 class="faq__title">Дополнение</h2>
      <p class="faq__text">Хоть секс, как здоровое занятие, разрешен, здесь есть подводный камень, известный как эффект преследователя (chaser effect). Суть его заключается в том, что после последнего испытанного оргазма в ближайшее время возникнет желание получения очередного.
        Не мудрено, что это лишь увеличивает риск сорваться из-за сексуального желания. Будь осторожнее.</p>
      <p class="faq__text">Если ты все же столкнулся с этим эффектом, знай, что рано или поздно он пройдет. Но сидеть на месте и ждать – не лучшая стратегия. Направь энергию в полезное русло.</p>
    </div>
  </div>

<!--<div class="link"></div>-->
</main>
</body>
</html>