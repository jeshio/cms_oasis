<?php
require_once dirname(dirname(__FILE__)).'/model.php';
require_once dirname(dirname(dirname(__FILE__))).'/modConfig.php';
require_once dirname(dirname(dirname(__FILE__))).'/funct/passEncode.php';
require_once $ba_config->appPath.'lib/functions/safeFilterData.php';
require_once 'view.php';

global $cookieChecking;
$cookieChecking = false;
/**
 * Контроллер авторизации
 */
class cAuth
{
	var $error;
	var $rem;
	var $username;
	
	function run($userData = "", $get = "")
	{
		$model = new modelAuthMod();
		$config = new authModConfig();
		$table = new tableUsers();
		
		
		$this->rem = filterData(@$userData['remember']);
		
		if(!empty($get['action']) && $get['action'] == 'exit')
		{
			setcookie('login', "",  0, "/");
			setcookie('pass', "",  0, "/");
			header('Location: http://'.$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']);
		}
		
		if($this->checkAuth()) // если уже авторизован
		{
			return 1;
		}
		
		if(empty($userData['loginOrMail']) && empty($userData['passwordAuth']) && empty($userData['auth']))
		{
			return 0;
		}
		
		$login = filterData($userData['loginOrMail'], $config->maxLenEmail);
		$password = passEncode(trim($userData['passwordAuth']));

		if(empty($login))
			$this->error[] = 'Не введён логин';
		if(empty($password))
			$this->error[] = 'Не введён пароль';
		
		$thisEmail = '';
		$thisLogin = '';
		if(preg_match($config->regEmail, $login))
			$thisEmail = $model->checkMailAuth($login, $password);
		else 
			$thisLogin = $model->checkLoginAuth($login, $password);
		
		
		// проверка в БД
		if($thisEmail == false && $thisLogin == false)
		{
			if(!empty($login) && !empty($password))
				$this->error[] = 'Не верные данные';
		}
		
		if(!empty($this->error))
		{
			return $this->error;
		}
		
		if($thisEmail) // если пользователь ввёл e-mail, в куки записать его логин
		{
			$login = mysql_fetch_assoc($model->getData($table->table, $table->login, '`'.$table->email.'`="'.$login.'"'));
			$login = $login[$table->login];
		}
		
		// TODO добавить возможность привязки к ip-адресу
		
		if(empty($this->rem))
		{
			setcookie('login', $login,  0, "/");
			setcookie('pass', $password, 0, "/");
		}
		else
		{
			setcookie('login', $login, time()+60*60*24*14, "/");
			setcookie('pass', $password, time()+60*60*24*14, "/");
		}
		
		header("Location: .");
	}
	/**
	 * Используется для вывод инофрмации об авторизации
	 * @param unknown_type $param
	 */
	function echoAuth($param = 0)
	{
		if($param == 0)
			vAuth::show();
		elseif($param == 1)
			vAuth::showProfile();
		else
			vAuth::showError($param);
	}
	/**
	 * Проверяет куки, возвращает true, если логин и пароль совпадают
	 * @return boolean
	 */
	function checkAuth()
	{
		$model = new modelAuthMod();
		
		if(!empty($_COOKIE))
		{
			$login = filterData(@$_COOKIE['login']);
			$pass = filterData(@$_COOKIE['pass']);
			
			if(!$GLOBALS['cookieChecking'] && !$model->checkLoginAuth($login, $pass))
			{
				setcookie('login', "",  0, "/");
				setcookie('pass', "",  0, "/");
				return false;
			}
			else
			{
				$this->username = $login;
				$GLOBALS['cookieChecking'] = true;
				return true;
			}
		}
	}
}
$cAuth = new cAuth();

?>