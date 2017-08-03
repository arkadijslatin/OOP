<?php

/*Класс для подключения к БД.*/
namespace core;
class DB
{
    private static $instance;

	public static function get()
	{
		if (self::$instance === null) {
			self::$instance = self::connect();
		}

		return self::$instance;
	}

    private static function connect()
	{
		$dsn = DB_DRIVER . ':' . 'host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
		$opt = [
			\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
			\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION // PDO::ATTR_ERRMODE - режим сообщения об ошибке, PDO::ERRMODE_EXCEPTION: - выбрасывать исключения. Если при подключении возникнет ошибка, выбрасывается исключение
		];

		return new \PDO($dsn, DB_USER, DB_PASS, $opt);
	}

    
}

   