<?
/*Создаем класс и переносим туда почти все и index.php*/
namespace core;

use core\Request;
use core\Logger;
use controller\BaseController;
use core\exception\PageNotFoundException;
use core\exception\BaseException;
use core\ErrorHandler;
use controller\UserController;
use core\Session;
use core\Cookie;


class Application
{
	public $request; // В данное свойство кладем объект класса Request, в методе initRequest().
	private $controller;
	private $action;

	public function __construct()
	{
		
		$this->initRequest(); // При создании объекта класса Application
		$this->handlingUri();
		

	}

	public function run()
	{
		try {

			if (!$this->controller) // Если controller не 'post' или другой заданный нами контроллер
			{
				throw new PageNotFoundException(); // Выбрасываем исключение
			}

			$ctrl = new $this->controller($this->request); // Создаем объект класса PostController со всеми методами и свойствами

			$action = $this->action; // Определяем какой либо из методов Action
			$ctrl->$action(); // Вызываем этот метод
			$ctrl->response(); // Отдаем результат, т.е. выводим на экран.

		} catch (\PDOException $e) { // Ловим исключение PDO об ошибке подключения. Если поймали 

			/*$eHandler = new ErrorHandler( // Создаем экземпляр класса ErrorHandler
					new BaseController($this->request), // Передали объект класса BaseController.
					new Logger ('critical', LOG_DIR), // Передали объект класса Logger.
					DEV
				);
			$eHandler->handle($e, 'Ooooops... Something went wrong!');*/ // Упрощаем синтаксис

			(
				new ErrorHandler // Создаем экземпляр класса ErrorHandler, в который передаем:
				( 
					new BaseController($this->request), // Передали объект класса BaseController.
					new Logger ('critical', LOG_DIR), // Передали объект класса Logger.
					DEV
				)
			)->handle($e, 'Ooooops... Something went wrong!');
			
		}

			/*Заменили на $eHandler*/
			/*$logger = new Logger ('critical', LOG_DIR); // Заходим в файл 'critical.log' в папке logs.
			$logger->write(sprintf("%s\n%s", $e->getMessage(), $e->getTraceAsString()), Logger::ERR); // Записываем в данный файл информацию.

			// TODO определить режим работы сайта. Если это для клиента, то выводить 'Ooooops... Something went wrong!', а если для разаработчика то на экран выводить $e->getMessage() и $e->getTraceAsString() т.е. ошибки.

			$ctrl = new BaseController($this->request); // Создали новый объект класса BaseController.
			
			
			$ctrl->staticAction('Ooooops... Something went wrong!'); // Вызываем метод staticAction, который в content передает 'Ooooops... Something went wrong!'.
			$ctrl->response(); // Передаем content в main.php.*/

		catch (PageNotFoundException $e) { // Ловим исключения на методы 'post', 'Action' и id.
			/*$ctrl = new BaseController($this->request); // Создаем объект класса BaseController.
			$ctrl->error404(); // Вызываем метод error404().
			$ctrl->response(); // Вызываем метод response().*/ //Заменили на new ErrorHandler.
			(
				new ErrorHandler // Создаем экземпляр класса ErrorHandler, в который передаем:
				( 
					new BaseController($this->request), // Передали объект класса BaseController.
					null, // Если не нужно записывать в лог.
					DEV
				)
			)->handle($e, 'Page Not Found!');

		} 
		catch (\Exception $e) {
			(
				new ErrorHandler // Создаем экземпляр класса ErrorHandler, в который передаем:
				( 
					new BaseController($this->request), // Передали объект класса BaseController.
					new Logger ('critical', LOG_DIR), // Передали объект класса Logger.
					DEV
				)
			)->handle($e, 'Ooooops... Something went wrong!');
		}


	}


	/*private function initRequest()
	{
		$this->request = new Request($_GET, $_POST, $_FILES, $_COOKIE, $_SERVER); // Создаем объект класса Request, в нем находяться все служебные массивы.
		
	}*/
	private function initRequest()
	{
		$this->request = new Request(
			$_GET,
			$_POST,
			$_FILES,
			new Cookie(), // Вместо массива $_COOKIE передаем экземпляр класса Cookie
			$_SERVER,
			new Session() // Вместо массива $_SESSION передаем экземпляр класса Session

			             
		);

					
	}

	private function handlingUri() // В данный метод объединили 3 метода
	{
		$arr = $this->getUriAsArr(); // Объявляем массив из GET параметров.

		$this->setIdFromUri($arr); // Если есть третье значение, то его присваиваем массиву $_GET по ключу 'id'

		$this->controller = $this->getController($arr); // Получаем путь до файла, где находится контроллер 'controller\PostController'.
		$this->action = $this->getAction($arr); // В контроллере поучаем название метода indexAction, oneAction, editAction и т.д.
		
	}

	private function getController(array $uri)
	{
		$controller = $uri[1] ?? DEFAULT_CONTROLLER; // Если есть первое значение в url, то оно записывается в $controller, если нет то записывается константа DEFAULT_CONTROLLER (раньше записывали 'post'). Константы находятся в config.php. 

		switch ($controller) {
			case 'post':
				$controller = 'Post';
				break;
			case 'user':
				$controller = 'User';
				break;
			default:
				$controller = false;
				break;
		}

		return $controller ? sprintf('controller\%sController', $controller) : false;
	}

	private function getAction(array $uri)
	{
		return sprintf('%sAction', $uri[2] ?? 'index');
	}

	private function getUriAsArr() // Метод для  создания массива из GET параметров, т.е. из того что введено в url адресс.
	{
		$uri = explode('?', $this->request->getUri())[0];
		$uri = explode('/', $uri);
		$cnt = count($uri);

		if ($uri[$cnt - 1] === '') {
			unset($uri[$cnt - 1]);
		}

		return $uri;

	}

	private function setIdFromUri(array $uri)
	{
		if (isset($uri[3])) {
			$this->request->get['id'] = $uri[3]; // Массиву $_GET по ключу 'id' присваиваем третьей значение в url.
		}
	}
	
}
