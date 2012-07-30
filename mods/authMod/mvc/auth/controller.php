<?php
require_once dirname(dirname(__FILE__)).'/model.php';
require_once dirname(dirname(dirname(__FILE__))).'/modConfig.php';
require_once dirname(dirname(dirname(__FILE__))).'/funct/passEncode.php';
require_once $ba_config->appPath.'lib/functions/safeFilterData.php';
require_once 'view.php';
/**
 * Контроллер авторизации
 */
class cAuth
{
	var $error;
	
	function run($userData = "")
	{
		$model = new modelAuthMod();
		$config = new authModConfig();
		if(empty($userData))
		{
			vAuth::show();
			exit();
		}
		
		$login = filterData($userData['loginOrMail'], $config->maxLenEmail);
		$password = passEncode(filterData($userData['password'], $config->maxLenPass));
		
		if(empty($login))
			$this->error[] = 'Не введён логин';
		if(empty($password))
			$this->error[] = 'Не введён пароль';
		
		// проверка в БД
		if($model->checkLoginAuth($login, $password) == false && $model->checkMailAuth($login, $password) == false)
		{
			if(!empty($login) && !empty($password))
				$this->error[] = 'Не верные данные';
		}
		
		if(!empty($this->error))
		{
			vAuth::showError($this->error);
			exit();
		}
		// TODO сделать добавление сессии
		echo 'Всё работает!';
		
	}
}
$cAuth = new cAuth();
?>