<?php
require_once dirname(dirname(__FILE__)).'/mysql.php';

$mysql = new mysqlConnection();
$tableUsers = new tableUsers();

if($mysql->table_exists($tableUsers->table))
{
	echo $tableUsers->createTable().'<br /><br />';
	$mysql->query($tableUsers->createTable());
	echo 'Таблица '.$tableUsers->table.' успешно создана!';
	exit();
}

echo 'Таблица с таким названием('.$tableUsers->table.') уже есть.';

?>
