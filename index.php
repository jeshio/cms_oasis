<?php
include("lib/classes/mvc/menu/controller.php");

$ba_mysql = new mysqlConnection;
$ba_pages = new table_pages;
$ba_data = new tableWork;

$ba_htmlTitle = "Главная страница"; // устнавливаем Title
$ba_htmlDesc = "CMS Oasis"; // мета-описание
$ba_htmlKW = "oasis, cms, site, new"; // ключевые слова

include("part/head.php");
?>

<?php
include("part/footer.php");

?>
