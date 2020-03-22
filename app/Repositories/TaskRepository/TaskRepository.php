<?php

namespace Repositories\TaskRepository;

use Core\Db\DbContext;
use Repositories\TaskRepository\Filter\Page;
use Repositories\TaskRepository\Filter\SortBy;

class TaskRepository
{
    private $context;

    public function __construct(DbContext $context)
    {
        $this->context = $context;
    }

    public function get(string $sortBy, int $page)
    {
        $sql = "SELECT * FROM task";

        $sql .= ' ' . (new SortBy($sortBy))->getSql();
        $sql .= ' ' . (new Page($page))->getSql();

        return $this->context->query($sql);
    }

    public function create(string $username, string $email, string $text)
    {
        $sql = "INSERT INTO task VALUES (null, ?, ?, ?})";

        $this->context->query($sql, [$username, $email, $text]);
    }

    public function edit(int $taskId, string $text)
    {
        $sql = "UPDATE task SET (text = ?, isEdited = 1) WHERE id = ?";

        $this->context->query($sql, [$text, $taskId]);
    }

    public function setComplete(int $taskId)
    {
        $sql = "UPDATE task SET (isCompleted = 1) WHERE id = ?}";

        $this->context->query($sql, [$taskId]);
    }
}
