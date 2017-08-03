<?
namespace core; // Не прописываем use\core\Cookie и Session, так как он находятся на одном уровне core.

class Request
{
	const METHOD_POST = 'POST';
	const METHOD_GET = 'GET';

	public $get;
	public $post;
	public $file;
	public $cookie;
	public $server;
	public $session;

	public function __construct($get, $post, $file, Cookie $cookie, $server, Session $session) // При создании экземпляра класса Request передаем в него массивы $get-GET, $post-POST, $file-FILE, $server-SERVER и передаем экземпляры класса Cookie и Session
	{
		$this->get = $get; // Все это записываем в свойства класса Request
		$this->post = $post;
		$this->file = $file;
		$this->cookie = $cookie;
		$this->server = $server;
		$this->session = $session;
	}

	public function isPost()
	{
		
		return $this->server['REQUEST_METHOD'] === self::METHOD_POST;
	}

	public function isGet()
	{
		return $this->server['REQUEST_METHOD'] === self::METHOD_GET;
	}

	public function getUri()
	{
		return $this->server['REQUEST_URI']; // Данный метод возвращает массив $_SERVER['REQUEST_URI'].
	}
}