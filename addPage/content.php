<?php
require_once('../lib/classes/mvc/menu/controller.php');
?>
<form method="POST">
Title страницы:
<br />
<input type="text" name="formTitle"/>
<br />
Название в меню:
<br />
<input type="text" name="formMenuName"/>
<br />
Позиция в меню:
<br />
<select name="formMenuPos">
<option value="1">Первым в меню</option>
<?php $ba_menuController->runMenuList(0) ?>
</select>
<br />
URL:
<br />
http://<?=$_SERVER['SERVER_NAME'].$ba_config->path?>pages/ <input type="text" name="formURL"/>
<br />
Ключевые слова:
<br />
<input type="text" name="formKeyWords"/>
<br />
Описание:
<br />
<input type="text" name="formDescription"/>
<br />
Видимость для пользователей:
<br />
<select name="formVisible"/>
<option value="0">Не видим</option>
<option value="1">Видим</option>
</select>
<br />
Содержимое:
<br />
<textarea name="formContent" style="width: 99%;" rows="25"></textarea>
<br />
<input type="submit" name="formSubmit" value="Создать страницу"/>
</form>