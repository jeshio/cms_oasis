<?php
require_once dirname(dirname(__FILE__)).'/config.php';
require_once $ba_config->appPath.'mods/authMod/mvc/permissions/controller.php';

$ba_htmlTitle = 'Регистрация';
$ba_htmlDesc = 'Регистрация нового пользователя.';
$ba_htmlKW = 'регистрация, пользователь, войти';

require_once $ba_config->appPath.'/part/head.php';

if(!$user->auth)
	require_once $ba_config->appPath.'/mods/authMod/registration.php';
else 
	echo 'Вы уже зарегистрированы и авторизованы';

require_once $ba_config->appPath.'/part/footer.php';

?>