<?php
include("../lib/classes/mysql.php");

$ba_mysql = new mysqlConnection;
$ba_pages = new table_pages;
$ba_controlPages = new table_controlPages;

if(!empty($_POST['createDB']) and !$ba_mysql->choiceDB($ba_mysql->db))
{
    $ba_mysql->createDB($ba_mysql->db);
    header("Location: index.php");
}
if(!empty($_POST['createPages']))
{
    $ba_mysql->choiceDB($ba_mysql->db);        
    if($ba_mysql->table_exists($ba_pages->table))
    {
        $ba_mysql->query($ba_pages->createTable());
        header("Location: index.php");
    }
    else
    {
        echo "Таблица уже существует.";
    }
}
if(!empty($_POST['createControlPages']))
{
    $ba_mysql->choiceDB($ba_mysql->db);        
    if($ba_mysql->table_exists($ba_controlPages->table))
    {
        $ba_mysql->query($ba_controlPages->createTable());
        header("Location: index.php");
    }
    else
    {
        echo "Таблица уже существует.";
    }
}
if(!empty($_POST['createDirPages']))
{
	$ba_config = new totalConfig;
	
    if(file_exists($ba_config->appPath.'pages'))
		echo('Папка для пользовательских страниц создана<br/>');
	else
		mkdir($ba_config->appPath.'pages');
	
	if(file_exists($ba_config->appPath.'pages/index.php'))
		echo 'Файл для пользовательских страниц создан<br/>';
	else
	{
		$file = fopen($ba_config->appPath.'pages/index.php', 'w');
		
		$fileContent = '<?php header("Location: ../") ?>';
		
		fwrite($file, $fileContent);
		
		fclose($file);
	}
	
	if(file_exists($ba_config->appPath.'control/pages'))
		echo('Папка для админских страниц создана<br/>');
	else
		mkdir($ba_config->appPath.'control/pages');
	
	if(file_exists($ba_config->appPath.'control/pages/index.php'))
		echo 'Файл для админских страниц создан<br/>';
	else
	{
		$file = fopen($ba_config->appPath.'control/pages/index.php', 'w');
		
		$fileContent = '<?php header("Location: ../") ?>';
		
		fwrite($file, $fileContent);
		
		fclose($file);
	}
}
?>
<form action="" method="POST">
<input name="createDB" type="submit" value="Создать базу данных <?php echo $ba_mysql->db ?>" />
<br />
<input name="createPages" type="submit" value="Создать таблицу <?php echo $ba_pages->table ?>" />
<br />
<input name="createControlPages" type="submit" value="Создать таблицу <?php echo $ba_controlPages->table ?>" />
<br />
<input name="createDirPages" type="submit" value="Создать папку Pages" />
</form>