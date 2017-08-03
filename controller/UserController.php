<? 

namespace controller;

use model\UserModel;
use model\SessionModel;
use core\User;
use core\DB;
use core\DBDriver;
use core\Validator;
use core\exception\PageNotFoundException;
use core\Exception\ValidatorException;
use core\exception\UserFoundException;



class UserController extends BaseController
{
	public function regAction() 
	{
		$errors = [];
		$msg = '';
		if ($this->request->isPost()) { // Если пришел запрос методом POST
			$mUser = new UserModel( // создаем объект класса UserModel
				new DBDriver(DB::get()),
				new Validator()
				);
			$mSession = new SessionModel ( // создаем объект класса SessionModel
				new DBDriver(DB::get()),
				new Validator()
				);

			$user = new User( // создаем объект класса User в который записываем 
				$this->request, // свойства полученные от объекта класса Request
				$mUser, // свойства полученные от объекта класса UserModel
				$mSession // свойства полученные от объекта класса SessionModel
			); 
			
			
			try {
				$user->registration($this->request->post); // В объект передаем весь POST массив. Регистрируем пользователя методом registration
				$msg = 'Вы успешно зарегистрированы!';
			}
			catch (UserFoundException $e) { // Ловим исключение, что пользователь с таким логином уже существует.
				$msg = $e->getMessage(); // Присваиваем $msg сообщение которое написали при выбрасывании исключения
				$errors = $e->getUnvalidFields(); // В $errors записываем сообщения об ошибках которые в Validatore.
			}

		}
		
		 $this->title = 'Регистрация'; 

		 
	 //    $messages = $mModel->getAll(); 
	 //    $this->entrance = true;
	   //$this->forename = '';
	    
	    
	    $this->content = $this->render(
	    		'reg.php', 
	    		[
	    			'msg' => $msg, 
	    			'errors' => $errors,
	    			'post' => $this->request->post
	    		]
	    	); 

	}
	public function loginAction() 
	{
		$errors = [];
		$msg = '';

		if ($this->request->isPost()) { // Если запрос POST
			$mUser = new UserModel( // создаем объект класса UserModel
				new DBDriver(DB::get()),
				new Validator()
				);

			$mSession = new SessionModel ( // создаем объект класса SessionModel
				new DBDriver(DB::get()),
				new Validator()
				);

			$user = new User( // создаем объект класса User в который записываем 
				$this->request, // свойства полученные от объекта класса Request
				$mUser, // свойства полученные от объекта класса UserModel
				$mSession // свойства полученные от объекта класса SessionModel
			); 

			try {
				$user->login();
				
	   			$this->forename = $this->request->post['login'];
	   			// echo "<pre>";
	   			// print_r($this->request->post['login']);
	   			// echo "</pre>";
	   			// die;
	   			header('Location: /post/');
				//$msg = 'Вы успешно авторизованы!';
			}
			catch (UserFoundException $e) { // Ловим исключение есл пользователя с таким логином нет
				$msg = $e->getMessage();
				$errors = $e->getUnvalidFields();
			}
		}

		//$this->entrance = true;
	   //$this->forename = '';

		$this->title .= 'Авторизация'; 

	    $this->content = $this->render(
	    		'login.php', 
	    		[
	    			'msg' => $msg, 
	    			'errors' => $errors,
	    			'post' => $this->request->post
	    		]
	    	); 

	}
}