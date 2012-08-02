<?php
require_once dirname(dirname(__FILE__)).'/mysql.php';
require_once dirname(dirname(__FILE__)).'/modConfig.php';

/**
 * Модель модуля авторизации и регистрации новых пользоваетлей
 */

class modelAuthMod extends mysqlConnection
{
	/**
	 * Проверяет существование данных в таблице $table,
	 * колонке $col, данные $data
	 * @param unknown_type $table
	 * @param unknown_type $col
	 * @param unknown_type $data
	 * @return boolean
	 */
	function dataExist($table, $col, $data)
	{
		$q = 'SELECT `'.$col.'` FROM `'.$table.'` WHERE `'.$col.'`="'.$data.'"';
		$rows = mysql_num_rows(mysqlConnection::query($q));
		if($rows == 0)
			return false;
		else 
			return true;
	}
	/**
	 * Проверяет логин с паролем
	 * и если найдено совпадение, возвращает true
	 * @param unknown_type $login
	 * @param unknown_type $password
	 * @return boolean
	 */
	function checkLoginAuth($login, $password)
	{
		$table = new tableUsers();
		$config = new authModConfig();
		
		if($config->emailConfirm) // если включено подтверждение электронной почты
			$q = 'SELECT `'.$table->login.'` FROM `'.$table->table.'` WHERE `'.$table->login.'`="'.$login.'"'.
				'AND `'.$table->pass.'`="'.$password.'" AND `'.$table->confEmail.'`="1"';
		else
			$q = 'SELECT `'.$table->login.'` FROM `'.$table->table.'` WHERE `'.$table->login.'`="'.$login.'"'.
				'AND `'.$table->pass.'`="'.$password.'"';
		
		$rows = mysql_num_rows(mysqlConnection::query($q));
		if($rows == 1)
			return true;
		else
			return false;
	}
	/**
	 * Проверяет почту с паролем
	 * и если найдено совпадение, возвращает true
	 * @param unknown_type $mail
	 * @param unknown_type $password
	 * @return boolean
	 */
	function checkMailAuth($mail, $password)
	{
		$table = new tableUsers();
		$config = new authModConfig();
		
		if($config->emailConfirm) // если включено подтверждение электронной почты
			$q = 'SELECT `'.$table->login.'` FROM `'.$table->table.'` WHERE `'.$table->email.'`="'.$mail.'"'.
					'AND `'.$table->pass.'`="'.$password.'" AND `'.$table->confEmail.'`="1"';
		else
			$q = 'SELECT `'.$table->login.'` FROM `'.$table->table.'` WHERE `'.$table->email.'`="'.$mail.'"'.
						'AND `'.$table->pass.'`="'.$password.'"';
		
		$rows = mysql_num_rows(mysqlConnection::query($q));
		if($rows == 1)
			return true;
		else
			return false;
	}
	/**
	 * Метод для подтверждения e-mail'а
	 * @param unknown_type $hash
	 * @param unknown_type $login
	 */
	function checkHashForEmail($hash, $login)
	{
		$table = new tableUsers();
		$q = 'UPDATE `'.$table->table.'` SET `'.$table->confEmail.'`="1" WHERE `'.$table->hash.'`="'.$hash.'" AND `'.$table->login.'`="'.$login.'" AND `'.$table->confEmail.'`="0"';
		$this->query($q);
		if(mysql_affected_rows() != 0)
			return true;
		else 
			return false;
	}
	/**
	 * Возвращает данные из таблицы групп для названия группы или по приоритету
	 * в аргументе
	 */
	function getGroup($group)
	{
		$table = new tableUserGroups();
		
		if(is_float($group) || is_int($group))
			$q = 'SELECT * FROM `'.$table->table.'` WHERE `'.$table->priority.'`="'.$group.'"';
		else
			$q = 'SELECT * FROM `'.$table->table.'` WHERE `'.$table->groupName.'`="'.$group.'"';
		
		return $this->query($q);
	}
	/**
	 * Возвращает запрос данных из колонки с условием
	 * @param unknown_type $table
	 * @param unknown_type $col
	 * @param unknown_type $condition
	 */
	function getData($table, $col, $condition)
	{
		$q = 'SELECT `'.$col.'` FROM `'.$table.'` WHERE '.$condition;
		return $this->query($q);
	}
}
?>