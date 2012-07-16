<?php
require_once('/../model.php');
require_once('view.php');
/***
 * Контроллер страниц
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
		
        $table = new table_pages();
        $q = $this->getContent($url);
        $data = mysql_fetch_assoc($q);
		if($data[$table->visible] == 1)
		{
			vPages::show($data, 0);
		}
        else
		{
			vPages::err();
		}
    }
}

$ba_pagesController = new cPages();
?>