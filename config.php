<?php

class totalConfig
{
	var $path = "/"; // путь до CMS
	
	var $appPath; // путь для инклудов

    var $login = "root"; // логин
    var $pass = "root"; // пароль
    var $host = "localhost"; // хост
    var $port = 3306; // порт
    
    var $id = 'id'; // название колонки с уникальным номером
    var $db = "oasis"; // название базы данных
    var $prefix = "oasis_"; // префикс для таблиц
	
	function __construct ()
	{
		$this->appPath = dirname(__FILE__).'/';
	}
}

$ba_config = new totalConfig();

?>
