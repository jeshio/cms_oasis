<?php
/***
* Сюда добавляем ссылки для вывода их в админском меню
* Пример: <a href="<?=$ba_config->path?>control/mod">Модификации</a>
* $ba_config->path - это расположение CMS для ссылок
*/
?>

<?php $ba_menuController->run(1) // список меню ?>