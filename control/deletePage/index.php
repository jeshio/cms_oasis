<?php
require_once(dirname(dirname(dirname(__FILE__)))."/config.php");
require_once($ba_config->appPath."/lib/classes/mvc/deletePage/controller.php");

$ba_DelPage->run($_GET['page'], $_POST, 1, 1);
?>
