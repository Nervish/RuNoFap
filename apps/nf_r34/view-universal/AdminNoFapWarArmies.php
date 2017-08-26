<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('CheckAdminAccess');
Model('GetNoFapArmies');

CheckAdminAccess();

$data = GetNoFapArmies();
ViewHtmlTop("Армии", 'AdminNoFapWarArmies.css');
ViewHeader();

?>

<form id="f" method="POST" action="<?=$script?>?c=AdminEditArmies"></form>
<div class="wrapper">
  <div class="nf-war-armies">
    <div class="nf-war-armies__row">
      <div class="nf-war-armies__element nf-war-armies__element_delete nf-war-armies__element_delete_head">Удалить</div>
      <div class="nf-war-armies__element nf-war-armies__element_name nf-war-armies__element_name_head">Название</div>
      <div class="nf-war-armies__element nf-war-armies__element_color nf-war-armies__element_color_head">bg_color_active</div>
      <div class="nf-war-armies__element nf-war-armies__element_color nf-war-armies__element_color_head">bg_color_lose</div>
      <div class="nf-war-armies__element nf-war-armies__element_color nf-war-armies__element_color_head">font_color_active</div>
      <div class="nf-war-armies__element nf-war-armies__element_color nf-war-armies__element_color_head">font_color_lose</div>
      <div class="nf-war-armies__element nf-war-armies__element_update nf-war-armies__element_update_head">Обновить</div>
    </div>
<?php foreach($data as $army): ?>
    <div class="nf-war-armies__row">
      <div class="nf-war-armies__element nf-war-armies__element_delete">
        <input form="f" type="checkbox" name="d[<?=$army['id']?>]" />
      </div>
      <div class="nf-war-armies__element nf-war-armies__element_name">
        <input class="nf-war-armies__input" form="f" type="text" name="name[<?=$army['id']?>]" value="<?=addslashes($army['name'])?>" />
      </div>
      <div class="nf-war-armies__element nf-war-armies__element_color">
        <input class="nf-war-armies__input" form="f" type="text" name="bg_color_active[<?=$army['id']?>]" value="<?=addslashes($army['bg_color_active'])?>" />
      </div>
      <div class="nf-war-armies__element nf-war-armies__element_color">
        <input class="nf-war-armies__input" form="f" type="text" name="bg_color_lose[<?=$army['id']?>]" value="<?=addslashes($army['bg_color_lose'])?>" />
      </div>
      <div class="nf-war-armies__element nf-war-armies__element_color">
        <input class="nf-war-armies__input" form="f" type="text" name="font_color_active[<?=$army['id']?>]" value="<?=addslashes($army['font_color_active'])?>" />
      </div>
      <div class="nf-war-armies__element nf-war-armies__element_color">
        <input class="nf-war-armies__input" form="f" type="text" name="font_color_lose[<?=$army['id']?>]" value="<?=addslashes($army['font_color_lose'])?>" />
      </div>
      <div class="nf-war-armies__element nf-war-armies__element_update">
        <input form="f" type="checkbox" name="e[<?=$army['id']?>]" />
      </div>
    </div>
<?php endforeach; ?>
    <div class="nf-war-armies__row">
      <div class="nf-war-armies__element nf-war-armies__element_full">
        <input class="nf-war-armies__input" form="f" type="text" name="add" placeholder="Добавить элементов:" />
      </div>
    </div>
    <div class="nf-war-armies__row">
      <div class="nf-war-armies__element nf-war-armies__element_full">
        <input form="f" type="submit" value="Отправить" />
      </div>
    </div>
  </div>
</div>

</main>
</body>
</html><?php die; ?>


<?php foreach($data as $army): ?>
<tr>
    <td></td>
    <td></td>
    <td><textarea name="descript[<?=$army['id']?>]" rows="1" cols="75"><?=addslashes($army['descript'])?></textarea></td>
    <td><input type="text" name="color[<?=$army['id']?>]" value="<?=addslashes($army['color'])?>" /></td>
    <td><input type="checkbox" name="e[<?=$army['id']?>]" /></td>
</tr>
<?php endforeach; ?>
<tr><td colspan="5">Добавить записей: <input type="text" name="add" /></td></tr>
<tr><td colspan="5"><input type="submit" class="go" value="Отправить" /></td></tr>
</tbody>
</table>
</form>
</div>
</div>
</body>
</html>