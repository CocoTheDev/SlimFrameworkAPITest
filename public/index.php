<?php 
declare(strict_types=1);

// Tutorial From :
// https://www.youtube.com/watch?v=PHZtujcTRPk
// and
// https://www.youtube.com/watch?v=v5tAdjf0o3E

use Dotenv\Dotenv;
use DI\ContainerBuilder;
use Slim\Factory\AppFactory;
use Slim\Handlers\Strategies\RequestResponseArgs;


define('APP_ROOT', dirname(__DIR__));
require APP_ROOT . '/vendor/autoload.php';


$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();


$builder = new ContainerBuilder;
$container = $builder->addDefinitions(APP_ROOT . '/config/definitions.php')
                    ->build();


AppFactory::setContainer($container);

$app = AppFactory::create();

$collector = $app->getRouteCollector();
$collector->setDefaultInvocationStrategy(new RequestResponseArgs);
$app->addBodyParsingMiddleware();

$app->addErrorMiddleware(true, true, true);


require APP_ROOT . '/config/routes.php';




$app->run();

