<?php
/**
 * @var $title string
 * @var $description string
 * @var $content string
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

    <?= $content ?>
</body>
</html>
