<?php

namespace core;

class Session
{
	public function get($key) // Метод вызывает массив $_SESSION по ключу $key, который передаем в метод
	{
		return $_SESSION[$key] ?? null; // Если существует массив $_SESSION по ключу $key, то мы его вернем, а если нет, то вернем null.
	}

	public function set($key, $value) // Метод установки сессии. 
	{
		$_SESSION[$key] = $value; // Массиву $_SESSION по ключу $key присваиваем значение $value, переданное в данный метод.
	}

	public function del($key) // Метод удаления сессии.
	{
		unset($_SESSION[$key]); // Удаляем массив $_SESSION по ключу $key.
	}
}