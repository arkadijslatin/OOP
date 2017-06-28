<?


function __autoload($classname)
{

    $fileName = __DIR__ . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $classname) . '.php';

    if (!file_exists($fileName)) {
        
    }
    
    include_once $fileName;
}
