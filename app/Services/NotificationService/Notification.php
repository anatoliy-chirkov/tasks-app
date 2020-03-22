<?php

namespace Services\NotificationService;

class Notification
{
    public $type;
    public $message;

    public function __construct(string $type, string $message)
    {
        $this->type = $type;
        $this->message = $message;
    }

    public function isset()
    {
        return $this->message === null;
    }
}
