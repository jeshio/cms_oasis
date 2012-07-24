<?php
require_once(dirname(dirname(__FILE__))."/config.php");
require_once($ba_config->appPath."/lib/classes/mvc/addPage/controller.php");

$ba_AddPage->run();

?>
