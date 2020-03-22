<?php
/**
 * Entry of app
 *
 * Functionality:
 * 1. Setup configuration and services
 * 2. Run app
 */

define('APP_PATH', __DIR__);
define('ROOT_PATH', __DIR__ . '/..');

require_once APP_PATH . '/Core/Autoloader.php';

use Core\Autoloader;
use Core\Bootstrapper;
use Core\ServiceContainer;

Autoloader::register();

$serviceContainer = ServiceContainer::getInstance();

$serviceContainer
    ->set('env', new \Core\DotEnv(ROOT_PATH . '/.env'))
    ->set('routes', require_once APP_PATH . '/routes.php')
    ->set('request', new \Core\Http\Request())
    ->set('route_matcher', new \Core\Router\Matcher())
    ->set('db_context', new \Core\Db\DbContext(
        $serviceContainer->get('env')->get('DB_HOST'),
        $serviceContainer->get('env')->get('DB_PORT'),
        $serviceContainer->get('env')->get('DB_NAME'),
        $serviceContainer->get('env')->get('DB_USERNAME'),
        $serviceContainer->get('env')->get('DB_PASSWORD')
    ))
    ->set('validator', new \Core\Validation\Validator())
    ->set('token_repository', new \Repositories\TokenRepository($serviceContainer->get('db_context')))
    ->set('task_repository', new \Repositories\TaskRepository\TaskRepository($serviceContainer->get('db_context')))
    ->set('auth_service', new \Services\AuthService($serviceContainer->get('token_repository')))
    ->set('notification_service', new \Services\NotificationService\NotificationService())
;

try {
    (new Bootstrapper())->bootstrap();
} catch (\Exception $e) {
    echo <<<HTML
<html>
    <header>
        <title>{$e->getMessage()}</title>
    </header>
    <body style="text-align: center;margin-top: 46px;">
        <h1>{$e->getCode()}</h1>
        <div>{$e->getMessage()}</div>
    </body>
</html>
HTML;
}
