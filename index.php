<?php

use Testapp\Core\Router;
use Testapp\Core\Request;
use Testapp\Core\Config;
use Testapp\Utils\DependencyInjector;
use	Monolog\Logger;
use	Monolog\Handler\StreamHandler;

require_once __DIR__ . '/vendor/autoload.php';

// Config object
$config = new Config();
$dbConfig = $config->get('db');

// PHP Data Objects (PDO)
$db = new PDO(
    'mysql:host=127.0.0.1;dbname=myblog',
    $dbConfig['user'],
    $dbConfig['password']
);

// Twig template
$loader = new Twig_Loader_Filesystem(__DIR__ . '/src/views');
$view = new Twig_Environment($loader);

// Monolog logging system
$log = new Logger('myblog');
$logFile = $config->get('log');
$log->pushHandler(new StreamHandler($logFile, Logger::DEBUG));

// Dependency injector
$di = new DependencyInjector();
$di->set('PDO', $db);
$di->set('Config', $config);
$di->set('Twig_Environment', $view);
$di->set('Logger', $log);

$router = new Router($di);
$response = $router->route(new Request());
echo $response;

?>
