<?php
require_once dirname(dirname(dirname(__FILE__))).'/lib/classes/mysql.php';
require_once($ba_config->appPath.'lib/functions/safeFilterData.php');

class tableUsers
{
	var $table = 'users';

	var $login = 'login';
	var $pass = 'password';
	var $group = 'group';
	var $email = 'email';
	var $rating = 'rating';
	var $regTime = 'time_registration';
	var $lastVisTime = 'time_last_visit';
	var $regIp = 'ip_registration';
	var $lastVisIp = 'ip_last_visit';
	var $regProxy = 'proxy_registration';
	var $lastVisProxy = 'proxy_last_visit';
	var $confEmail = 'confirm_email';

	function __construct()
	{
		$config = new totalConfig;
		$this->table = $config->prefix.$this->table;
	}

	function createTable()
	{
		$config = new totalConfig;
		return 'CREATE TABLE `'.$this->table.'`(`'.
				$config->id.'` MEDIUMINT NOT NULL AUTO_INCREMENT,`'.
				$this->login.'` CHAR(255) NOT NULL,`'.
				$this->pass.'` CHAR(255) NOT NULL,`'.
				$this->group.'` SMALLINT NOT NULL,`'.
				$this->email.'` CHAR(255) NOT NULL,`'.
				$this->rating.'` SMALLINT NOT NULL,`'.
				$this->regTime.'` TIMESTAMP NOT NULL,`'.
				$this->lastVisTime.'` TIMESTAMP NOT NULL,`'.
				$this->regIp.'` VARCHAR(19) NOT NULL,`'.
				$this->lastVisIp.'` VARCHAR(19) NOT NULL,`'.
				$this->regProxy.'` VARCHAR(19) NULL,`'.
				$this->lastVisProxy.'` VARCHAR(19) NULL,`'.
				$this->confEmail.'` TINYINT(1) NOT NULL,
						PRIMARY KEY(`'.$config->id.'`)
				)
				ENGINE = MYISAM COLLATE utf8_general_ci';
	}

	function addToTable($login, $pass, $group, $email, $regIp, $regProxy = '')
	{
		return 'INSERT INTO '.$this->table.
		'(`'.
		$this->login.'`, `'.
		$this->pass.'`, `'.
		$this->group.'`, `'.
		$this->email.'`, `'.
		$this->rating.'`, `'.
		$this->regTime.'`, `'.
		$this->lastVisTime.'`, `'.
		$this->regIp.'`, `'.
		$this->lastVisIp.'`, `'.
		$this->regProxy.'`, `'.
		$this->lastVisProxy.'`, `'.
		$this->confEmail.'`)
				VALUES ("'.
				$login.'","'.
				$pass.'","'.
				$group.'","'.
				$email.'",
				"0",
				NOW(),
				NOW(),"'.
				$regIp.'","'.
				$regIp.'","'.
				$regProxy.'","'.
				$regProxy.'",
				"0"
				)';
	}
}

?>
