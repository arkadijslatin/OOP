<?php
 
namespace core;

use model\UserModel;
use model\SessionModel;
use core\exception\UserException;
use core\exception\ValidatorException;
use core\exception\UserFoundException;
use core\helpers\CookieHelper;
use core\Request;

 class User 
 {
 	private $mUser;
	private $mSession;
	private $request;

 	public function __construct(Request $request, UserModel $mUser, SessionModel $mSession) // Сразу в конструкторе передаем объекты классов Request - все массивы: get, post,file, cookie, server, session; UserModel, SessionModel
 	{
 		$this->request = $request; // И в свойства класса User записываем данные объекты
		$this->mUser = $mUser;
		$this->mSession = $mSession;
 		

 	} 
 	public function registration($fields) // Метод регистрации пользователей
 	{
 		
 		$user = $this->mUser->getByLogin($fields['login']); // вызываем всех пользователей из БД



 		if (!empty($user)) { // Если массив $user не пустой
 			throw new UserFoundException([], sprintf('Пользователь с логином %s уже существует.', $fields['login'])); // Выбрасываем исключение, что такой пользователь уже есть
 			
 		}
 		if (empty($fields['login']) || empty($fields['password'])) {
 			throw new UserFoundException([], 'Заполните пожалуйста все поля!');
 		}
 		$fields['password'] = $this->getHashPass($fields['password']);

 		try {
			return $this->mUser->insert($fields);
		} catch (ValidatorException $e) {
			throw new UserFoundException($e->getUnvalidFields(), 'Возникла небольшая ошибка');
		}

 	}

 	public function login()
	{
		if (empty($this->request->post['login']) || empty($this->request->post['password'])) {
			
 			throw new UserFoundException([], 'Заполните пожалуйста все поля!');
 		}

		$user = $this->mUser->getByLogin($this->request->post['login']); // Из БД users выбираем пользователя по логину который ввели в форму. Если в БД нет пользователя с логином введенным в форму, то массив $user будет пустой. $user это массив из таблицы messages, где колонки таблицы являются ключами.
		
		if (empty($user)) { // Если массив пустой
		
			throw new UserFoundException([], sprintf('Пользователя с логином %s не существует.', $this->request->post['login'])); // Выбрасываем исключение
		}
		
		if ($user['password'] !== $this->getHashPass($this->request->post['password'])) { // Сравниваем пароль usera из таблицы с паролем который ввели в форму, предворительно зашифровав его. Если пароли не совпадают

			throw new UserFoundException([], 'Неправильный пароль'); // выбрасываем исключение
		}
		
		$sid = $this->getToken(); // В переменную $sid записываем 16-ти значное значение

		$this->request->session->set('sid', $sid); // Устанавливаем сессию и массиву $_SESSION по ключу 'sid' присваиваем значение $sid

		$this->mSession->insert(['sid' => $sid, 'user_id' => $user['user_id']]); // Данную сессию передаем в БД в таблицу session. В колонку sid передаем 16-ти значное значение, в колонку user_id id пользователя из таблицы users.

		if (isset($this->request->post['remember'])) { // Если нажато запомнить
			$this->request->cookie->set('user', $this->request->post['login'], '30 days'); // передаем куки user и login пользователя, сроком на 30 дней.
		// $result = $this->mUser->getBySID($sid);
		// echo "<pre>";
		// var_dump($_SESSION);
		// echo "</pre>";
		// die;				

		}
		
		return true;
	}

	public function can(string $priv)
	{
		if (!$user = $this->checkAuth()) {
			return false;
		}

		$login = $user['login'];
		$user = $this->mPriv->getUserByPrivAndLogin($priv, $login);

		return !empty($user);
	}
	public function checkAuth() // Проверка авторизации
	{
		$result = false;
		$sid = $this->request->session->get('sid'); // Вызывем из БД таблицы session сессию по ключу 'sid' т.е. по 16-ти значному значению
		$cookieLogin = $this->request->cookie->get('user'); // Вызываем куки по ключу 'user'

		if (!$sid && !$cookieLogin) { // Если нет в БД таблицы session сессии по ключу 'sid' и не повешана кука по ключу 'user'
			return false; // Возвращаем false
		}

		if ($sid) {
			$result = $this->mUser->getBySID($sid); // Если есть $sid, то из БД users и session склеиваем строку с одинаковым user_id и с $sid переданным в getBySID(). Получаем $result
		}

		if ($result) { //  Если есть $result то в БД session обновляем время посещения (reg_date)
			$this->mSession->Update(['reg_date' => time()]);
			return $result;
		}

		if ($cookieLogin) { // Если есть куки, то $result присваиваем логин
			$result = $this->mUser->getByLogin($cookieLogin);
		}

		if ($result) { // Если $result не пустой то заносим $sid в БД session
			$sid = $this->getToken();
			$this->request->session->set('sid', $sid);
			$this->mSession->insert(['sid' => $sid, 'user_id' => $user['id']]);
		}

		return $result;
		// SELECT * FROM `users` JOIN roles ON users.id_role = roles.id JOIN privs_to_roles ON roles.id = privs_to_roles.id_role JOIN privs ON privs_to_roles.id_priv = privs.id
	}

 	private function getHashPass($password)
	{
		return hash('sha256', $password . SAULT);

	}

	private function getToken() // Метод для генерации session id.
	{
		$pattern = 'qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM1234567890'; // патерн для генерации
		$token = '';

		for ($i = 0; $i < 16; $i++) { // Циклом выбираем 16 случайных значений из патерна. Число 16 желательно заменить константой.
			$symbol = mt_rand(0, strlen($pattern) - 1); // -1 потому, что строка как массив начинается с 0.
			$token .= $pattern[$symbol]; // К $token за итерацию (проход) цикла приклеиваем одно из случайных значений из патерна. Таким образом получаем 16-ти значное случайное значение.
		}

		return $token;
	}
 	        
 }