<?
namespace core;

class Request
{
	const METHOD_POST = 'POST';
	const METHOD_GET = 'GET';

	public $get;
	public $post;
	public $file;
	public $cookie;
	public $server;

	public function __construct($get, $post, $file, $cookie, $server)
	{
		$this->get = $get;
		$this->post = $post;
		$this->file = $file;
		$this->cookie = $cookie;
		$this->server = $server;
	}

	public function isPost()
	{
		return $this->server['REQUEST_METHOD'] === self::METHOD_POST;
	}

	public function isGet()
	{
		return $this->server['REQUEST_METHOD'] === self::METHOD_GET;
	}
}