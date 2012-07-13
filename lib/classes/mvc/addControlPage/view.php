<?php
require_once('/../model.php');
/***
 * Представление страницы "создания страниц"
 */
class vNewPage extends model
{
    function show()
    {
		$ba_config = new totalConfig();
		
		$ba_htmlTitle = 'Добавить страницу в меню админа';
		
		include_once $ba_config->appPath.'control/part/head.php';
		
		include_once $ba_config->appPath.'control/addPage/content.php';

		include_once $ba_config->appPath.'control/part/footer.php';
        
        
    }
	
	function showResult($msg)
	{
		$ba_config = new totalConfig();
		$ba_htmlTitle = 'Удачное добавление страницы!';
		include_once $ba_config->appPath.'control/part/head.php';
		
		echo 'Страница успешно добавлена!';

		include_once $ba_config->appPath.'control/part/footer.php';
	}
	
	function showError($msg)
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