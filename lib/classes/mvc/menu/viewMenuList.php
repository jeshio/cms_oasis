<?php
require_once(dirname(dirname(__FILE__)).'/model.php');
/***
 * Представление списка меню
 */
class menuList
{
	static function showOptionList($array = "") // метод для выбора позиции при создании страницы
	{
        $config = new totalConfig();
		$count = 2;
        foreach($array as $uri => $menuName)
        {
            $ba_link = $config->path.$uri;
            empty($count) ? $count = "" : $count;
            echo '<option value="'.$count.'">После '.$menuName."</option>\n";
			$count++;
        }
	}
	static function showEditOptionList($array, $sel) // метод для выбора позиции при редактировании страницы
	{
        $config = new totalConfig();
		$count = 1;
        foreach($array as $uri => $menuName)
        {
            $ba_link = $config->path.$uri;
            empty($sel[$count]) ? $sel[$count] = "" : $sel[$count];
            echo '<option'.$sel[$count].' value="'.$count.'">На место '.$menuName."</option>\n";
			$count++;
        }
	}
}
?>
