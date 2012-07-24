<?php
require_once(dirname(dirname(__FILE__)).'/model.php');
require_once('view.php');
require_once($ba_config->appPath.'lib/functions/checkURL.php');
require_once($ba_config->appPath.'lib/functions/createDirs.php');
require_once($ba_config->appPath.'lib/functions/removeDir.php');
require_once($ba_config->appPath.'lib/classes/mvc/menu/viewMenuList.php');
/***
 * Контроллер вывода страницы "Удаление пользовательских страниц"
 */
 class cDelPage extends model
 {
 	function run($getUrl = "", $post = "")
	{
		$table = new table_pages();
		
		$config = new totalConfig();
		
		$urlDel = $this->repairURL(filterData($getUrl), 1);
		
		$arrayPath = checkURL($urlDel);
		
		if(preg_match($this->regURL, $urlDel) OR empty($urlDel) OR count($arrayPath) != 0)
		{
			vDelPage::showError();
			exit();
		}
		
		if(empty($post))
		{
			vDelPage::showConfirm();
			exit();
		}
		
		
		if(!empty($post['cancel']))
		{
			header("Location: ".$config->path.$urlDel);
			echo $config->appPath.$urlDel;
		}
		elseif(!empty($post['confirm']))
		{
			$positionMenu = mysql_fetch_assoc($this->getContent($urlDel, $table->pos));
			
			$this->menuPos($table, $positionMenu[$table->pos], 'del');
			
			$this->query($this->deletePageForUrl($urlDel));
			
			removeDir($config->appPath.$urlDel);
			
			vDelPage::showResult();
		}
	}
 }
 
 $ba_DelPage = new cDelPage();
?>
