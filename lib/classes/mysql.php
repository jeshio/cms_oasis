<?php
require_once(dirname(dirname(dirname(__FILE__)))."/config.php");
require_once($ba_config->appPath."lib/functions/safeFilterData.php");

/*
Класс для работы с MySQL
*/
class mysqlConnection extends totalConfig
{
    var $link;
    
    function __construct()
    {
        $this->connect();
        $this->choiceDB($this->db);
    }
        
    private function connect() // открытие соединения
    {
        $this->link = mysql_connect($this->host.':'.$this->port, $this->login, $this->pass)
        OR die("Невозможно подключиться к базе данных. Проверьте данные для подключения.");
    }
    
    function choiceDB($name) // выбор базы данных
    {
        if(mysql_select_db($name, $this->link))
        {
            $this->query('SET NAMES "utf8"', $this->link);
            $this->query("set character_set_connection=utf8");
            return true;
        }
        else
            return false;
    }
    
    function query($query, $return = FALSE) // запрос в базу данных MySQL, если $return == true, метод в любом случае
											// вернёт результат, иначе если запрос не пашет - выведет ошибку
    {
        $res = mysql_query($query, $this->link);
        if (!$res and $return == FALSE)
            die("Не получается выполнить запрос:<br/>".mysql_error());
        return $res;
    }
    
    function createDB($name) // создание базы данных
    {
        if($this->query('CREATE DATABASE '.$name.' COLLATE utf8_general_ci;', $this->link))
            return true;
        else
            return false;
    }
    
    function table_exists($table) // проверка существования таблицы
    {
        $query = 'DESCRIBE '.$table;
        $r = $this->query($query, TRUE);
        if($r)
        {
            return false;
        }
        else
        {
            return true;
        }
    }
    
    function close() // закрытие соединения
    {
        mysql_close($this->link);
    }
} // класс mysqlConnection

/***
 * Класс для работы с таблицей "pages" 
 */
class table_pages
{
    var $table = 'pages'; // название таблицы
    var $title = 'title'; // title страницы
    var $menuName = 'menuName'; // название в меню
    var $pos = 'position'; // позиция страницы в меню
    var $kw = 'keywords'; // ключевые слова страницы
    var $desc = 'description'; // описание страницы
    var $content = 'content'; // содержимое страницы
    var $visible = 'visible'; // видимость страницы для пользователей
    var $created = 'created'; // время создания
    var $modTime = 'modification'; // время редактирования
    var $uri = 'uri'; // URI страницы
    
    function __construct()
    {
		$config = new totalConfig();
        $this->table = $config->prefix.$this->table;
    }
    
    /** Метод возвращает MySQL запрос для добавления данных в таблицу
     * 1 аргумент - title
     * 2 - название в меню
     * 3 - позиция в меню
     * 4 - ключевые слова
     * 5 - описание страницы
     * 6 - содержимое страницы
     * 7 - видимость страницы
     * 8 - URI страницы
     */
    function addToTable($ba_title, $ba_menuName, $ba_pos, $ba_kw, $ba_desc, $ba_content, $ba_vis, $ba_uri)
    {
        $ba_title = mysql_real_escape_string(filterData($ba_title, 255));
        $ba_menuName = mysql_real_escape_string(filterData($ba_menuName, 255));
        $ba_pos = mysql_real_escape_string(filterData($ba_pos, 9));
        $ba_kw = mysql_real_escape_string(filterData($ba_kw, 255));
        $ba_desc = mysql_real_escape_string(filterData($ba_desc, 255));
        $ba_content = mysql_real_escape_string($ba_content);
        $ba_vis = mysql_real_escape_string(filterData($ba_vis, 1));
        $ba_uri = mysql_real_escape_string(filterData($ba_uri, 255));
        
        return 'INSERT INTO '.$this->table.'('.
        $this->title.', '.
        $this->menuName.', '.
        $this->pos.', '.
        $this->kw.', '.
        $this->desc.', '.
        $this->content.', '.
        $this->visible.', '.
        $this->uri.
        ') VALUES (`'.$ba_title.'`, `'.$ba_menuName.'`, `'.$ba_pos.'`, `'.$ba_kw.'`, `'.$ba_desc.'`, `'.$ba_content.'`, `'.$ba_vis.'`, `'.$ba_uri.'`)';
    }
    function createTable()
    {
        $config = new totalConfig;
        return 'CREATE TABLE IF NOT EXISTS '.$this->table.'('.
               $config->id.' MEDIUMINT NOT NULL AUTO_INCREMENT, '.
               $this->title.' VARCHAR(255) NOT NULL, '.
               $this->menuName.' VARCHAR(255) NOT NULL, '.
               $this->pos.' SMALLINT NOT NULL, '.
               $this->kw.' VARCHAR(255) NOT NULL, '.
               $this->desc.' VARCHAR(255) NOT NULL, '.
               $this->content.' TEXT NOT NULL, '.
               $this->visible.' TINYINT(1) NOT NULL, '.
               $this->uri.' VARCHAR(255) NOT NULL, '.
               $this->created.' TIMESTAMP, '.
               $this->modTime.' TIMESTAMP, 
               PRIMARY KEY('.$config->id.')
               ) ENGINE = MYISAM COLLATE utf8_general_ci;';
    }
} // класс table_pages

