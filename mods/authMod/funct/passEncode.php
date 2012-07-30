<?php
/**
 * Функция кодирует входные данные и
 * возвращает полученный результат
 */
function passEncode($pass)
{
	// FIXME сделать шифрование
	$result = sha1(md5($pass));
	return $result;
}
?>