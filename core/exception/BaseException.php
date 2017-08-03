<?php

namespace core\exception;

class BaseException extends \Exception // Создаем свой класс BaseException, который является наследником от уже установленного в php класса Exception. Это нужно, что бы отличать выброшенные нами исключения отличались от выброшенных исключений php.
{
	public function __construct($message = "CriticalException", $code = 500, \Exception $previous = null)
	{
		parent::__construct($message, $code, $previous);
	}
}