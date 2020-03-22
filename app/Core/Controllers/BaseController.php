<?php

namespace Core\Controllers;

use Core\Controllers\Exceptions\ForbiddenException;
use Core\ServiceContainer;
use Services\AuthService;
use Services\NotificationService\Notification;

abstract class BaseController
{
    public function __call($name, $arguments)
    {
        if ($this instanceof IProtected && in_array($this->getRealMethodName($name), $this->getProtectedMethods())) {
            /** @var AuthService $authService */
            $authService = ServiceContainer::getInstance()->get('auth_service');

            if (!$authService->verifyCookieToken()) {
                throw new ForbiddenException();
            }
        }

        $realActionName = $this->getRealMethodName($name);

        return $this->$realActionName(...$arguments);
    }

    protected function renderWithTemplate($vars = []): string
    {
        $serviceContainer = ServiceContainer::getInstance();

        $content      = $this->render($vars);
        $title        = $serviceContainer->get('env')['app']['name'];
        $description  = $serviceContainer->get('env')['app']['description'];
        /** @var Notification $notification */
        $notification = $serviceContainer->get('notification_service')->flush();

        unset($vars);
        unset($serviceContainer);

        return require_once APP_PATH . '/Views/layout.php';
    }

    protected function render($vars = []): string
    {
        foreach ($vars as $varName => $varValue) {
            $$varName = $varValue;
        }

        return require_once $this->getViewPath();
    }

    /**
     * @return string
     */
    private function getViewPath(): string
    {
        $backtrace = debug_backtrace();
        $folderName = str_replace('Controller', '', array_pop(explode('\\', self::class)));
        $viewName = $backtrace[3]['function'] . '.php';

        return APP_PATH . '/' . 'Views' . '/' . $folderName . '/' . $viewName;
    }

    private function getRealMethodName(string $fixtureName)
    {
        return str_replace(ICatchMethods::CATCH_METHOD_PREFIX, '', $fixtureName);
    }
}
