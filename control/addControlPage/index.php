<?php
require_once(dirname(dirname(dirname(__FILE__)))."/config.php");
require_once($ba_config->appPath."/lib/classes/mvc/addControlPage/controller.php");

$ba_NewControlPage->run();

?>
