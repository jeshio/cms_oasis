<?php
require_once(dirname(dirname(__FILE__)).'/model.php');
/***
 * Представление страницы "Удаление пользовательских страниц"
 */
 class vDelPage
 {
 	static function showConfirm()
	{
		$ba_config = new totalConfig();
		
		include($ba_config->appPath.'part/head.php');
		
		include($ba_config->appPath.'deletePage/content.php');
		
		include($ba_config->appPath.'part/footer.php');
	}
	static function showError()
	{
		$ba_config = new totalConfig();
		
		include($ba_config->appPath.'part/head.php');
		
		echo 'Неверный GET-запрос! Такой страницы не существует.';
		
		include($ba_config->appPath.'part/footer.php');
	}
	static function showResult()
	{
		$ba_config = new totalConfig();
		
		include($ba_config->appPath.'part/head.php');
		
		echo 'Страница успешно удалена!';
		
		include($ba_config->appPath.'part/footer.php');
	}
 }
?>
