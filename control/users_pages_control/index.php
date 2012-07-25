<?php
require_once(dirname(dirname(dirname(__FILE__)))."/config.php");
require_once($ba_config->appPath."/lib/classes/mvc/addPage/controller.php");
require_once($ba_config->appPath."/lib/classes/mvc/deletePage/controller.php");

empty($_GET['pageEdit']) ? $_GET['pageEdit'] = NULL : $_GET['pageEdit'];

if(empty($_GET['pageDelete']))
	$ba_AddPage->runEdit($_GET['pageEdit'], $_POST, 1);
else
	$ba_DelPage->run($_GET['pageDelete'], $_POST, 1);

?>
