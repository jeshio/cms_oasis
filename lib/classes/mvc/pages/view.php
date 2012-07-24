<?php
require_once(dirname(dirname(__FILE__)).'/model.php');
/***
 * Представление страниц
 */
class vPages extends model
{
    static function show($array, $ba_mode = 0) // $ba_mode - режим админа
    {
        $columns = new table_pages();
		
		$config = new totalConfig();
		
		$ba_htmlTitle = $array[$columns->title];
		$ba_htmlDesc = $array[$columns->desc];
		$ba_htmlKW = $array[$columns->kw];
        include_once($config->appPath.'/part/head.php');
		
		echo $array[$columns->content];
		
		include_once($config->appPath.'/part/footer.php');
    }
	static function err() // выводит ошибку 404
	{
		$sapi_name = php_sapi_name();
		if ($sapi_name == 'cgi' || $sapi_name == 'cgi-fcgi')
		{
    		header('Status: 404 Not Found');
		} else
		{
    		header($_SERVER['SERVER_PROTOCOL'] . '404 Not Found');
		}
	}
}
?>
