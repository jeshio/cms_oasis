<?php
require_once('/../model.php');
require_once('view.php');
/***
 * Контроллер вывода меню
 */
class cMenu extends model
{
    var $error;
    
	// $mode - как и какие данные показать (0 - обычное меню, другое значение - админское меню)
    function run($mode = 0) 
    {
	    if($mode == 0 OR $mode == 3)
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
}

$ba_menuController = new cMenu();
?>