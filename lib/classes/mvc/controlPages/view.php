<?php
require_once(dirname(dirname(__FILE__)).'/model.php');
/***
 * Представление страниц админки
 */
class vPages extends model
{
    static function show($array)
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
