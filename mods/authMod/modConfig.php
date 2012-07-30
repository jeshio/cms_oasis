<?php
/**
 * Настройка мода 'authMod'
 */
class authModConfig
{
	var $emailConfirm = true; // подтверждение e-mail'а
	
	// Регулярные выражения
	var $regLogin = '/[0-9a-zАаБбВвГгДдЕеЁёЖжЗзИиЙйКкЛлМмНнОоПпРрСсТтУуФфХхЦцЧчШшЩщЪъЫыЬьЭэЮюЯя_]/i';
	var $regEmail = '/[0-9a-z_](@)[0-9a-z_](.)[a-z]{2,4}/i';
	
	// Минимальное количество символов
	var $minLenLogin = 3;
	var $minLenPass = 6;
	var $minLenEmail = 6;
	
	// Максимальное количество символов
	var $maxLenLogin = 20;
	var $maxLenPass = 20;
	var $maxLenEmail = 60;
}