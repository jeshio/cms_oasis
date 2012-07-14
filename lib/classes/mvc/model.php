<?php
require_once('/../mysql.php');
/***
 * Модель для получения данных из БД
 */
class model extends mysqlConnection
{
    function getMenu()
    {
        $table = new table_pages();
        $query = 'SELECT * FROM '.$table->table.' WHERE '.$table->visible.' = 1 ORDER BY '.$table->pos;
        return $this->query($query);
    }
	function getControlMenu()
	{
		$table = new table_controlPages();
		$query = 'SELECT * FROM '.$table->table.' ORDER BY '.$table->pos;
		return $this->query($query);
	}
    function getContent($url)
    {
        $table = new table_pages();
        $query = 'SELECT * FROM '.$table->table.' WHERE '.$table->uri.'="'.$url.'" LIMIT 1';
        return $this->query($query);
    }
	function getControlContent($url)
    {
        $table = new table_controlPages();
        $query = 'SELECT * FROM '.$table->table.' WHERE '.$table->uri.'="'.$url.'" LIMIT 1';
        return $this->query($query);
    }
	function addControlPage($title, $menuname, $url, $content, $menupos)
	{
		$table = new table_controlPages();
		$query = 'INSERT INTO '.$table->table.' ('.
		$table->title.','.
		$table->menuName.','.
		$table->uri.','.
		$table->content.','.
		$table->pos.
		') VALUES ("'.
		$title.'","'.
		$menuname.'","'.
		$url.'","'.
		$content.'","'.
		$menupos
		.'")';
		
		return $this->query($query);
	}
	function addPage($title, $menuname, $url, $KW, $desc, $content, $menupos, $vis)
	{
		$table = new table_pages();
		$query = 'INSERT INTO '.$table->table.' ('.
		$table->title.','.
		$table->menuName.','.
		$table->uri.','.
		$table->kw.','.
		$table->desc.','.
		$table->content.','.
		$table->pos.','.
		$table->visible.','.
		$table->created.
		') VALUES ("'.
		$title.'","'.
		$menuname.'","'.
		$url.'","'.
		$KW.'","'.
		$desc.'","'.
		$content.'","'.
		$menupos.'",'.
		$vis.',
		NOW())';
		
		return $this->query($query);
	}
	function updatePage($title, $menuname, $KW, $desc, $content, $menupos, $vis, $url)
	{
		$table = new table_pages();
		$query = 'UPDATE '.$table->table.' SET '.
		$table->title.' = "'.$title.'",'.
		$table->menuName.' = "'.$menuname.'",'.
		$table->kw.' = "'.$KW.'",'.
		$table->desc.' = "'.$desc.'",'.
		$table->content.' = "'.$content.'",'.
		$table->pos.' = "'.$menupos.'",'.
		$table->visible.' = '.$vis.','.
		$table->modTime.' = NOW() WHERE '.$table->uri.'="'.$url.'"';
		
		return $this->query($query);
	}
	function updateControlPage($title, $menuname, $content, $menupos, $url)
	{
		$table = new table_controlPages();
		$query = 'UPDATE '.$table->table.' SET '.
		$table->title.' = "'.$title.'",'.
		$table->menuName.' = "'.$menuname.'",'.
		$table->content.' = "'.$content.'",'.
		$table->pos.' = "'.$menupos.'" WHERE '.$table->uri.'="'.$url.'"';
		
		return $this->query($query);
	}
	/*** menuPos
	 * Метод для работы с позициями в меню
	 * $pos - куда нужно установить в меню
	 * $mode - при редактировании, если новая позиция больше(+) и если новая позиция меньше(-)
	 * $def - при редактировании, изначальная позиция в меню
	 */
	function menuPos($table, $pos, $mode = "", $def = "")
	{
		if(empty($mode))
			$query = 'UPDATE '.$table->table.' SET '.$table->pos.' = '.$table->pos.' + 1 WHERE '.$table->pos.'>='.$pos;
		elseif($mode == '+')
		{
			$query = 'UPDATE '.$table->table.' SET '.$table->pos.' = '.$table->pos.' - 1
			WHERE '.$table->pos.'<='.$pos.' AND '.$table->pos.'>'.$def;
		}
		elseif($mode == '-')
		{
			$query = 'UPDATE '.$table->table.' SET '.$table->pos.' = '.$table->pos.' + 1
			WHERE '.$table->pos.'>='.$pos.' AND '.$table->pos.'<'.$def;
		}
		else
			die('Неверный параметр метода menuPos в классе файла model.php; line <b>'.__LINE__.'</b>');

		return $this->query($query);
	}
	function checkValue($val, $col, $table) // проверяет колонку $col в таблице $table на сушествование значения $val
	{
		$query = 'SELECT * FROM '.$table.' WHERE '.$col.' = "'.$val.'"';
		if(mysql_num_rows($this->query($query, FALSE)) == 0)
			return TRUE;
		else
			return FALSE;
	}
	function createDir($path) // создание папки по аргументу-пути
	{
		if(file_exists($path))
			return FALSE;
		
		if(mkdir($path))
			return TRUE;
	}
	function createURL($url, $content) // применяется при создании страницы
	{		
		$file = fopen($url.'/index.php','w');
		fwrite($file, $content);
		fclose($file);
		
		return TRUE;
	}
	function repairURL($url) // метод испраляет неправильно написанные URL при создании страницы
	{
		$urlArr = preg_split('/[\/]/', $url, -1, PREG_SPLIT_NO_EMPTY);

		$arrCount = count($urlArr) - 1;

		for($i = 0; $i <= $arrCount; $i++)
		{
    		if($i == 0)
	    		$reUrl = $urlArr[$i];
			else
				$reUrl .= '/'.$urlArr[$i];
		}
		return $reUrl;
	}
}

?>