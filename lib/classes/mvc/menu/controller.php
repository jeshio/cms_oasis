<?php
require_once(dirname(dirname(__FILE__)).'/model.php');
require_once('view.php');
require_once('viewMenuList.php');
/***
 * Контроллер вывода меню
 */
class cMenu extends model
{
    var $error;
    
	// $mode - как и какие данные показать (0 - обычное меню, другое значение - админское меню)
    function run($mode = 0) 
    {
		$res = NULL;
	    if($mode == 0)
		{
			$table = new table_pages;
			$q = $this->getMenu();
		}
		else
		{
			$table = new table_controlPages;
			$q = $this->getControlMenu();
		}
        
        while($data = mysql_fetch_assoc($q))
        {
            $res[$data[$table->uri]] = $data[$table->menuName];
        }
		if(count($res))
		{
				vMenu::show($res);
		}
        	
    }
	
	/***
	* Метод для обработки  и вывода списка меню
	* $for - определяет список какого меню выводить(0 - пользовательского, 1 - админского)
	* $mode - определяет где будет выведен список (0 - при создании страницы, 1 - при редактировании)
	*/
	function runMenuList($for, $mode = 0, $sel = 1)
	{
	
		if($for == 0)
		{
			$table = new table_pages;
			$q = $this->getMenu();
		}
		elseif($for == 1)
		{
			$table = new table_controlPages;
			$q = $this->getControlMenu();
		}
		else
			die('Неверный аргумент $for метода runMenuList: Line <b>'.__LINE__.'</b> - <b>'.__FILE__.'</b>');
		
		while($data = mysql_fetch_assoc($q))
        {
            $res[] = $data[$table->menuName];
        }
		
		if(!empty($res))
		{	
			if($mode == 0)
			{
				menuList::showOptionList($res);
			}
			elseif($mode == 1)
			{
				menuList::showEditOptionList($res, $sel);
			}
			else
				die('Неверный аргумент $mode метода runMenuList: Line <b>'.__LINE__.'</b> - <b>'.__FILE__.'</b>');
		}
	}

}

$ba_menuController = new cMenu();
?>
