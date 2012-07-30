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
	static function showError($error)
	{
		foreach ($error as $err)
		{
			echo $err;
			echo '<br />';
		}
	}
}
?>