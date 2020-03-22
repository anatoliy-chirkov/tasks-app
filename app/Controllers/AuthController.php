<?php

namespace Controllers;

use Core\Controllers\BaseController;
use Core\Controllers\IProtected;
use Core\Http\Request;
use Core\ServiceContainer;
use Core\Validation\Validator;
use Services\AuthService;
use Services\NotificationService\IType;
use Services\NotificationService\NotificationService;

class AuthController extends BaseController implements IProtected
{
    /** @var AuthService */
    private $authService;

    public function __construct()
    {
        $this->authService = ServiceContainer::getInstance()->get('auth_service');
    }

    public function getProtectedMethods()
    {
        return ['logout'];
    }

    public function login(Request $request)
    {
        if ($request->isPost()) {
            /** @var Validator $validator */
            $validator = ServiceContainer::getInstance()->get('validator');
            /** @var NotificationService $notificationService */
            $notificationService = ServiceContainer::getInstance()->get('notification_service');

            if (!$validator->isValid($request->post(), ['username' => 'required', 'password' => 'required'])) {
                $notificationService->set(IType::FAIL, $validator->getFirstError());

                return $this->renderWithLayout();
            }

            if (!$this->authService->checkCredentials(
                $request->post('username'),
                $request->post('password'))
            ) {
                $notificationService->set(IType::FAIL, 'Wrong username or password');

                return $this->renderWithLayout();
            }

            $this->authService->setUpToken();

            $request->redirect('/');
        }

        return $this->renderWithLayout();
    }

    public function logout(Request $request)
    {
        $this->authService->removeToken();

        $request->redirect('/');
    }
}
