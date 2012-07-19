<?php
require_once('/../model.php');
/***
 * Представление страницы "создания страниц для пользователей"
 */
class vNewPage extends model
{
    function show()
    {
		$ba_config = new totalConfig();
		
		$ba_htmlTitle = 'Добавить страницу';
		
		include_once $ba_config->appPath.'/part/head.php';
		
		include_once $ba_config->appPath.'/addPage/content.php';
		
		include_once $ba_config->appPath.'/part/footer.php';        
    }
	
	function showEdit($data, $viewMode = 0)
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
		
		if($viewMode == 0)
			include_once $ba_config->appPath.'/part/head.php';
		else
			include_once $ba_config->appPath.'/control/part/head.php';
		
		include_once $ba_config->appPath.'/editPage/content.php';
		
		if($viewMode == 0)
			include_once $ba_config->appPath.'/part/footer.php';
		else
		{
			include_once $ba_config->appPath.'/control/part/footer/begin.php';
			$list = new cAddPage;
			$ba_rightMenu = $list->listPagesForEdit();
			include_once $ba_config->appPath.'/control/part/footer/end.php';
		}
	}
	
	function showResult($mode = 0, $viewMode = 0)
	{
		$ba_config = new totalConfig();

		$ba_htmlTitle = 'Выполнено.';
		
		if($viewMode == 0)
			include_once $ba_config->appPath.'/part/head.php';
		else
			include_once $ba_config->appPath.'/control/part/head.php';
		
		if($mode != 1)
			echo 'Страница успешно добавлена!';
		else
			echo 'Страница успешно отредактирована!';

		if($viewMode == 0)
			include_once $ba_config->appPath.'/part/footer.php';
		else
		{
			include_once $ba_config->appPath.'/control/part/footer/begin.php';
			$list = new cAddPage;
			$ba_rightMenu = $list->listPagesForEdit();
			include_once $ba_config->appPath.'/control/part/footer/end.php';
		}
	}
	
	function showError($msg, $mode = 0, $viewMode = 0)
	{
		$ba_config = new totalConfig();
		if($mode != 1)
			$ba_htmlTitle = 'При создании страницы произошли ошибки';
		else
			$ba_htmlTitle = 'При редактировании страницы произошли ошибки';
		
		if($viewMode == 0)
			include_once $ba_config->appPath.'/part/head.php';
		else
			include_once $ba_config->appPath.'/control/part/head.php';
		
		echo 'Некорректные данные:<br /><br />';
		
		foreach($msg as $key => $error)
		{
			echo $error.'<br />';
		}

		if($viewMode == 0)
			include_once $ba_config->appPath.'/part/footer.php';
		else
		{
			include_once $ba_config->appPath.'/control/part/footer/begin.php';
			$list = new cAddPage;
			$ba_rightMenu = $list->listPagesForEdit();
			include_once $ba_config->appPath.'/control/part/footer/end.php';
		}
	}
	function showDefaultEdit()
	{
		$ba_config = new totalConfig();
		
		$ba_htmlTitle = 'Редактирование страниц';
		
		include_once $ba_config->appPath.'/control/part/head.php';
		
		echo 'Выберите страницу, которую хотите редактировать:<br/><br/>';
		$list = new cAddPage;
		$ba_rightMenu = $list->listPagesForEdit();

		include_once $ba_config->appPath.'/control/part/footer/begin.php';
		
		include_once $ba_config->appPath.'/control/part/footer/end.php';
	}
	function showListPagesEdit($pages)
	{
		$ba_config = new totalConfig();
	
		foreach($pages as $url => $name)
		{
			echo '<div class="blockRight">';
			
			if(!empty($name[1]))
				echo '<b>'.$name[1].'</b>'; // видимая страница
			else
				echo '<font color="red"><b>'.$name[0].'</b></font>'; // невидимая страница
			
			echo '<br />';
			echo '<a href="'.$ba_config->path.'control/users_pages_control?pageEdit='.$url.'">Редактировать</a>';
			echo '</div>';
			echo "\n\n";
		}
	}
}

?>