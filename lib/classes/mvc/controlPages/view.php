<?php
require_once('/../model.php');
/***
 * Представление страниц админки
 */
class vPages extends model
{
    function show($array)
    {
        $columns = new table_controlPages();
		
		$config = new totalConfig();
		
		$ba_htmlTitle = $array[$columns->title]; // устнавливаем Title
		
		$ba_mode = 1; // Включаем возможность редактирования
		
        include_once($config->appPath.'control/part/head.php');
		
		echo $array[$columns->content];
		
		include_once($config->appPath.'control/part/footer.php');
    }
}

?>
