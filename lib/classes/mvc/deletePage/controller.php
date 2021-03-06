<?php
require_once(dirname(dirname(__FILE__)).'/model.php');
require_once('view.php');
require_once($ba_config->appPath.'lib/functions/checkURL.php');
require_once($ba_config->appPath.'lib/functions/createDirs.php');
require_once($ba_config->appPath.'lib/functions/removeDir.php');
require_once($ba_config->appPath.'lib/classes/mvc/menu/viewMenuList.php');
require_once($ba_config->appPath.'mods/authMod/mvc/permissions/controller.php');
/***
 * Контроллер вывода страницы "Удаление пользовательских страниц"
 */
 class cDelPage extends model
 {
 	function run($getUrl = "", $post = "", $viewMode = 0, $pageType = 0) // $viewMode - если не равен 0, то выводится редактирование страницы в админке
	{
		$usersPerms = new cUser();
		 
		if($pageType == 0 && !$usersPerms->deletePage)
			$usersPerms->forbidden();
		
		if($pageType != 0 && !$usersPerms->deleteControlPage)
			$usersPerms->forbidden();

		if($pageType == 0)
			$table = new table_pages();
		else
			$table = new table_controlPages();
		
		$config = new totalConfig();
		
		$urlDel = $this->repairURL(filterData($getUrl), 1);
		
		$arrayPath = checkURL($urlDel);
		
		if(preg_match($this->regURL, $urlDel) OR empty($urlDel) OR count($arrayPath) != 0)
		{
			vDelPage::showError($viewMode, $pageType);
			exit();
		}
		
		if(empty($post))
		{
			vDelPage::showConfirm($viewMode, $pageType);
			exit();
		}
		
		
		if(!empty($post['cancel']))
		{
			if($viewMode == 0 OR $pageType != 0)
				header("Location: ".$config->path.$urlDel);
			else
				header("Location: ".$config->path.'control/users_pages_control');
		}
		elseif(!empty($post['confirm']))
		{
			$positionMenu = mysql_fetch_assoc($this->getContent($urlDel, $table->pos, $pageType));
			
			$this->menuPos($table, $positionMenu[$table->pos], 'del');
			
			$this->query($this->deletePageForUrl($urlDel, $table));
			
			removeDir($config->appPath.$urlDel);
			
			vDelPage::showResult($viewMode, $pageType);
		}
	}
 }
 
 $ba_DelPage = new cDelPage();
?>
