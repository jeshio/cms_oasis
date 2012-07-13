<?php
require_once('../lib/classes/mvc/menu/controller.php');
?>
<form method="POST">
Title страницы:
<br />
<input value="<?=$title?>" type="text" name="formTitle"/>
<br />
Название в меню:
<br />
<input value="<?=$menuName?>" type="text" name="formMenuName"/>
<br />
Позиция в меню:
<br />
<select name="formMenuPos">
<?php $ba_menuController->run(5, $selectPos) ?>
</select>
<br />
Ключевые слова:
<br />
<input value="<?=$keywords?>" type="text" name="formKeyWords"/>
<br />
Описание:
<br />
<input value="<?=$descripton?>" type="text" name="formDescription"/>
<br />
Видимость для пользователей:
<br />
<select name="formVisible"/>
<option<?=$selectVis[0]?> value="0">Не видим</option>
<option<?=$selectVis[1]?> value="1">Видим</option>
</select>
<br />
Содержимое:
<br />
<textarea name="formContent" style="width: 99%;" rows="25"><?=$content?></textarea>
<br />
<input type="submit" name="formSubmit" value="Сохранить изменения"/>
</form>