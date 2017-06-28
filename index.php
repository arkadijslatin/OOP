<?php

include_once __DIR__ . '/system.php';

$uri = explode('?', $_SERVER['REQUEST_URI']) [0];
$uri = explode('/', $uri) ;
$cnt = count($uri);
if ($uri[$cnt - 1] === '') {
    unset($uri[$cnt - 1]);
}

$controller = $uri[1] ?? 'post'; 
$action = sprintf('%sAction', $uri[2] ?? 'index'); 

$id = $uri[3] ?? false;
if ($id) {
    $_GET ['id'] = $id;
}

switch ($controller) {
    case 'post':
        $controller = 'Post'; 
        break;
    case 'user':
        $controller = 'User';
        break;
    default:
        $controller = 'Post';
        break;
}

$request = new core\Request($_GET, $_POST, $_FILE, $_COOKIE, $_SERVER);

$controller = sprintf('controller\%sController', $controller); 

$controller = new $controller($request);

$controller->$action(); 

$controller->response(); 


?>     

    
 
