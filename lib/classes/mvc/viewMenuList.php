<?php
require_once('/../model.php');
/***
 * Представление меню
 */
class menuList
{
	function showOptionList($array, $sel) // метод для выбора позиции при создании страницы
	{
        $config = new totalConfig();
		$count = 2;
        foreach($array as $uri => $menuName)
        {
            $ba_link = $config->path.$uri;
            echo '<option'.$sel[$count].' value="'.$count.'">После '.$menuName."</option>\n";
			$count++;
        }
	}
	function showEditOptionList($array, $sel) // метод для выбора позиции при редактировании страницы
	{
        $config = new totalConfig();
		$count = 1;
        foreach($array as $uri => $menuName)
        {
            $ba_link = $config->path.$uri;
            echo '<option'.$sel[$count].' value="'.$count.'">На место '.$menuName."</option>\n";
			$count++;
        }
	}
}
?>