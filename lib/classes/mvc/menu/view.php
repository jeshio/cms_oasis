<?php
require_once('/../model.php');
/***
 * Представление меню
 */
class vMenu extends model
{
    function show($array)
    {
        $config = new totalConfig();
        foreach($array as $uri => $menuName)
        {
            $ba_link = $config->path.$uri;
            $ba_linkName = $menuName;
            include('/../../../../part/menu/blockMenu.php');
        }
    }
}

?>