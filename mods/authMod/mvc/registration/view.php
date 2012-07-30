<?php
require_once dirname(dirname(__FILE__)).'/model.php';

class vRegistration
{
	/**
	 * Показать стандартный контент страницы регистрациии
	 */
	static function show()
	{

		include_once dirname(dirname(dirname(__FILE__))).'/html/regContent.html';

	}
	/**
	 * Показать ошибки при заполнении полей на странице регистрации
	 */
	static function showErr($error)
	{
		if(!empty($error[0])) // не заполненые поля
		{
			echo 'Не заполнены поля:';
			echo '<br />';
			foreach ($error[0] as $num => $err)
			{
				if($num != 0)
					echo ', ';
				echo $err;
			}
			echo '<br /><br />';
		}
		
		if (!empty($error[1])) // остальные ошибки
		{
			foreach ($error[1] as $num => $err)
			{
				echo $err;
				echo '<br />';
			}
			echo '<br />';
		}
	}
	/**
	 * Показать результат регистрации
	 */
	static function showResult()
	{
		$config = new authModConfig();
		echo 'Новый пользователь успешно зарегестрирован!';
		if($config->emailConfirm)
		{
			echo '<br />';
			echo 'Теперь проверьте свою почту и подтвердите введённый E-mail.';
		}
	}
}
?>