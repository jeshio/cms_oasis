<?php
require_once(dirname(dirname(dirname(__FILE__))).'/lib/classes/mvc/menu/controller.php');
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
<?php $ba_menuController->runMenuList(1, 1, $selectPos) ?>
</select>
<br />
Содержимое:
<br />
<textarea name="formContent" style="width: 99%;" rows="25"><?=$content?></textarea>
<br />
<input type="submit" name="formSubmit" value="Сохранить изменения"/>
</form>
