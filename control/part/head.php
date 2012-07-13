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

<!-- левое меню начало -->
<div class="menuLeft">
<div class="paddingContent">
<?php include("menu/leftMenu.php") ?>
</div>
</div>
<!-- левое меню конец -->

<!-- Шапка -->
<div id="topMidBlock"><div class="paddingContent">
Центральный блок
</div></div>
<!-- Конец Шапки -->


<!-- начало контента -->
<div id="content"><div class="paddingContent" style="padding-bottom: 50px;">
