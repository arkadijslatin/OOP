<?php

namespace core\exception;

class ModelException extends BaseException 
{
	public function __construct($message = "CriticalException", $code = 500, \Exception $previous = null)
	{
		parent::__construct($message, $code, $previous);
	}
}