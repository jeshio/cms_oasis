<?php require_once('/../config.php'); $ba_config = new totalConfig()?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?=$ba_htmlTitle ?></title>
    <meta name="Description" content="<?=$ba_htmlDesc ?>" />
    <meta name="Keywords" content="<?=$ba_htmlKW ?>" />
    <style type="text/css">
    <?php include '/../css/full.css'; ?>
    </style>
    <?=$ba_htmlHead // если будут дополнительные параметры ?>
</head>
<body>
<div id="full">

<!-- Шапка -->
<div class="topBlockLeft">
<div id="siteLogo">Oasis</div>
</div>
<div id="topMidBlock">Центральный блок</div>
<div class="topBlockRight"><div class="paddingContent">Верхний правый блок</div></div>
<div class="clear"></div> 
<!-- Конец Шапки -->
<div id="allColor">
<div class="patMenu">

<!-- левое меню начало -->
<div class="menuLeft">
<div class="paddingContent">
<?php include("menu/leftMenu.php") ?>
</div>
</div>
<!-- левое меню конец -->
<div class="menuUnder">
<div id="addPage">
<a href="<?=$ba_config->path.'addPage'?>">Добавить страницу</a>
</div>
<div class="normAd">Рекламный блок</div>
</div>
</div>

<!-- начало контента -->
<div id="content">
<?php if($ba_mode == 1) // админская панель
{?>
<!-- Начало админской панели -->
<div class="string">
<a href="<?=$ba_config->path.'editPage?pageEdit='.dirname($_SERVER['PHP_SELF'])?>">Редактировать</a>
<a href="<?=$ba_config->path.'deletePage?pageDel='.dirname($_SERVER['PHP_SELF'])?>">Удалить</a>
</div>
<!-- Конец админской панели -->
<?php } ?>
<div id="contentColor">
