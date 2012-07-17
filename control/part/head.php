<?php
    require_once '/../../config.php';
	$ba_config = new totalConfig;
	require_once $ba_config->appPath.'lib/classes/mvc/menu/controller.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo $ba_htmlTitle ?></title>

    <style type="text/css">
    <?php include '/../css/control.css'; ?>
    </style>
    <?php echo $ba_htmlHead // если будут дополнительные параметры ?>
</head>
<body>
<div id="full">

<div id="menu">
<!-- левое верхнее меню начало -->
<div class="menuLeft">
<div class="string">Пользовательские страницы</div>
<div class="paddingContent">
<?php $ba_menuController->run(1) // список меню ?>
</div>
<a href="<?=$ba_config->path?>control/addPage">Добавить страницу</a><br/>
</div>
<!-- левое верхнее меню конец -->

<!-- левое нижнее меню начало -->
<div class="menuLeft">
<div class="string">Администрирование</div>
<div class="paddingContent">
<?php include("menu/leftMenu.php") ?>
</div>
</div>
<!-- левое нижнее меню конец -->
</div>

<!-- Шапка -->
<div id="topMidBlock"><div class="paddingContent">
Центральный блок
</div></div>
<!-- Конец Шапки -->


<!-- начало контента -->
<div id="content">
<?php if($ba_mode == 1) // админская панель
{?>
<!-- Начало админской панели -->
<div class="string">
<a href="<?=$ba_config->path.'control/editPage?pageEdit='.dirname($_SERVER['PHP_SELF'])?>">Редактировать</a>
</div>
<!-- Конец админской панели -->
<?php } ?>
<div class="paddingContent" style="padding-bottom: 50px;">
