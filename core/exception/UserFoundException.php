<?php

namespace core\exception;



class UserFoundException extends BaseException // Наследуем класс от BaseException.
{
	private $unvalidFields = [];

	public function __construct(array $unvalid = [], $message = 'User exception', $code = 100, \Exception $previus = null)
	{
		parent::__construct($message, $code, $previus);
		$this->unvalidFields = $unvalid;
	}
	public function getUnvalidFields()
	{
		return $this->unvalidFields;
	}
}