<?php
/**
 * Функция кодирует входные данные и
 * возвращает полученный результат
 */
function passEncode($pass)
{
	$result = sha1(md5($pass));
	return $result;
}
?>