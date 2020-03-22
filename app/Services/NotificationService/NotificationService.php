<?php

namespace Services\NotificationService;

class NotificationService
{
    private const
        COOKIE_NOTIFICATION_KEY = '_notification',
        COOKIE_EXPIRATION_TIME  = 3600
    ;

    public function set(string $type, string $message)
    {
        setcookie(
            self::COOKIE_NOTIFICATION_KEY,
            serialize(new Notification($type, $message)),
            self::COOKIE_EXPIRATION_TIME
        );
    }

    public function flush()
    {
        if (empty($_COOKIE[self::COOKIE_NOTIFICATION_KEY])) {
            return new Notification(null, null);
        }

        $notification = unserialize($_COOKIE[self::COOKIE_NOTIFICATION_KEY]);

        setcookie(self::COOKIE_NOTIFICATION_KEY, null);

        return $notification;
    }
}
