<?php

namespace Controllers;

use Core\Controllers\BaseController;
use Core\Controllers\IProtected;
use Core\Http\Request;
use Core\ServiceContainer;
use Core\Validation\Validator;
use Repositories\TaskRepository\TaskRepository;
use Services\NotificationService\IType;
use Services\NotificationService\NotificationService;

class TaskController extends BaseController implements IProtected
{
    /** @var TaskRepository */
    private $taskRepository;
    /** @var Validator */
    private $validator;

    public function __construct()
    {
        $serviceContainer = ServiceContainer::getInstance();

        $this->taskRepository = $serviceContainer->get('task_repository');
        $this->validator = $serviceContainer->get('validator');
    }

    public function getProtectedMethods()
    {
        return ['edit', 'setComplete'];
    }

    public function get(Request $request)
    {
        $sortBy = $request->get('sortBy', 'id');
        $page = $request->get('page', 1);

        $tasks = $this->taskRepository->get($sortBy, $page);
        $count = $this->taskRepository->count();

        $pages = ceil($count / 3);

        return $this->renderWithLayout(['tasks' => $tasks, 'page' => $page, 'pages' => $pages, 'sortBy' => $sortBy]);
    }

    public function create(Request $request)
    {
        if ($request->isPost()) {
            /** @var NotificationService $notificationService */
            $notificationService = ServiceContainer::getInstance()->get('notification_service');

            if (!$this->validator->isValid($request->post(), [
                'username' => 'required,length|255',
                'email' => 'required,email,length|255',
                'text' => 'required'
            ])) {
                $notificationService->set(IType::FAIL, $this->validator->getFirstError());

                return $this->renderWithLayout();
            }

            $this->taskRepository->create(
                $request->post('username'),
                $request->post('email'),
                $request->post('text')
            );

            $notificationService->set(IType::SUCCESS, 'Task created');

            $request->redirect('/');
        }

        return $this->renderWithLayout();
    }

    public function edit(Request $request, int $taskId)
    {
        if ($request->isPost()) {
            /** @var NotificationService $notificationService */
            $notificationService = ServiceContainer::getInstance()->get('notification_service');

            if (!$this->validator->isValid($request->post(), ['text' => 'required'])) {
                $notificationService->set(IType::FAIL, $this->validator->getFirstError());

                return $this->renderWithLayout();
            }

            $this->taskRepository->edit($taskId, $request->post('text'));

            $notificationService->set(IType::SUCCESS, 'Task updated');

            $request->redirect('/');
        }

        $task = $this->taskRepository->getOne($taskId);

        return $this->renderWithLayout(['task' => $task]);
    }

    public function setComplete(Request $request, int $taskId)
    {
        $this->taskRepository->setComplete($request->decodedJson('isComplete'), $taskId);

        $this->renderJson([
            'status' => 'OK'
        ]);
    }
}
