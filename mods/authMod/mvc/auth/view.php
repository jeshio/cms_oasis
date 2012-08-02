<?php
/**
 * Представление авторизации
 */
class vAuth
{
	/**
	 * Показывает стандартную форму авторизации
	 */
	static function show()
	{
		include_once dirname(dirname(dirname(__FILE__))).'/html/authContent.html';
	}
	/**
	 * Выводит ошибки во время авторизации
	 * @param unknown_type $error
	 */
	static function showError($error)
	{
		vAuth::show();
		foreach ($error as $err)
		{
			echo $err;
			echo '<br />';
		}
	}
	/**
	 * Оповещает о чём-либо
	 */
	static function showNotice($notice)
	{
		echo $notice;
	}
	/**
	 * Выводит краткую информацию о профиле
	 */
	static function showProfile()
	{	
		$login = filterData($_COOKIE['login']);
		
		echo 'Авторизован - '.$login;
		echo '<br />';
		echo '<a href="http://'.$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'].'?action=exit">Выйти</a>';
	}
}
?>