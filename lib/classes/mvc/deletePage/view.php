<?php
require_once(dirname(dirname(__FILE__)).'/model.php');
require_once(dirname(dirname(__FILE__)).'/addPage/controller.php');
/***
 * Представление страницы "Удаление пользовательских страниц"
 */
 class vDelPage
 {
 	static function showConfirm($viewMode = 0, $pageType = 0)
	{
		$ba_config = new totalConfig();
		
		$ba_htmlTitle = 'Подтвердите удаление страницы';
		
		if($viewMode == 0)
			include_once $ba_config->appPath.'/part/head.php';
		else
			include_once $ba_config->appPath.'/control/part/head.php';
		
		include($ba_config->appPath.'deletePage/content.php');
		
		if($viewMode == 0)
			include_once $ba_config->appPath.'/part/footer.php';
		else
		{
			include_once $ba_config->appPath.'/control/part/footer/begin.php';
			if($pageType == 0)
			{
				$list = new cAddPage;
				$ba_rightMenu = $list->listPagesForEdit();
			}
			include_once $ba_config->appPath.'/control/part/footer/end.php';
		}
	}
	static function showError($viewMode = 0, $pageType = 0)
	{
		$ba_config = new totalConfig();
		
		$ba_htmlTitle = 'Ошибка!';
		
		if($viewMode == 0)
			include_once $ba_config->appPath.'/part/head.php';
		else
			include_once $ba_config->appPath.'/control/part/head.php';
		
		echo 'Неверный GET-запрос! Такой страницы не существует.';
		
		if($viewMode == 0)
			include_once $ba_config->appPath.'/part/footer.php';
		else
		{
			include_once $ba_config->appPath.'/control/part/footer/begin.php';
			if($pageType == 0)
			{
				$list = new cAddPage;
				$ba_rightMenu = $list->listPagesForEdit();
			}
			include_once $ba_config->appPath.'/control/part/footer/end.php';
		}
	}
	static function showResult($viewMode = 0, $pageType = 0)
	{
		$ba_config = new totalConfig();
		
		$ba_htmlTitle = 'Успешно!';
		
		if($viewMode == 0)
			include_once $ba_config->appPath.'/part/head.php';
		else
			include_once $ba_config->appPath.'/control/part/head.php';
		
		echo 'Страница успешно удалена!';
		
		if($viewMode == 0)
			include_once $ba_config->appPath.'/part/footer.php';
		else
		{
			include_once $ba_config->appPath.'/control/part/footer/begin.php';
			if($pageType == 0)
			{
				$list = new cAddPage;
				$ba_rightMenu = $list->listPagesForEdit();
			}
			include_once $ba_config->appPath.'/control/part/footer/end.php';
		}
	}
 }
?>
