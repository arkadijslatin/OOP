<?php

namespace core;

class Validator implements ValidatorInterface
{
	public $schema;
	public $errors = [];
	public $clean = [];

	public function setSchema(array $schema) // массив $schema получаем из PostModel из __construct, т.е при создании объекта класса PostModel, данный массив уже будет у него в свойствах.
	{
		$this->schema = $schema;
		
	}

	public function run(array $obj) // $obj это массив который будет получен после заполнения полей формы т.е. $_POST 'name' и $_POST 'text'. Он приходит из PostController из метода addAction, переходит в BaseModel метод insert.
	{
		
		foreach ($this->schema as $name => $rules) { // $this->schema двумерный массив из __construct PostModel, в $name будут название полей таблицы БД, также это название полей формы которую заполняем при добавлении и редактирование статьи. $rules это второй массив, где ключами являются 'type', 'require', 'length'.

			
			
			/*Эти все проверки могут в дальнейшем пригодиться, но данном этапе они лишние*/
			if (!isset($obj[$name]) && $rules['require']) { // Если в массиве $obj не существует ключа $name и в правилах ($rules) 'requre' установлен в true, то тогда 
				$this->errors[$name] = 'Пропущен обязательный параметр!';
				
			}
			// Проверка длины строк
			if (isset($obj[$name]) && isset($rules['length'])) { // Проверяем есть ли массив isset($rules['length'])
				$strlen = strlen($obj[$name]); // strlen($obj[$name]) возвращает длину строки в байтах массива $obj[$name] по ключу name.
				

				if (is_array($rules['length'])) { // is_array проверяет является ли $rules['length'] массивом и если условие верно
					$min = $rules['length'][0]; // Присваиваем первое значение в массиве
					$max = $rules['length'][1]; // Присваиваем второе значение в массиве

				} else {
					$min = 0; // Если условие не верно, то присваиваем значение 0 
					$max = $rules['length']; // Присваиваем значение которое определено в $rules['length']
				}

				if ($strlen > $max) { // Сравниваем длину строки с максимальным заданным размером
					// $this->errors[$name] = sprintf('Слишком длинное название статьи %s символа, из %s возможных!', $strlen, $max); // так можно "склеить" сообщение
					$this->errors[$name] = 'Слишком длинное название статьи!'; 
				}

				if ($strlen < $min) { // Сравниваем длину строки с минимальным заданным размером 
					// $this->errors[$name] = sprintf('Слишком короткое название статьи %s символа, из %s возможных!',$strlen , $min);
					$this->errors[$name] = 'Слишком короткое название!';
				}
			}
			
			if (isset($obj[$name])) {

				if (!is_string($obj[$name]) && $rules['type'] === 'string') { // Если параметры не типа 'string'
					$this->errors[$name] = sprintf('Expected string value, %s given!', gettype($obj[$name]));
				}
				
				
				if (!preg_match('/^([а-яА-ЯЁёa-zA-Z0-9- ,.!?]+)$/u',$obj[$name])) { // $obj[$name] массив от первой заполняемой формы т.е. название статьи или логин. Доработать, чтобы нельзя было запрещенные символы писать и в текст стаьи и в password.
					
					$this->errors[$name] = 'Недопустимый символ в названии!';

				}
				if (iconv_strlen($obj[$name]) > $rules['length']) {
					
					$this->errors[$name] = 'Название очень большое!';
				}
				
				if (empty($obj[$name])) {
					$this->errors[$name] = 'Заполните все пустые поля!';
				}
				
			}
						
			if (!isset($this->errors[$name])) { // Если ошибок нет
                $this->clean[$name] = trim(htmlspecialchars($obj[$name])); // Обрабатываем информацию введенную пользователем в полях формы для дальнейшей передачи её в БД.

            }
        }
	}
}