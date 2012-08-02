<?php
require_once(dirname(dirname(__FILE__)).'/model.php');
require_once('view.php');
require_once($ba_config->appPath.'lib/functions/checkURL.php');
require_once($ba_config->appPath.'mods/authMod/mvc/permissions/controller.php');
/***
 * Контроллер вывода страницы "создания страниц"
 */
class cNewPage extends model
{
    var $error;
	var $result;
	var $regular = '/[^0-9a-zа-яАаБбВвГгДдЕеЁёЖжЗзИиЙйКкЛлМмНнОоПпРрСсТтУуФфХхЦцЧчШшЩщЪъЫыЬьЭэЮюЯя ]/i';// название меню рег
    var $regURL = '/[^0-9a-z\/_]/i'; // регулярка для URL
    
    function run()
    {
    	$usersPerms = new cUser();
    	
    	if(!$usersPerms->createControlPage)
    		$usersPerms->forbidden();
    	
		$table = new table_controlPages;
		$config = new totalConfig();
		$regular = '/[^0-9a-zа-яАаБбВвГгДдЕеЁёЖжЗзИиЙйКкЛлМмНнОоПпРрСсТтУуФфХхЦцЧчШшЩщЪъЫыЬьЭэЮюЯя ]/i'; // название меню рег
		$fileContent = 
		'<?php
		require_once("'.$config->appPath.'lib/classes/mvc/controlPages/controller.php");

		$ba_pagesController->run();

		?>'; // содержимое новых страниц
		
		if(empty($_POST)) // дефолтное состояние
		{	
			vNewPage::show();
			exit();
		}
		
		if(empty($_POST['formTitle']))
			$this->error[] .= "Поле с названием страницы не заполнено";
		if(empty($_POST['formMenuName']))
			$this->error[] .= "Поле с названием страницы в меню не заполнено";
		if(empty($_POST['formURL']))
			$this->error[] .= "Поле с URL страницы не заполнено";
		if(empty($_POST['formContent']))
			$this->error[] .= "Содержимое страницы не заполнено";
			
		if(preg_match($regular, $_POST['formMenuName']))
			$this->error[] .= "Название в меню может содержать только кириллицу или латиницу, цифры и пробелы";
		if(preg_match('/[^0-9a-z\/_]/i', $_POST['formURL']))
			$this->error[] .= "URL может содержать только латиницу, цифры и знак подчёркивания";
			
		$title = filterData($_POST['formTitle'], 255);
		$menuname = filterData($_POST['formMenuName'], 255);
		$url = filterData('control/pages/'.$_POST['formURL'], 255);
		$content = mysql_real_escape_string($_POST['formContent']);
		$menupos = filterData($_POST['formMenuPos'], 6);
			
			
		if(!$this->checkValue($menuname, $table->menuName, $table->table))
			$this->error[] .= "Такое название в меню уже есть. Введите другое";
			
		$arrayPath = checkURL($url,substr($config->appPath, 0, strlen($config->appPath) - 1));
		
		if(($countURL = count($arrayPath)) == 0) // 0 - значит ни одной папки создавать не нужно, тоесть такая уже есть
			$this->error[] .= "Такое URL занято. Введите другой";
		
		if($this->error)
		{
			vNewPage::showError($this->error);
			exit();
		}
		
		// создаём каждую папку по-отдельности, что позволяет сделать
		// многоуровневое создание
		foreach($arrayPath as $key => $path)
		{
			$this->createDir($path);
			if(($countURL - 1) == $key)
				$this->createURL($path, $fileContent);
		}

		if($this->menuPos($table, $menupos) AND $this->addControlPage($title, $menuname, $url, $content, $menupos))
			vNewPage::showResult($this->result);
	}
	
	function runEdit()
	{
		$usersPerms = new cUser();
		 
		if(!$usersPerms->editControlPage)
			$usersPerms->forbidden();
		$table = new table_controlPages;
		
		$urlEdit = $this->repairURL(filterData($_GET['pageEdit']), 1);
		
		$arrayPath = checkURL($urlEdit);
				
		if(preg_match($this->regURL, $urlEdit) OR empty($_GET['pageEdit']) OR count($arrayPath) != 0)
		{
			$this->error[] .= "Неверный GET-запрос. Такого URL не существует";
			vNewPage::showError($this->error, 1);
		}
		
		$dataEdit = $this->getControlContent($urlEdit);
		$dataEdit = mysql_fetch_assoc($dataEdit);
		if(empty($_POST))
		{
			vNewPage::showEdit($dataEdit);
			exit();
		}
				
		if(empty($_POST['formTitle']))
			$this->error[] .= "Поле с названием страницы не заполнено";
		if(empty($_POST['formMenuName']))
			$this->error[] .= "Поле с названием страницы в меню не заполнено";
		if(empty($_POST['formContent']))
			$this->error[] .= "Содержимое страницы не заполнено";
			
		if(preg_match($this->regular, $_POST['formMenuName']))
			$this->error[] .= "Название в меню может содержать только кириллицу или латиницу, цифры и пробелы";
			
		if($this->error)
		{
			vNewPage::showError($this->error);
			exit();
		}
			
		$title = filterData($_POST['formTitle'], 255);
		$menuname = filterData($_POST['formMenuName'], 255);
		$content = mysql_real_escape_string($_POST['formContent']);
		$menupos = filterData($_POST['formMenuPos'], 6);
		
		if($menupos > $dataEdit[$table->pos])
		{
			if($this->menuPos($table, $menupos, '+', $dataEdit[$table->pos]) AND
			$this->updateControlPage($title, $menuname, $content, $menupos, $urlEdit))
			{
				vNewPage::showResult(1);
			}		
		}
		elseif($menupos < $dataEdit[$table->pos])
		{
			if($this->menuPos($table, $menupos, '-', $dataEdit[$table->pos]) AND
			$this->updateControlPage($title, $menuname, $content, $menupos, $urlEdit))
			{
				vNewPage::showResult(1);
			}		
		}
		else
		{
			if($this->updateControlPage($title, $menuname, $content, $menupos, $urlEdit))
			{
				vNewPage::showResult(1);
			}		
		}
	}
}


$ba_NewControlPage = new cNewPage();
?>
