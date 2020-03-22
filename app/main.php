<?php
/**
 * Entry of app
 *
 * Functionality:
 * 1. Setup configuration and services
 * 2. Run app
 */

define('APP_PATH', __DIR__);

require_once './vendor/autoload.php';

use Core\Bootstrapper;
use Core\ServiceContainer;

$serviceContainer = ServiceContainer::getInstance();

$serviceContainer
    ->set('env', [
        'app' => [
            'name'        => getenv('APP_NAME'),
            'description' => getenv('APP_DESCRIPTION'),
        ],
        'db' => [
            'host'     => getenv('DB_HOST'),
            'port'     => getenv('DB_PORT'),
            'name'     => getenv('DB_NAME'),
            'username' => getenv('DB_USERNAME'),
            'password' => getenv('DB_PASSWORD'),
        ],
        'admin' => [
            'username' => getenv('ADMIN_USERNAME'),
            'password' => getenv('ADMIN_PASSWORD'),
        ],
        'token_secret'     => getenv('TOKEN_SECRET'),
    ])
    ->set('routes', require_once APP_PATH . '/routes.php')
    ->set('request', new \Core\Http\Request())
    ->set('route_matcher', new \Core\Router\Matcher())
    ->set('db_context', new \Core\Db\DbContext(
        $serviceContainer->get('db_context')['db']['host'],
        $serviceContainer->get('db_context')['db']['port'],
        $serviceContainer->get('db_context')['db']['name'],
        $serviceContainer->get('db_context')['db']['username'],
        $serviceContainer->get('db_context')['db']['password'],
    ))
    ->set('validator', new \Core\Validation\Validator())
    ->set('token_repository', new \Repositories\TokenRepository($serviceContainer->get('db_context')))
    ->set('task_repository', new \Repositories\TaskRepository\TaskRepository($serviceContainer->get('db_context')))
    ->set('auth_service', new \Services\AuthService($serviceContainer->get('token_repository')))
    ->set('notification_service', new \Services\NotificationService\NotificationService())
;

(new Bootstrapper())->bootstrap();
