<?php
    require_once dirname(dirname(dirname(__FILE__))).'/config.php';
	$ba_config = new totalConfig;
	require_once $ba_config->appPath.'lib/classes/mvc/menu/controller.php';
	empty($ba_htmlHead) ? $ba_htmlHead = "" : $ba_htmlHead;
	empty($ba_htmlTitle) ? $ba_htmlTitle = "" : $ba_htmlTitle;
	empty($ba_mode) ? $ba_mode=0 : $ba_mode;
	require_once $ba_config->appPath.'/mods/authMod/mvc/permissions/controller.php';
	$user = new cUser;
	
	if(!$user->seeControlPage)
		$user->forbidden();
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?=$ba_htmlTitle?></title>

    <style type="text/css">
    <?php include dirname(dirname(__FILE__)).'/css/control.css'; ?>
    </style>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?=$ba_htmlHead // если будут дополнительные параметры ?>
</head>
<body>
<div id="full">

<div id="menu">
	
<!-- левое верхнее меню начало -->
<div class="menuLeft">
<div class="string">Администрирование</div>
<div class="paddingContent">
<?php include("menu/leftMenu.php") ?>
</div>
</div>
<!-- левое верхнее меню конец -->

<!-- левое нижнее меню начало -->
<div class="menuLeft">
<div class="string">Пользовательские страницы</div>
<div class="paddingContent">
<?php $ba_menuController->run(1) // список меню ?>
</div>
<a href="<?=$ba_config->path?>control/addControlPage">Добавить страницу</a><br/>
</div>
<!-- левое нижнее меню конец -->

</div>

<!-- Шапка -->
<div id="topMidBlock"><div class="paddingContent">
<a href="<?=$ba_config->path?>">На сайт</a>
</div></div>
<!-- Конец Шапки -->


<!-- начало контента -->
<div id="content">
<?php if($ba_mode == 1) // админская панель
{?>
<!-- Начало админской панели -->
<div class="string">
<a href="<?=$ba_config->path.'control/editPage?pageEdit='.dirname($_SERVER['PHP_SELF'])?>">Редактировать</a>
<a href="<?=$ba_config->path.'control/deletePage?page='.dirname($_SERVER['PHP_SELF'])?>">Удалить</a>
</div>
<!-- Конец админской панели -->
<?php } ?>
<div class="paddingContent" style="padding-bottom: 50px;">
