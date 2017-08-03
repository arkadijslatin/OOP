<?
include_once __DIR__ . '/config.php';

session_start();

function __autoload($classname) // __autoload - вызывается когда не существует класс который мы хотим создать.
{

    $fileName = __DIR__ . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $classname) . '.php';

    if (!file_exists($fileName)) {
        // echo "$fileName";
        // die;
    }
    
   
    include_once $fileName;
}
