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
	 * $modeAdmin = 1 - закидывает нового пользователя в группу админов (для регистрации админа)
	 * @param unknown_type $userData
	 */
	function runReg($userData = "", $get = "", $modeAdmin = 0)
	{
		$modConfig = new authModConfig();
		$mysql = new modelAuthMod();
		$table = new tableUsers();
		$emailFrom = $_SERVER['SERVER_NAME']; // поле From в отсылаемом письме для подтверждения

		if (empty($userData['login']) && empty($userData['password']) && empty($userData['confPassword']) && empty($userData['email']) && empty($userData['regi']))
		{
			if(!empty($get)) // подтверждение e-mail'а
			{
				$login = filterData($get['login'], $modConfig->maxLenLogin);
				$hash = filterData($get['hash'], 255);
				if ($mysql->checkHashForEmail($hash, $login))
				{
					$result[1][] = 'E-mail успешно подтверждён! Теперь можете войти.';
					vRegistration::showErr($result, false);
				}
				else 
				{
					$result[1][] = 'Неверная ссылка. Возможно e-mail уже подтверждён.';
					vRegistration::showErr($result, false);
				}
				return 0;
			}
			vRegistration::show();
			return 0;
		}

		// Фильтрация данных

		$login = filterData($userData['login']);
		$password = trim($userData['password']);
		$confPassword = trim($userData['confPassword']);
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
			$this->error[1][] .= 'Логин может содержать только <b>латиницу</b>, <b>кириллицу</b>, <b>цифры</b> и знак <b>_</b>
		и должен <b>начинаться буквой</b>, а <b>кончаться буквой или цифрой</b>';

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
		
		// Пробуем послать сообщение на почту, если включено подтверждение по почте
		
		if($modConfig->emailConfirm && $modeAdmin == 0)
		{
			$headers  = "Content-type: text/html; charset=utf-8 \r\n";
			$headers .= 'From: '.$_SERVER['SERVER_NAME'];
			$hash     = filterData(md5(rand(99, 9999).time()), 255);
			$subject  = 'Подтвержение регистрации - '.$login.' на сайте '.$_SERVER['SERVER_NAME'];
			//здесь вам нужно поменять значение yousite на свой домен
			$message  = '<p>Этот E-mail был использован при регистрации на сайте '.$_SERVER['SERVER_NAME'].'</p>'.
					'<p>Подтвердите регистрацию по предложенной ссылке:</p>'.
					'<p><a href="http://'.$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'].'?hash='.$hash.'&login='.$login.'">'.
					$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'].'?hash='.$hash.'&login='.$login.'</a></p>'.
					'</p>'.
					'<p>Если вы не регистрировались на этом сайте, пожалйуста удалите письмо.</p>'.
					'<p>Письмо отправлено автоматически. Просим вас на него не отвечать.</p>';
			
			//отправляем письмо
			if(!mail($email, $subject, $message, $headers))
			{
				$this->error[1][] = 'На этот e-mail <b>'.$email.'</b> невозможно отправить письмо с подтверждением. Введите рабочий e-mail.';
			}
		}
		
		// Если есть хоть одна ошибка, передаём её на представление ошибок, и вырубаем продолжение скрипта
		
		if (!empty($this->error[0]) || !empty($this->error[1]))
		{
			vRegistration::showErr($this->error);
			return 0;
		}
		
		// теперь, когда нет ошибок, можно вносить данные
		
		$userIP = filterData($_SERVER['REMOTE_ADDR'], 15) ;
		$userProxy = filterData(getenv("HTTP_X_FORWARDED_FOR"), 15);
		
		$password = passEncode($password);
				
		if($modConfig->emailConfirm && $modeAdmin == 0)
			$mysql->query($table->addToTable($login, $password, 15, $email, $userIP, $userProxy, 0, $hash));
		else if($modeAdmin == 0)
			$mysql->query($table->addToTable($login, $password, 15, $email, $userIP, $userProxy, 1));
		else if($modeAdmin == 1)
			$mysql->query($table->addToTable($login, $password, 1, $email, $userIP, $userProxy, 1));
		
		vRegistration::showResult($modeAdmin);
		return 0;
	}
}

$cReg = new cRegistration();
?>