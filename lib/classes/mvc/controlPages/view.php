<?php
require_once('/../model.php');
/***
 * ������������� ������� �������
 */
class vPages extends model
{
    function show($array)
    {
        $columns = new table_controlPages();
		
		$config = new totalConfig();
		
		$ba_htmlTitle = $array[$columns->title]; // ������������ Title
		
        include_once($config->appPath.'control/part/head.php');
		
		echo $array[$columns->content];
		
		include_once($config->appPath.'control/part/footer.php');
    }
}

?>