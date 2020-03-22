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
        //$_SESSION[self::COOKIE_NOTIFICATION_KEY] = serialize(Notification::create($type, $message));
        setcookie(
            self::COOKIE_NOTIFICATION_KEY,
            serialize(Notification::create($type, $message)),
            time() + self::COOKIE_EXPIRATION_TIME
        );
    }

    public function flush()
    {
//        if (empty($_SESSION[self::COOKIE_NOTIFICATION_KEY])) {
//            return Notification::stub();
//        }
//
//        $notification = unserialize($_SESSION[self::COOKIE_NOTIFICATION_KEY]);
//
//        unset($_SESSION[self::COOKIE_NOTIFICATION_KEY]);

        if (empty($_COOKIE[self::COOKIE_NOTIFICATION_KEY])) {
            return Notification::stub();
        }

        $notification = unserialize($_COOKIE[self::COOKIE_NOTIFICATION_KEY]);

        setcookie(self::COOKIE_NOTIFICATION_KEY, null);

        return $notification;
    }
}
