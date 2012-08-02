<?php
/**
 * Представление для контроллера прав
 */
class vPerms
{
	/**
	 * Метод вывода отказа в показе страницы
	 */
	static function showForbidden()
	{
		$sapi_name = php_sapi_name();
		if ($sapi_name == 'cgi' || $sapi_name == 'cgi-fcgi')
		{
			header ("HTTP/1.0 403 Forbidden");
		} else
		{
			header($_SERVER['SERVER_PROTOCOL'] . '403 Forbidden');
		}
	}
}
?>