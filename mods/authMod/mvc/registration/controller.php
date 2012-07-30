<?php
require_once dirname(dirname(__FILE__)).'/model.php';
require_once dirname(dirname(dirname(__FILE__))).'/modConfig.php';
require_once dirname(dirname(dirname(__FILE__))).'/funct/passEncode.php';
require_once $ba_config->appPath.'lib/functions/safeFilterData.php';
require_once 'view.php';

/**
 * Контроллер регистрации новых пользователей
 */
class cRegistration
{
	var $error;

	/**
	 * Запуск регистрации нового пользователя
	 * @param unknown_type $userData
	 */
	function runReg($userData = "")
	{
		$modConfig = new authModConfig();
		$mysql = new modelAuthMod();
		$table = new tableUsers();

		if (empty($userData))
		{
			vRegistration::show();
			exit();
		}

		// Фильтрация данных

		$login = filterData($userData['login']);
		$password = passEncode(filterData($userData['password']));
		$confPassword = filterData($userData['confPassword']);
		$email = filterData($userData['email']);

		// Ошибки с ключом 0, означают незаполненые поля
		
		$this->error[0] = "";
		if(empty($login))
			$this->error[0][] .= 'Логин';
		if(empty($password))
			$this->error[0][] .= 'Пароль';
		if(empty($confPassword))
			$this->error[0][] .= 'Подтверждение пароля';
		if(empty($email))
			$this->error[0][] .= 'E-mail';

		// Проверка на правильность ввода
		
		$this->error[1] = "";
		if(!preg_match($modConfig->regLogin, $login) && !empty($login))
			$this->error[1][] .= 'Логин может содержать только латиницу, кириллицу, цифры и знак _';

		if(!preg_match($modConfig->regEmail, $email) && !empty($email))
			$this->error[1][] .= 'E-mail должен быть такого вида: example@host.com';

		// Проверка на введённое количество символов
		
		$loginLen = strlen($login);
		$passLen = strlen($password);
		$emailLen = strlen($email);

		if(($loginLen < $modConfig->minLenLogin || $loginLen > $modConfig->maxLenLogin) && !empty($login))
			$this->error[1][] .= 'Поле логина может содержать от ' . $modConfig->minLenLogin . ' до ' . $modConfig->maxLenLogin . ' символов';

		if(($passLen < $modConfig->minLenPass || $passLen > $modConfig->maxLenPass) && !empty($password))
			$this->error[1][] .= 'Поле пароля может содержать от ' . $modConfig->minLenPass . ' до ' . $modConfig->maxLenPass . ' символов';
		
		if(($emailLen < $modConfig->minLenEmail || $emailLen > $modConfig->maxLenEmail) && !empty($email))
			$this->error[1][] .= 'Поле E-mail может содержать от ' . $modConfig->minLenEmail . ' до ' . $modConfig->maxLenEmail . ' символов';
		
		// Проверка на совпадение паролей
		
		if($password != $confPassword && !empty($password) && !empty($confPassword))
			$this->error[1][] = 'Пароли не совпадают';
		
		// Проверка существования E-mail и логина в БД
		
		if(!empty($login) && $mysql->dataExist($table->table, $table->login, $login))
			$this->error[1][] = 'Логин <b>'.$login.'</b> уже занят';
		
		if(!empty($email) && $mysql->dataExist($table->table, $table->email, $email))
			$this->error[1][] = 'Аккаунт с такой электронной почтой <b>'.$email.'</b> - уже существует';
		
		// Если есть хоть одна ошибка, передаём её на представление ошибок, и вырубаем продолжение скрипта
		
		if (!empty($this->error[0]) || !empty($this->error[1]))
		{
			vRegistration::showErr($this->error);
			exit();
		}
		
		// теперь, когда нет ошибок, можно вносить данные
		
		// FIXME исправить $_SERVER, чтобы отправлял ip-Адрес и добавить прокси
		// TODO вставить запрос
		echo $table->addToTable($login, $password, 5, $email, $_SERVER['USER_AGENT']);
		
		vRegistration::showResult();
	}
}

$cReg = new cRegistration();
?>