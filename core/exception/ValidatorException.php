<?php

namespace core\exception;


class ValidatorException extends BaseException
{
	private $unvalidFields = []; // Массив в который заносится список ошибок выявленных при валидации
    public function __construct(array $errors, $message = 'Error Bad Request', $code = 400, \Exception $previus = null) // При создании объекта класса, обычно это $e ему передаются все эти свойства
    {
        parent::__construct($message, $code, $previus);
        $this->unvalidFields = $errors; // В свойства записываем массив со списком ошибок.
    }

    public function getUnvalidFields() // Метод для вызова массива со списком ошибок.
	{
		return $this->unvalidFields;
	}
   
}