/***
 * Класс для работы с таблицей "controlPages" 
 */
class table_controlPages
{
    var $table = 'controlPages'; // название таблицы
    var $title = 'title'; // title страницы
    var $menuName = 'menuName'; // название в меню
    var $pos = 'position'; // позиция страницы в меню
    var $content = 'content'; // содержимое страницы
    var $uri = 'uri'; // URI страницы
    
    function __construct()
    {
		$config = new totalConfig();
        $this->table = $config->prefix.$this->table;
    }
    
    /** Метод возвращает MySQL запрос для добавления данных в таблицу
     * 1 аргумент - title
     * 2 - название в меню
     * 3 - позиция в меню
     * 4 - ключевые слова
     * 5 - описание страницы
     * 6 - содержимое страницы
     * 7 - видимость страницы
     * 8 - URI страницы
     */
    function addToTable($ba_title, $ba_menuName, $ba_pos, $ba_content, $ba_uri)
    {
        $ba_title = mysql_real_escape_string(filterData($ba_title, 255));
        $ba_menuName = mysql_real_escape_string(filterData($ba_menuName, 255));
        $ba_pos = mysql_real_escape_string(filterData($ba_pos, 9));
        $ba_content = mysql_real_escape_string($ba_content);
        $ba_uri = mysql_real_escape_string(filterData($ba_uri, 255));
        
        return 'INSERT INTO '.$this->table.'('.
        $this->title.', '.
        $this->menuName.', '.
        $this->pos.', '.
        $this->content.', '.
        $this->uri.
        ') VALUES (
		`'.$ba_title.'`,
		`'.$ba_menuName.'`,
		`'.$ba_pos.'`,
		`'.$ba_content.'`,
		`'.$ba_uri.'`
		)';
    }
    function createTable()
    {
        $config = new totalConfig;
        return 'CREATE TABLE '.$this->table.'('.
               $config->id.' MEDIUMINT NOT NULL AUTO_INCREMENT, '.
               $this->title.' VARCHAR(255) NOT NULL, '.
               $this->menuName.' VARCHAR(255) NOT NULL, '.
               $this->pos.' SMALLINT NOT NULL, '.
               $this->content.' TEXT NOT NULL, '.
               $this->uri.' VARCHAR(255) NOT NULL,
               PRIMARY KEY('.$config->id.')
               ) ENGINE = MYISAM COLLATE utf8_general_ci';
    }
} // класс table_controlPages

class tableWork
{
    function echoData($col, $id, $table) // возвращает данные из колонки $col таблицы $table, где ID = $id
    {
        $mysql = new mysqlConnection();
        $mysql->choiceDB($mysql->db);
        $query = $mysql->query('SELECT '.$col.' FROM '.$table.' WHERE '.$mysql->id.' = '.$id);
        $data = mysql_fetch_array($query, MYSQL_ASSOC);
        return $data;
    }
    
    function maxId() // возвращает максимальное значение в таблице
    {
        $mysql = new mysqlConnection();
        $mysql->choiceDB($mysql->db);
        $maxId = $mysql->query('SELECT MAX('.$mysql->id.') FROM '.$this->table);
        $maxId = mysql_fetch_array($maxId, MYSQL_NUM);
        return $maxId[0];
    }
} // класс tableWork

?>
