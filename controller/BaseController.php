<?php

namespace controller;

use core\Request;
use core\exception\PageNotFoundException;

class BaseController
{
	protected $title;
	protected $content; 
	protected $request;
	protected $entrance; // Создал флаг, если человек авторизован, то открывать ему доступ.
	protected $forename; // Имя пользователя, в дальнейшем как он назавется, так его и приветствовать.
	
	
		
	public function __construct(Request $request) // При создании объекта класса BaseController, сразу передаем в него объект класса Request. 
	{
		$this->title = 'PHP.blog'; 
		$this->content = '';
		$this->entrance = true; // По умолчанию.
		$this->forename = 'гость'; // По умолчанию гость.


		
		
					
		//$this->rightBlock = $this->render('right.html.php');

		$this->request = $request; // Записываем все свойства полученные от объекта класса Request в свойства класса BaseController. Т.е. передаем все массивы $_GET, $_POST, $_FILE, $_COOKIE, $_SERVER
		

	}
	public function __call($name, $args) //  При вызове недоступных методов вызывается метод __call(). Метод вызывается автоматически, если не нашелся метод. Т.е. если нет метода который был прописан в url, то вызывается данный метод.
	{

		throw new PageNotFoundException(); // Он выбрасывает исключение.
		
	}
	/*public function staticAction($message)
	{
		$this->content = $message;
	}*/

	public function response() //Методом response() подключаем view/main.php
	{
		echo $this->render('main.php', ['title' => $this->title, 'content' => $this->content, 'forename' => $this->forename, 'entrance' => $this->entrance]);
	}
	/** 
	 * Подставляет переменные в шаблон
	 * 
	 * @param string $tmp - название шаблона - файл в папке view
	 * @param array $vars - массив передаваемый в content 
	 * @return string - сгенерированный html
	 */
	protected function render ($tmp, array $vars = []) 
	{
		
		ob_start();
		extract($vars);
		include_once __DIR__ . '/../view/' . $tmp; 

		return ob_get_clean();
	}


	public function error ($msg) 
	{
		$this->title = '::ошибка'; 
		$this->content = $this->render('error.php', ['msg' => $msg]); 
		header('HTTP/1.1 404 Not Found'); 

	}
}