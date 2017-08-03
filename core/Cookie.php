<?php

namespace core;

class Cookie
{
	public static function set($name, $value, $time) // Метод для постаонвки кук. $time переменная отвечающая за время действия куки
	{
		setcookie($name, $value, strtotime("+$time"), '/');
	}

	public function get($name) // Метод для вызова массива кук
	{
		return $_COOKIE[$name] ?? false;
	}

	public static function del($name) // Метод для удаления кук
	{
		setcookie($name, '', time() -1);
	}
}