<?
/*Создали интерфейс*/

namespace core;
use controller\BaseController;
use core\Logger;

interface ErrorHandlerInterface
{
	public function __construct(BaseController $ctrl, Logger $logger = null, $dev = true); // Если будем создавать экземпляр класса, то в него передаем объект $ctrl класса BaseController и объект $logger класса Logger. $logger нужен будет не всегда, поэтому по умолчанию присвоено значение null. $dev - переключатель режима developer (разработчик) и production (производство).
	public function handle(\Exception $e, $message); // Данный метод принимает обект класса Exception и $message - какое то сообщение, которое будем выводить при обнаружении ошибки.
}