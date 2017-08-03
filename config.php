<?php

define('DB_DRIVER', 'mysql');
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'phpchat1');
define('DB_CHARSET', 'utf8');

define('ROOT', __DIR__); // Путь до корня нашего сайта. Поэтому его объявляют в файле который находится в корне файла.
define('LOG_DIR', ROOT . '/logs'); // Создаем стандартную директорию для логов.

define('DEFAULT_CONTROLLER', 'post'); // Константа для метода getController() класса Application. Для удобства, если необходимо поменять значение, то делаем это в одном месте.
define('DEV', true); // Константа для переключения режима developer (разработчик) и production (производство).
define('SAULT', 'lkdhb46bfhgeu77'); // константа для хэштрования 'соль'.
