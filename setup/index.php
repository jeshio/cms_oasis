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
?>
<form action="" method="POST">
<input name="createDB" type="submit" value="Создать базу данных <?php echo $ba_mysql->db ?>" />
<br />
<input name="createPages" type="submit" value="Создать таблицу <?php echo $ba_pages->table ?>" />
<br />
<input name="createControlPages" type="submit" value="Создать таблицу <?php echo $ba_controlPages->table ?>" />
</form>