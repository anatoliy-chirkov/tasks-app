<?php
/**
 * @var $title string
 * @var $description string
 * @var $innerViewPath string
 * @var $notification \Services\NotificationService\Notification
 */
?>
<html lang="en">
<head>
    <title><?= $title ?></title>
    <meta name="description" content="<?= $description ?>" />
</head>
<body>
    <? if ($notification->isset()): ?>
        <div><?= $notification->message ?></div>
    <? endif; ?>

    <? require_once $innerViewPath; ?>
</body>
</html>
