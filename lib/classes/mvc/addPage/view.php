<?php
require_once('/../model.php');
/***
 * Представление страницы "создания страниц для пользователей"
 */
class vNewPage extends model
{
    function show() // 0 - создание, 1 - редактирование
    {
		$ba_config = new totalConfig();
		
		$ba_htmlTitle = 'Добавить страницу';
		
		include_once $ba_config->appPath.'/part/head.php';
		
		include_once $ba_config->appPath.'/addPage/content.php';
		
		include_once $ba_config->appPath.'/part/footer.php';        
    }
	
	function showEdit($data)
	{
		$ba_config = new totalConfig();
		$table = new table_pages();

		$ba_htmlTitle = 'Редактировать страницу';
		
		$title = $data[$table->title];
		$menuName = $data[$table->menuName];
		$keywords = $data[$table->kw];
		$descripton = $data[$table->desc];
		$content = $data[$table->content];
		$selectPos[$data[$table->pos]] = ' selected';
		$selectVis[$data[$table->visible]] = ' selected';
		
		include_once $ba_config->appPath.'/part/head.php';
		
		include_once $ba_config->appPath.'/editPage/content.php';
		
		include_once $ba_config->appPath.'/part/footer.php'; 
	}
	
	function showResult($mode = 0)
	{
		$ba_config = new totalConfig();

			$ba_htmlTitle = 'Выполнено.';
		
		include_once $ba_config->appPath.'/part/head.php';
		
		if($mode != 1)
			echo 'Страница успешно добавлена!';
		else
			echo 'Страница успешно отредактирована!';

		include_once $ba_config->appPath.'/part/footer.php';
	}
	
	function showError($msg, $mode = 0)
	{
		$ba_config = new totalConfig();
		if($mode != 1)
			$ba_htmlTitle = 'При создании страницы произошли ошибки';
		else
			$ba_htmlTitle = 'При редактировании страницы произошли ошибки';
		
		include_once $ba_config->appPath.'/part/head.php';
		
		echo 'Некорректные данные:<br /><br />';
		
		foreach($msg as $key => $error)
		{
			echo $error.'<br />';
		}

		include_once $ba_config->appPath.'/part/footer.php';
	}
}

?>