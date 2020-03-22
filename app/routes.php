<?php

use Core\Http\IMethod;
use Core\Router\Route;
use Controllers\{TaskController, AuthController};

return [
    new Route(
        '/',
        TaskController::class,
        'get',
        [IMethod::GET]
    ),
    new Route(
        '/create-task',
        TaskController::class,
        'create',
        [IMethod::GET, IMethod::POST]
    ),
    new Route(
        '/tasks/:id/edit',
        TaskController::class,
        'edit',
        [IMethod::GET, IMethod::POST]
    ),
    new Route(
        '/tasks/:id/set-complete',
        TaskController::class,
        'setComplete',
        [IMethod::POST]
    ),
    new Route(
        '/login',
        AuthController::class,
        'login',
        [IMethod::GET, IMethod::POST]
    ),
    new Route(
        '/logout',
        AuthController::class,
        'logout',
        [IMethod::POST]
    ),
];
