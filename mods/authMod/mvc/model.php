<?php
require_once dirname(dirname(__FILE__)).'/mysql.php';

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
		$q = 'SELECT `'.$table->login.'` FROM `'.$table->table.'` WHERE `'.$table->email.'`="'.$mail.'"'.
						'AND `'.$table->pass.'`="'.$password.'"';
		$rows = mysql_num_rows(mysqlConnection::query($q));
		if($rows == 1)
			return true;
		else
			return false;
	}
}
?>