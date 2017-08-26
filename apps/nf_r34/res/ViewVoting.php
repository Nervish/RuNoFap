<?php

Model('GetVoting');
Model('GetEmail');

function ViewVoting($vote_id) {
    global $script;
    if(isset($_SESSION['auth']) and $_SESSION['auth']) {
        $udata = GetEmail($_SESSION['email']);
        $user_id = $udata['id'];
    }
    else{
        $user_id = "";
    }
    
    $voting = GetVoting($vote_id, $user_id);
    if(!$voting) {
        echo "<div class=\"wrapper\">Выбранного голосования не существует.</div>";
    }
    else{
        $vote_id = $voting['id'];
        echo "<div class=\"wrapper wrapper_column\">
<b>".nl2br($voting['name'])."</b><br />
".nl2br($voting['descript'])."
</div>\n\n";
        if($user_id) {
            echo "<form id=\"f\" method=\"POST\" action=\"$script?c=Voting&vs=$vote_id\"></form>\n";
        }
        echo "<div class=\"wrapper\">
  <div class=\"list-container size_480p\">
    <div class=\"list-container__row list-container__row_head\">
      <div class=\"list-container__element\">Голосование</div>
    </div>\n";
        $order = array();
        $keys = array();
        /*foreach($voting['votes'] as $key=>$value) {
            array_push($order, $key);
            $keys[$key] = true;
        }*/
        foreach($voting['chooses'] as $key=>$value) {
            if(!isset($result['votes'][$key])) {
                array_push($order, $key);
                //$keys[$key] = true;
            }
        }
        //var_dump($order);die;
        if($voting['mult']) {
            $cc = count($order);
            for($i = 0; $i < $cc; $i++) {
                $k = $order[$i];
                $value = $voting['chooses'][$k];
                $v = (isset($voting['votes'][$k])) ? $voting['votes'][$k] : 0;
                echo "    <div class=\"list-container__row\">\n";
                if($voting['active'] and $user_id) {
                    $c = (isset($voting['user_chooses'][$k])) ? 'checked ' : '';
                    $name = $k;
                    echo "      <div class=\"list-container__element size_60p\">
        <input class=\"list-container__input\" form=\"f\" type=\"checkbox\" name=\"v[$vote_id][$name]\" $c/>
      </div>\n";
                }
                echo "      <div class=\"list-container__element list-container__text size_240p\">
      ".$value['choose']."
      </div>
      <div class=\"list-container__element size_120p\">
        $v
      </div>
    </div>\n";
            }
        }
        else{
            $cc = count($order);
            for($i = 0; $i < $cc; $i++) {
                $k = $order[$i];
                $value = $voting['chooses'][$k];
                $v = (isset($voting['votes'][$k])) ? $voting['votes'][$k] : 0;
                echo "    <div class=\"list-container__row\">\n";
                if($voting['active'] and $user_id) {
                    $c = (isset($voting['user_chooses'][$k])) ? 'checked ' : '';
                    $name = $k;
                    echo "      <div class=\"list-container__element size_60p\">
        <input class=\"list-container__input\" form=\"f\" type=\"radio\" name=\"v[$vote_id]\" value=\"$name\" $c/>
      </div>\n";
                }
                echo "      <div class=\"list-container__element list-container__text size_240p\">
        ".$value['choose']."
      </div>
      <div class=\"list-container__element size_120p\">
        $v
      </div>
    </div>\n";
            }
            /*foreach($keys as $k) {
                $value = $voting['chooses'][$k];
                $v = (isset($voting['votes'][$value['id']])) ? $voting['votes'][$value['id']] : 0;
                if($voting['active'] and $user_id) {
                    $c = (isset($voting['user_chooses'][$value['id']])) ? 'checked ' : '';
                    $name = $value['id'];
                    echo "<input type=\"radio\" name=\"v[$vote_id]\" value=\"$name\" $c/>";
                }
                echo $value['choose']." (проголосовало: $v)<br /><br />\n";
            }*/
        }
        echo "    <div class=\"list-container__row\">
      <div class=\"list-container__element\">
        ";
        if($voting['active']) {
            if($user_id) {
                echo "<input class=\"list-container__input list-container__input_button\" form=\"f\" type=\"submit\" value=\"Голосовать\" />";
            }
            else{
                echo "<p>Для голосования необходимо войти.</p>";
            }
        }
        else{
            echo "<p>Голосование закрыто.</p>";
        }
        echo "
      </div>
    </div>
  </div>
</div>\n";
    }
}

?>
      