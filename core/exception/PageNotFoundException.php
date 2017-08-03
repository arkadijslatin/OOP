<?php

namespace core\exception;

class PageNotFoundException extends BaseException // Наследуем класс от BaseException.
{
	public function __construct($message = '404 error', $code = 404, \Exception $previus = null)
	{
		parent::__construct($message, $code, $previus);
	}
}