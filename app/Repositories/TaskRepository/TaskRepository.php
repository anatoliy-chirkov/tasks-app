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

    public function count()
    {
        $sql = "SELECT COUNT(*) FROM task";

        return $this->context->query($sql)[0][0];
    }

    public function get(string $sortBy, int $page)
    {
        $sql = "SELECT * FROM task";

        $sql .= ' ' . (new SortBy($sortBy))->getSql();
        $sql .= ' ' . (new Page($page))->getSql();

        return $this->context->query($sql);
    }

    public function getOne(int $taskId)
    {
        $sql = "SELECT * FROM task WHERE id = ?";

        return $this->context->query($sql, [$taskId])[0];
    }

    public function create(string $username, string $email, string $text)
    {
        $sql = "INSERT INTO task (username, email, text) VALUES (?, ?, ?)";

        $this->context->query($sql, [$username, $email, $text]);
    }

    public function edit(int $taskId, string $text)
    {
        $sql = "UPDATE task SET text = ?, isEdited = ? WHERE id = ?";

        $this->context->query($sql, [$text, 1, $taskId]);
    }

    public function setComplete(int $taskId)
    {
        $sql = "UPDATE task SET isCompleted = ? WHERE id = ?}";

        $this->context->query($sql, [1, $taskId]);
    }
}
