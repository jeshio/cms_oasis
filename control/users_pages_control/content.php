<?php
include_once('../../lib/classes/mvc/menu/controller.php');
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
<option value="1">После главной</option>
<?php $ba_menuController->runMenuList(1) ?>
</select>
<br />
URL:
<br />
http://<?=$_SERVER['SERVER_NAME'].$ba_config->path?>control/pages/ <input type="text" name="formURL"/>
<br />
Содержимое:
<br />
<textarea name="formContent" style="width: 99%;" rows="25"></textarea>
<br />
<input type="submit" name="formSubmit" value="Создать страницу"/>
</form>