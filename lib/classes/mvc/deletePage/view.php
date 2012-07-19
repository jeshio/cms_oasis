<?php
require_once('/../model.php');
/***
 * Представление страницы "Удаление пользовательских страниц"
 */
 class vDelPage
 {
 	function showConfirm()
	{
		$ba_config = new totalConfig();
		
		include($ba_config->appPath.'part/head.php');
		
		include($ba_config->appPath.'deletePage/content.php');
		
		include($ba_config->appPath.'part/footer.php');
	}
	function showError()
	{
		$ba_config = new totalConfig();
		
		include($ba_config->appPath.'part/head.php');
		
		echo 'Неверный GET-запрос! Такой страницы не существует.';
		
		include($ba_config->appPath.'part/footer.php');
	}
	function showResult()
	{
		$ba_config = new totalConfig();
		
		include($ba_config->appPath.'part/head.php');
		
		echo 'Страница успешно удалена!';
		
		include($ba_config->appPath.'part/footer.php');
	}
 }
?>