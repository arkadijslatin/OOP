<?php
/*Класс для написания текстовых сообщений и сохранении их на диске.*/
namespace core;

class Logger
{
	const ERR = 'ERROR';
	const INFO = 'INFO';

	private $file; // Название файла.
	private $dir; // Директория.
	private $fullpath; // Полный путь до файла.

	public function __construct($filename, $dir) // Через конструктор принимает $filename - название файла, $dir - директорию для логов.
	{
		$this->file = sprintf('%s.log', $filename); // В свойства уставливаем название файла. Sprintf — Возвращает отформатированную строку. Т.е. к $filename приклеивается .log 
		$this->dir = $dir; // Путь до директории.
		/*var_dump($this->dir);
		die;*/
		$this->fullpath = sprintf('%s/%s', $dir, $this->file); // Склеиваем все в единый путь.

		$this->prepareDir();
	}

	public function write($log, $level = '') // Метод для записи логов. Принимает $log (сообщение для лога) и $level - это деление логов на уровни (для информации, критические ошибки и т.д.), сделан не обязательным параметром, при необходимости можно сделать массив.
	{	$date = date('Y-m-d H:i:s');
		$body = sprintf("\n\nDate: %s\nLevel: %s\nText: %s\n*****************", $date, $level, $log);
		
		file_put_contents($this->fullpath, $body, FILE_APPEND);
	}

	protected function prepareDir()
	{
		if (!file_exists($this->dir)) { // Проверяет есть ли директория.
			if (!mkdir($this->dir, 0777, true)) // Если нет, то создает данную директория с максимальными правами (0777), true позволяет создать полный путь указанный в $this->dir, без него создается только первое значение в директории (aaa/ddd/rrr/ - это с true, aaa/ - это без true).
			{
				throw new \RuntimeException("Log dir can't be created by path \"{$this->dir}\" "); // Если директорию не удалось создать возвращается false и выбрасывается исключение.
			}
		}
	}
}