<?php
require_once 'mvc/auth/controller.php';
$cAuth = new cAuth();
$cAuth->run($_POST, $_GET);
?>