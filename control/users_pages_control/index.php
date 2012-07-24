<?php
require_once(dirname(dirname(dirname(__FILE__)))."/config.php");
require_once($ba_config->appPath."/lib/classes/mvc/addPage/controller.php");

empty($_GET['pageEdit']) ? $_GET['pageEdit'] = NULL : $_GET['pageEdit'];

$ba_AddPage->runEdit($_GET['pageEdit'], $_POST, 1);

?>
