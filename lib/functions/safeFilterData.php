<?php
/***
* Функция фильтрации данных, введённых пользователём
* $str - данные
* $endStr - до какого символа производить запись (substr(0, $endStr))
* Если $endStr === false, то ф-ция возвратит ДЕФИЛЬТРАЦИЮ данных
*/
function filterData($str, $endStr = null)
{
    if($endStr !== false)
    {
        if(!empty($endStr))
        {
            return mysql_real_escape_string(htmlspecialchars(trim(substr($str, 0, $endStr)), ENT_QUOTES, 'UTF-8', FALSE));
        }
        else
        {
            return mysql_real_escape_string(htmlspecialchars(trim($str), ENT_QUOTES, 'UTF-8'));
        }
    }
    if($endStr === false)
    {
        return htmlspecialchars_decode($str, ENT_QUOTES);
    }
}
?>