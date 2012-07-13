<?php
/*** Функция createDirs
* Принимает массив, и создаёт папку по пути
* каждого элемента массива
*/
function createDirs($dirs)
{
	foreach($dirs as $key => $path)
	{
		mkdir($path);
	}
	return TRUE;
}
?>