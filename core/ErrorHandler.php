<?

namespace core;
use controller\BaseController;
use core\Logger;

class ErrorHandler implements ErrorHandlerInterface
{
	private $ctrl;
	private $logger;
	private $dev;

	public function __construct(BaseController $ctrl, Logger $logger = null, $dev = true) // При создании экземпляра класса, в него передаем объект $ctrl класса BaseController и объект $logger класса Logger. $logger нужен будет не всегда, поэтому по умолчанию присвоено значение null. $dev - переключатель режима developer (разработчик) и production (производство).
	{
		$this->ctrl = $ctrl;
		$this->logger = $logger;
		$this->dev = $dev;
	}

	public function handle(\Exception $e, $message = '') // Данный метод принимает обект класса Exception и $message - какое то сообщение, которое будем выводить при обнаружении ошибки.
	{
		/*$this->logger->write(sprintf("%s\n%s", $e->getMessage(), $e->getTraceAsString()), Logger::ERR);
		$this->ctrl->error($message);
		$this->ctrl->response();*/ // Это все работает. Но сделали по другому.
		if (isset($this->logger)) { // Если $logger есть, тогда записываем в лог.
			$this->logger->write(sprintf("%s\n%s", $e->getMessage(), $e->getTraceAsString()), 'ERROR');
		}
		$msg =  sprintf('<h1>%s</h1>', $message); // Между тегами h1 вставляется $message

		if ($this->dev) { // Проверяем обработку флага. Если $dev true, т.е. включен режим developer
			$msg = sprintf('%s<h2>%s</h2><p>%s</p>', $msg, $e->getMessage(), $e->getTraceAsString()); // то выводим информацию которая записывается в лог, дополнительно на экран.sprintf склеивает строки. В первый %s попадает $msg, во второй %s попадает $e->getMessage(), в третий %s попадает $e->getTraceAsString().
		}
		$this->ctrl->error($msg); 
		$this->ctrl->response();
	}
}