<?php
require_once('/../model.php');
require_once('view.php');
require_once($ba_config->appPath.'lib/functions/checkURL.php');
require_once($ba_config->appPath.'lib/functions/createDirs.php');
require_once('../lib/classes/mvc/viewMenuList.php');
/***
 * Контроллер вывода страницы "создания страниц для пользователей"
 */
class cAddPage extends model
{
    var $error;
	var $result;
	var $regular = '/[^0-9a-zа-яАаБбВвГгДдЕеЁёЖжЗзИиЙйКкЛлМмНнОоПпРрСсТтУуФфХхЦцЧчШшЩщЪъЫыЬьЭэЮюЯя ]/i';// название меню рег
    var $regURL = '/[^0-9a-z\/_]/i'; // регулярка для URL
	
    function run()
    {
		$table = new table_pages;
		$config = new totalConfig();
		$fileContent = 
		'<?php
		require_once("'.$config->appPath.'lib/classes/mvc/pages/controller.php");

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
		if(empty($_POST['formKeyWords']))
			$this->error[] .= "Поле с ключевыми словами не заполнено";
		if(empty($_POST['formDescription']))
			$this->error[] .= "Поле с описанием не заполнено";
		if(empty($_POST['formContent']))
			$this->error[] .= "Содержимое страницы не заполнено";
			
		if(preg_match($this->regular, $_POST['formMenuName']))
			$this->error[] .= "Название в меню может содержать только кириллицу или латиницу, цифры и пробелы";
		if(preg_match($this->regURL, $_POST['formURL']))
			$this->error[] .= "URL может содержать только латиницу, цифры, знак подчёркивания и слэш";
			
		$title = filterData($_POST['formTitle'], 255);
		$menuname = filterData($_POST['formMenuName'], 255);
		$url = filterData('pages/'.$this->repairURL($_POST['formURL']), 255);
		$keyWords = filterData($_POST['formKeyWords'], 255);
		$description = filterData($_POST['formDescription'], 255);
		$content = mysql_real_escape_string($_POST['formContent']);
		$menupos = filterData($_POST['formMenuPos'], 6);
		$visible = filterData($_POST['formVisible'], 1);
			
			
		if(!$this->checkValue($menuname, $table->menuName, $table->table))
			$this->error[] .= "Такое название в меню уже есть. Введите другое";
			
		$arrayPath = checkURL($url,substr($config->appPath, 0, strlen($config->appPath) - 1));
		
		if(count($arrayPath) == 0) // 0 - значит ни одной папки создавать не нужно, тоесть такая уже есть
			$this->error[] .= "Такое URL занято. Введите другой";
		
		if($this->error)
		{
			vNewPage::showError($this->error);
			exit();
		}
		

		if($this->menuPos($table, $menupos)
		AND
		$this->addPage($title, $menuname, $url, $keyWords, $description, $content, $menupos, $visible))
		{
			createDirs($arrayPath); // создаём папки
			
			$this->createURL($arrayPath[count($arrayPath) - 1], $fileContent); // создаём файл index.php
			
			vNewPage::showResult();
		}
	}
	
	function runEdit()
	{
		$table = new table_pages;
		
		$urlEdit = $this->repairURL(filterData($_GET['pageEdit']), 1);
		
		$arrayPath = checkURL($urlEdit);
				
		if(preg_match($this->regURL, $urlEdit) OR empty($_GET['pageEdit']) OR count($arrayPath) != 0)
		{
			$this->error[] .= "Неверный GET-запрос. Такого URL не существует";
			vNewPage::showError($this->error, 1);
		}
		
		$dataEdit = $this->getContent($urlEdit);
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
		if(empty($_POST['formKeyWords']))
			$this->error[] .= "Поле с ключевыми словами не заполнено";
		if(empty($_POST['formDescription']))
			$this->error[] .= "Поле с описанием не заполнено";
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
		$keyWords = filterData($_POST['formKeyWords'], 255);
		$description = filterData($_POST['formDescription'], 255);
		$content = mysql_real_escape_string($_POST['formContent']);
		$menupos = filterData($_POST['formMenuPos'], 6);
		$visible = filterData($_POST['formVisible'], 1);
		
		if($menupos > $dataEdit[$table->pos])
		{
			if($this->menuPos($table, $menupos, '+', $dataEdit[$table->pos]) AND
			$this->updatePage($title, $menuname, $keyWords, $description, $content, $menupos, $visible, $urlEdit))
			{
				vNewPage::showResult(1);
			}		
		}
		elseif($menupos < $dataEdit[$table->pos])
		{
			if($this->menuPos($table, $menupos, '-', $dataEdit[$table->pos]) AND
			$this->updatePage($title, $menuname, $keyWords, $description, $content, $menupos, $visible, $urlEdit))
			{
				vNewPage::showResult(1);
			}		
		}
		else
		{
			if($this->updatePage($title, $menuname, $keyWords, $description, $content, $menupos, $visible, $urlEdit))
			{
				vNewPage::showResult(1);
			}		
		}
	}
		
}


$ba_AddPage = new cAddPage();
?>