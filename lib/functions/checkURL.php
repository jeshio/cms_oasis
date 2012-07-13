<?php
/***
* Функция принимает в аргументах
* $dir - путь,
* $topDir - это "верхняя" папка
* Возвращает в массиве от 0 и больше пути для создания папок
* Пример:
* $dir - /cool/bot/hi
* $topDir - /public/www
* функция возвратит массивы: 0 - /public/www/cool, 1 - /public/www/cool/bot, 2 - /public/www/cool/bot/hi
*/

require_once("/../../config.php");

define(appData, substr($ba_config->appPath, 0, strlen($ba_config->appPath) - 1));

function checkURL($dir, $topDir = appData)
{
	$Dirs = preg_split('/[\/]/', $dir, -1, PREG_SPLIT_NO_EMPTY);

	foreach($Dirs as $key => $dirName)
	{
		$tempDir .= '/'.$dirName;
		if(!file_exists($topDir.$tempDir))
		{
			$result[] = $topDir.$tempDir;
		}
	}
	
	return $result;
}
?>