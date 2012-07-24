<?php
require_once(dirname(dirname(__FILE__)).'/model.php');
require_once('view.php');
/***
 * Контроллер админских страниц
 */
class cPages extends model
{    
    function run()
    {
		$urlArr = preg_split('/[\/]/', $_SERVER['PHP_SELF'], -1, PREG_SPLIT_NO_EMPTY);

		$arrCount = count($urlArr) - 2;

		for($i = 0; $i <= $arrCount; $i++)
		{
    		if($i == 0)
	    		$url = $urlArr[$i];
			else
				$url .= '/'.$urlArr[$i];
		}
		
        $table = new table_controlPages();
        $q = $this->getControlContent($url);
        $data = mysql_fetch_assoc($q);
		
		vPages::show($data);
    }
}

$ba_pagesController = new cPages();
?>
