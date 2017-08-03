<?php

namespace controller;

use model\PostModel;
use core\DB;
use core\DBDriver;
use core\exception\PageNotFoundException;
use core\exception\ValidatorException;
use core\Validator;


class PostController extends BaseController
{
	public function indexAction() 
	{
		$this->title .= '::главная'; 

		$mModel = new PostModel(
			new DBDriver(DB::get()),
			new Validator()
			); 
	    $messages = $mModel->getAll(); 
	    $this->entrance = true;
	   //$this->forename = '';
	    
	    
	    $this->content = $this->render('index.php', ['messages' => $messages]); 

	}

	public function oneAction()
	{
		$mModel = new PostModel(
			new DBDriver(DB::get()),
			new Validator()
			); 
		$id = (int)$this->request->get['id'];
		

		if(!is_numeric($id) ||!$mModel->getOne($id)) {
			throw new PageNotFoundException(); // Если id не число или нет статьи с таким id, то выбрасываем исключение. А ловим его в классе Application, в методе run(). 
			
			//$this->error404 (); // Так было до этого.
		}
	    else {
	    	$message = $mModel->getOne($id);
	    	//$this->entrance = false;
	    	$this->title .= 'Статья';
			$this->content = $this->render('post.php', ['message' => $message]);
		}
	}

	public function addAction()
	{
		$msg = '';
		$errors = '';
		$mModel = new PostModel(
					new DBDriver(DB::get()),
					new Validator()
					); 
				
			if($this->request->isPost()) {
				$name = trim(htmlspecialchars($this->request->post['name']));
	        	$text = ($this->request->post['text']);

				try {
					$mModel->insert(['name' => $name, 'text' => $text]);
					$msg = 'Статья добавлена!';
				}  
				catch (ValidatorException $e) {
					$errors = $e->getUnvalidFields(); // Вызываем объект $e класса ValidatorException, который вызывает массив errors и этот массив записываем в $msg_errors
				}
			}
				
		$this->title .= 'Добавить статью';
		//$this->rightBlock = '';
		$this->content = $this->render('add.php', ['name' => $name, 'text' => $text, 'errors' => $errors, 'msg' => $msg]); 
	}	
	

	public function editAction()
	{
		$msg = '';
		$errors = '';
		$this->title .= 'Редактировать статью';
		//$this->rightBlock = '';
		
		$mModel = new PostModel(
			new DBDriver(DB::get()),
			new Validator()
			); 
		$id = (int)$this->request->get['id'];
		if(!is_numeric($id) ||!$mModel->getOne($id)) {
			throw new PageNotFoundException(); // Если id не число или нет статьи с таким id, товыбрасываем исключение. А ловим его в классе Application, в методе run().
			//$this->error404 (); // Так было до этого.
		}
		else {
		
			$message = $mModel->getOne($id); 
			$name = $message['name'];
			$text = $message['text'];
     	}

		if(isset($this->request->post['edit'])) {
			$name = trim(htmlspecialchars($this->request->post['name']));
	        $text = ($this->request->post['text']);
	        
			try {
				$mModel->edit($id, ['name' => $name, 'text' => $text]);
				$msg = 'Статья отредактирована!';
				// header('Location: /post/'); // Сразу переход на главную без отбражения $msg = 'Статья отредактирована!';
   				// exit();
					
			}  
			catch (ValidatorException $e) {
				$errors = $e->getUnvalidFields(); // Вызываем объект $e класса ValidatorException, который методом getUnvalidFields вызывает массив errors и этот массив записываем в $msg_errors
				
							
			}
	    }
	    elseif (isset($this->request->post['delete'])) { 
	        $mModel->delete($id);
	        $msg = 'Статья удалена!';

	        // header('Location: /post/');
	        // exit(); 
	    }
	    $this->content = $this->render('edit.php', ['name' => $name, 'text' => $text, 'errors' => $errors, 'msg' => $msg]);
    	
	}
}
