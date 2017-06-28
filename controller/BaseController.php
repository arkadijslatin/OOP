<?php

namespace controller;

use core\Request;

class BaseController
{
	protected $title;
	protected $content; 
	protected $request;
	
		
	public function __construct(Request $request)
	{
		$this->title = 'PHP.blog'; 
		$this->content = '';
		
				
		//$this->rightBlock = $this->render('right.html.php');

		$this->request = $request;

	}

	public function response() //Методом response() подключаем view/main.php
	{
		echo $this->render('main.php', ['title' => $this->title, 'content' => $this->content]);
		
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

	protected function error404 () 
	{
		$this->title = '::ошибка 404'; 
		$this->content = $this->render('error.php'); 
		header('HTTP/1.1 404 Not Found'); 
	}
}