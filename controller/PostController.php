<?php

namespace controller;

use model\PostModel;
use core\DB;
use core\DBDriver;

class PostController extends BaseController
{
	public function indexAction() 
	{
		$this->title .= '::главная'; 

		$mModel = new PostModel(new DBDriver(DB::connect())); 
	    $messages = $mModel->getAll(); 
	    $this->content = $this->render('index.php', ['messages' => $messages], $msg); 
	}

	public function oneAction()
	{
		$mModel = new PostModel(new DBDriver(DB::connect()));
		$id = (int)$this->request->get['id'];

		if(!is_numeric($id) ||!$mModel->getOne($id)){
			$this->error404 ();
		}
	    else {
	    	$messages = $mModel->getOne($id);
	    	
	    	$this->title .= '::читай';
			$this->content = $this->render('post.php', ['messages' => $messages]);
		}
	}

	public function addAction()
	{
		if(isset($this->request->post['text']) && isset($this->request->post['name'])){
			

	        $name = trim(htmlspecialchars($this->request->post['name']));
	        $text = trim(htmlspecialchars($this->request->post['text']));
	       
	        if($name == '' || $text == ''){

	        	$msg = 'Заполните все поля'; 
	        }

	        else {
	        		            
				$mModel = new PostModel(new DBDriver(DB::connect()));
				$mModel->insert(
					[
						'name' => $this->request->post['name'],
						'text' => $this->request->post['text']
					]
				);

				header('Location: /post/');
	        	exit();
			}
	    }
		
		$this->title .= '::добавить страницу';
		//$this->rightBlock = '';
		$this->content = $this->render('add.php', ['name' => $name, 'text' => $text, 'msg' => $msg]); 
		
	}

	public function editAction()
	{
		
		$this->title .= '::редактировать страницу';
		//$this->rightBlock = '';
		
		$mModel = new PostModel(new DBDriver(DB::connect()));
		$id = (int)$this->request->get['id'];
		if(!is_numeric($id) ||!$mModel->getOne($id)){
			$this->error404 ();
		}
		else {
		
		$message = $mModel->getOne($id); 
		
		$this->content = $this->render('edit.php', ['message' => $message, 'msg' => $msg]);
		 
		}
		if(isset($this->request->post['edit'])){

	        $name = trim(htmlspecialchars($this->request->post['name']));
	        $text = trim(htmlspecialchars($this->request->post['text']));
	       
	        if($name == '' || $text == ''){

	        	$msg = "Заполните все поля"; // Дороботать
	        	

	        }

	        else {

	        		            
				$mModel->edit($id, 
					[
						'name' => $name,
						'text' => $text
					]);

				header('Location: /post/');
	        	exit();
			}
	           
	    }
	    elseif (isset($this->request->post['delete'])) { 
	        $mModel->delete($id);

	        header('Location: /post/');
	        exit(); 
	    }
    	
	}
}
