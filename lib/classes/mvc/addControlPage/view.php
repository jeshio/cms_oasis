<?php
require_once(dirname(dirname(__FILE__)).'/model.php');
/***
 * Представление страницы "создания страниц"
 */
class vNewPage extends model
{
    static function show()
    {
		$ba_config = new totalConfig();
		
		$ba_htmlTitle = 'Добавить страницу в меню админа';
		
		include_once $ba_config->appPath.'control/part/head.php';
		
		include_once $ba_config->appPath.'control/addControlPage/content.php';

		include_once $ba_config->appPath.'control/part/footer.php';
        
        
    }
	
	static function showResult($mode = 0)
	{
		$ba_config = new totalConfig();
		$ba_htmlTitle = 'Выполнено.';
		include_once $ba_config->appPath.'control/part/head.php';
		
		if($mode != 1)
			echo 'Страница успешно добавлена!';
		else
			echo 'Страница успешно отредактирована!';


		include_once $ba_config->appPath.'control/part/footer.php';
	}
	
	static function showEdit($data)
	{
		$ba_config = new totalConfig();
		$table = new table_controlPages();

		$ba_htmlTitle = 'Редактировать страницу';
		
		$title = $data[$table->title];
		$menuName = $data[$table->menuName];
		$content = $data[$table->content];
		$selectPos[$data[$table->pos]] = ' selected';
		
		include_once $ba_config->appPath.'/control/part/head.php';
		
		include_once $ba_config->appPath.'/control/editPage/content.php';
		
		include_once $ba_config->appPath.'/control/part/footer.php'; 
	}
	
	static function showError($msg)
	{
		$ba_config = new totalConfig();
		$ba_htmlTitle = 'При создании страницы произошли ошибки';
		
		include_once $ba_config->appPath.'control/part/head.php';
		
		echo 'Некорректные данные:<br /><br />';
		
		foreach($msg as $key => $error)
		{
			echo $error.'<br />';
		}

		include_once $ba_config->appPath.'control/part/footer.php';
	}
}

?>
