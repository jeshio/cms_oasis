<?php
require_once(dirname(dirname(__FILE__)).'/model.php');
/***
 * Представление меню
 */
class vMenu extends model
{
    static function show($array)
    {
        $config = new totalConfig();
        foreach($array as $uri => $menuName)
        {
            $ba_link = $config->path.$uri;
            $ba_linkName = $menuName;
            include($config->appPath.'/part/menu/blockMenu.php');
        }
    }
}

?>
