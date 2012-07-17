<?php
require_once("/../config.php");
require_once($ba_config->appPath."/lib/classes/mvc/addPage/controller.php");

$ba_AddPage->runEdit($_GET['pageEdit'], $_POST);

?>