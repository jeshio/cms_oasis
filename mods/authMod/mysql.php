<?php
require_once dirname(dirname(dirname(__FILE__))).'/lib/classes/mysql.php';
$ba_config = new totalConfig();
require_once($ba_config->appPath.'lib/functions/safeFilterData.php');

/**
 * Таблица, содержащая данные всех зарегистрированных пользователей
 * @author Jeshio
 *
 */
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
	var $hash = 'hash_for_email';
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
				$this->login.'` VARCHAR(255) NOT NULL,`'.
				$this->pass.'` VARCHAR(255) NOT NULL,`'.
				$this->group.'` FLOAT(3) NOT NULL,`'.
				$this->email.'` VARCHAR(255) NOT NULL,`'.
				$this->rating.'` SMALLINT NOT NULL,`'.
				$this->regTime.'` TIMESTAMP NOT NULL,`'.
				$this->lastVisTime.'` TIMESTAMP NOT NULL,`'.
				$this->regIp.'` VARCHAR(19) NOT NULL,`'.
				$this->lastVisIp.'` VARCHAR(19) NOT NULL,`'.
				$this->regProxy.'` VARCHAR(19) NULL,`'.
				$this->lastVisProxy.'` VARCHAR(19) NULL,`'.
				$this->hash.'` VARCHAR(255) NULL,`'.
				$this->confEmail.'` TINYINT(1) NOT NULL,
						PRIMARY KEY(`'.$config->id.'`)
				)
				ENGINE = MYISAM COLLATE utf8_general_ci';
	}

	function addToTable($login, $pass, $group, $email, $regIp, $regProxy = '', $confEmail = 0, $hash = 'NULL')
	{
		$hash != 'NULL' ? $hash = '"'.$hash.'"' : $hash;
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
		$this->hash.'`, `'.
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
				$regProxy.'",'.
				$hash.',"'.
				$confEmail.'"
				)';
	}
}
/**
 * Таблица содержащая правовые группы пользователей
 */
class tableUserGroups
{
	var $table = 'user_groups';
	
	var $groupName = 'name'; // название группы
	var $priority = 'priority'; // приоритет
	var $permPages = 'perm_pages'; // права для страниц
	var $permControlPages = 'perm_control_pages'; // права для админских страниц
	var $permControl = 'perm_control'; // права на настройку cms
	var $permComment = 'perm_comment'; // права для комментариев
	
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
				$this->groupName.'` VARCHAR(255) NOT NULL,`'.
				$this->priority.'` FLOAT(3) NOT NULL,`'.
				$this->permPages.'` TINYINT(2) NOT NULL,`'.
				$this->permControlPages.'` TINYINT(2) NOT NULL,`'.
				$this->permControl.'` TINYINT(2) NOT NULL,`'.
				$this->permComment.'` TINYINT(2) NOT NULL,
				PRIMARY KEY(`'.$config->id.'`)
				)
				ENGINE = MYISAM COLLATE utf8_general_ci';
	}
	
	function addToTable($name, $priority, $permPages, $permControlPages, $permControl, $permComment)
	{
		return 'INSERT INTO '.$this->table.
		'(`'.
		$this->groupName.'`, `'.
		$this->priority.'`, `'.
		$this->permPages.'`, `'.
		$this->permControlPages.'`, `'.
		$this->permControl.'`, `'.
		$this->permComment.'`)
		VALUES ("'.
		$name.'","'.
		$priority.'","'.
		$permPages.'","'.
		$permControlPages.'","'.
		$permControl.'","'.
		$permComment.'"
		)';
	}
	
	function addDefaultGroups()
	{
		$mysql = new mysqlConnection();
		$mysql->query($this->addToTable('admin', 1, 21, 21, 21, 21)); // группа админов
		$mysql->query($this->addToTable('moder', 5, 10, 10, 0, 21)); // группа модераторов
		$mysql->query($this->addToTable('user', 15, 4, 0, 0, 9)); // группа пользователей, по-умолчанию для новых пользователей
		$mysql->query($this->addToTable('guest', 50, 4, 0, 0, 4)); // группа гостей
		$mysql->query($this->addToTable('banned', 90, 0, 0, 0, 0)); // группа забаненых
	}
}

/**
 * Таблица, содержащая права для отдельных пользователей
 */
class tableUserSpecPerms
{
	var $table = 'user_spec_perms';
	
	var $login = 'login'; // логин пользователя
	var $permPages = 'perm_pages'; // права для страниц
	var $permControlPages = 'perm_control_pages'; // права для админских страниц
	var $permControl = 'perm_control'; // права на настройку cms
	var $permComment = 'perm_comment'; // права для комментариев
	
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
				$this->login.'` VARCHAR(255) NOT NULL,`'.
				$this->permPages.'` TINYINT(2) NULL,`'.
				$this->permControlPages.'` TINYINT(2) NULL,`'.
				$this->permControl.'` TINYINT(2) NULL,`'.
				$this->permComment.'` TINYINT(2) NULL,
				PRIMARY KEY(`'.$config->id.'`)
				)
				ENGINE = MYISAM COLLATE utf8_general_ci';
	}
	
	function addToTable($login, $permPages, $permControlPages, $permControl, $permComment)
	{
		return 'INSERT INTO '.$this->table.
		'(`'.
		$this->login.'`, `'.
		$this->permPages.'`, `'.
		$this->permControlPages.'`, `'.
		$this->permControl.'`, `'.
		$this->permComment.'`)
		VALUES ("'.
		$login.'","'.
		$permPages.'","'.
		$permControlPages.'","'.
		$permControl.'","'.
		$permComment.'"
		)';
	}
}

?>
