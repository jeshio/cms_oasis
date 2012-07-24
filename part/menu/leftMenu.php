<?php
$ba_config = new totalConfig();
?>
<div class="blockMenu">
<a href="<?=$ba_config->path?>">Главная</a>
</div>
<?php
include_once($ba_config->appPath.'/lib/classes/mvc/menu/controller.php');
$ba_menuController->run();
?>
