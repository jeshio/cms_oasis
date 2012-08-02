<?php
require_once dirname(dirname(__FILE__)).'/lib/classes/mysql.php';
require_once dirname(dirname(__FILE__)).'/mods/authMod/mysql.php';

$ba_mysql = new mysqlConnection;
$ba_pages = new table_pages;
$ba_controlPages = new table_controlPages;
$authModTable = new tableUsers();
$authModTableGroups = new tableUserGroups();
$authModTableSpecPerms = new tableUserSpecPerms();
$ba_config = new totalConfig;

if(!$ba_mysql->choiceDB($ba_mysql->db))
{
	$ba_mysql->createDB($ba_mysql->db);
	header("Location: index.php");
}

$ba_mysql->choiceDB($ba_mysql->db);

if($ba_mysql->table_exists($ba_pages->table))
{
	$ba_mysql->query($ba_pages->createTable());
	echo 'Таблица '.$ba_pages->table.' создана';
}
else
{
	echo "Таблица уже существует.";
}

echo '<br />';

$ba_mysql->choiceDB($ba_mysql->db);
if($ba_mysql->table_exists($ba_controlPages->table))
{
	$ba_mysql->query($ba_controlPages->createTable());
	echo 'Таблица '.$ba_controlPages->table.' создана';
}
else
{
	echo "Таблица уже существует.";
}

echo '<br />';

if(file_exists($ba_config->appPath.'pages'))
	echo('Папка для пользовательских страниц создана');
else
{
	mkdir($ba_config->appPath.'pages');
	echo 'Папка '.$ba_config->appPath.'pages создана';
}

echo '<br />';

if(file_exists($ba_config->appPath.'pages/index.php'))
	echo 'Файл для пользовательских страниц создан';
else
{
	$file = fopen($ba_config->appPath.'pages/index.php', 'w');

	$fileContent = '<?php header("Location: ../") ?>';

	fwrite($file, $fileContent);

	fclose($file);
	
	echo 'Файл '.$ba_config->appPath.'pages/index.php создан';
}

echo '<br />';

if(file_exists($ba_config->appPath.'control/pages'))
	echo('Папка для админских страниц создана');
else
{
	mkdir($ba_config->appPath.'control/pages');
	echo 'Папка '.$ba_config->appPath.'control/pages создана';
}

echo '<br />';

if(file_exists($ba_config->appPath.'control/pages/index.php'))
	echo 'Файл для админских страниц создан';
else
{
	$file = fopen($ba_config->appPath.'control/pages/index.php', 'w');

	$fileContent = '<?php header("Location: ../") ?>';

	fwrite($file, $fileContent);

	fclose($file);
	
	echo 'Файл '.$ba_config->appPath.'control/pages/index.php создан';
}

echo '<br />';

if($ba_mysql->table_exists($authModTable->table))
{
	$ba_mysql->query($authModTable->createTable());
	echo 'Таблица '.$authModTable->table.' успешно создана!';
}
else
{
	echo 'Таблица '.$authModTable->table.' успешно создана!';
}

echo '<br />';

if($ba_mysql->table_exists($authModTableGroups->table))
{
	$ba_mysql->query($authModTableGroups->createTable());
	echo 'Таблица '.$authModTableGroups->table.' успешно создана!';
	$authModTableGroups->addDefaultGroups();
	echo '<br />';
	echo 'Группы по-умолчанию созданы!';
}
else
{
	echo 'Таблица '.$authModTableGroups->table.' успешно создана!';
	echo '<br />';
	echo 'Группы по-умолчанию созданы!';
}

echo '<br />';

if($ba_mysql->table_exists($authModTableSpecPerms->table))
{
	$ba_mysql->query($authModTableSpecPerms->createTable());
	echo 'Таблица '.$authModTableSpecPerms->table.' успешно создана!';
}
else
{
	echo 'Таблица '.$authModTableSpecPerms->table.' успешно создана!';
}

echo '<br />';

if($ba_mysql->table_exists($authModTableSpecPerms->table))
{
	$ba_mysql->query($authModTableSpecPerms->createTable());
	echo 'Таблица '.$authModTableSpecPerms->table.' успешно создана!';
}
else
{
	echo 'Таблица '.$authModTableSpecPerms->table.' успешно создана!';
}

echo '<br /><br/>';

require_once dirname(dirname(__FILE__)).'/mods/authMod/mvc/registration/controller.php';
echo 'Регистрация администраторского аккаунта.<br /><b>После регистрации удалите эту папку('.$ba_config->appPath.'setup)!!!</b>';
echo '<br /><br />';
$cReg->runReg($_POST, "", 1);
?>