<?php
require_once dirname(dirname(__FILE__)).'/auth/controller.php';
require_once dirname(dirname(__FILE__)).'/model.php';
require_once 'view.php';
/**
 * Контроллер, содержащий права пользователя и его данные
 */
class cUser
{
	var $login;
	var $group;
	var $auth;
	
	## права
	# обычные страницы
	var $seePage = false; // смотреть страницы
	var $editPage = false; // редактировать страницы
	var $createPage = false; // создавать страницы
	var $deletePage = false; // удалять страницы
	
	# админские страницы
	var $seeControlPage = false; // смотреть админские страницы
	var $editControlPage = false; // редактировать админские страницы
	var $createControlPage = false; // создавать админские страницы
	var $deleteControlPage = false; // удалять админские страницы
	
	# управление CMS
	var $control = false; // управление системой
	
	# комментарии
	var $seeComments = false; // смотреть комментарии
	var $editComments = false; // редактировать свои комментарии
	var $createComments = false; // создавать комментарии
	var $deleteComments = false; // удалять свои комментарии
	var $editAnotherComments = false; // редактировать чужие комментарии
	var $deleteAnotherComments = false; // удалять чужие комментарии
	
	function __construct()
	{
		$auth = new cAuth();
		$tableUsers = new tableUsers();
		$tableGroups = new tableUserGroups();
		$model = new modelAuthMod();
		
		if($auth->checkAuth())
		{
			$this->login = $auth->username;
			$data = mysql_fetch_assoc($model->getData($tableUsers->table, $tableUsers->group, '`'.$tableUsers->login.'`="'.$this->login.'"'));
			$this->group = (float) $data[$tableUsers->group];
			$this->auth = true;
		}
		else
		{
			$this->auth = false;
			$this->login = 'Гость';
			$this->group = 'guest';
		}
		
		$perm = mysql_fetch_assoc($model->getGroup($this->group));
		
		$see = array(1, 2, 3, 4, 5, 6, 9, 10, 16, 21);
		$editMy = array(2, 9, 10, 16, 21);
		$deleteMy = array(1, 10, 16, 21);
		$create = array(3, 9, 10, 16, 21);
		$editAnother = array(6, 16, 21);
		$deleteAnother = array(5, 21);
		$onlyAll = array(21);
		
		## установка прав для страниц
		if(in_array($perm[$tableGroups->permPages], $see)) // просмотр страниц
			$this->seePage = true;
		if(in_array($perm[$tableGroups->permPages], $editAnother)) // редактирование
			$this->editPage = true;
		if(in_array($perm[$tableGroups->permPages], $create)) // создание
			$this->createPage = true;
		if(in_array($perm[$tableGroups->permPages], $deleteAnother)) // удаление
			$this->deletePage = true;
		
		## установка прав для админских страниц
		if(in_array($perm[$tableGroups->permControlPages], $see)) // просмотр страниц
			$this->seeControlPage = true;
		if(in_array($perm[$tableGroups->permControlPages], $editAnother)) // редактирование
			$this->editControlPage = true;
		if(in_array($perm[$tableGroups->permControlPages], $create)) // создание
			$this->createControlPage = true;
		if(in_array($perm[$tableGroups->permControlPages], $deleteAnother)) // удаление
			$this->deleteControlPage = true;
		
		## управление системой
		if(in_array($perm[$tableGroups->permControl], $onlyAll))
			$this->control = true;
		
		## установка прав на комментарии
		if(in_array($perm[$tableGroups->permComment], $see)) // просмотр
			$this->seeComments = true;
		if(in_array($perm[$tableGroups->permComment], $editMy)) // редактирование своих
			$this->editComments = true;
		if(in_array($perm[$tableGroups->permComment], $create)) // создание
			$this->createComments = true;
		if(in_array($perm[$tableGroups->permComment], $deleteMy)) // удаление своих
			$this->deleteComments = true;
		if(in_array($perm[$tableGroups->permComment], $create)) // редактирование чужих
			$this->editAnotherComments = true;
		if(in_array($perm[$tableGroups->permComment], $deleteMy)) // удаление чужих
			$this->deleteAnotherComments = true;
	}
	function forbidden()
	{
		vPerms::showForbidden();
		exit();
	}
}
/**
 * Обозначения прав
 * 0 - запрещено всё
 * 1 - позволяет удалять что-то своё
 * 2 - позволяет редактировать что-то своё
 * 3 - позволяет создавать
 * 4 - позволяет просматривать
 * 5 - позволяет удалять чужое
 * 6 - позволяет редактировать чужое
 * 9 - позволяет создавать, редактировать своё и просматривать всё
 * 10 - позволяет создавать, редактировать, удалять своё и просматривать всё
 * 16 - позволяет делать всё со своим, а также редактировать чужое и просматривать всё
 * 21 - позволяет всё
 */
$user = new cUser;
?>