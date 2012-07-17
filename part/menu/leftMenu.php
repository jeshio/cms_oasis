<div class="blockMenu">
<a href="<?=$ba_config->path?>">Главная</a>
</div>
<?php
include_once('/../../lib/classes/mvc/menu/controller.php');
$ba_menuController->run();
?>