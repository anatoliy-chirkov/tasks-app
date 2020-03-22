<?php
/**
 * @var $task array
 */
?>
<form action="/tasks/<?= $task['id'] ?>/edit" method="post">
    <input name="username" type="text" value="<?= $task['username'] ?>" disabled/>
    <input name="email" type="email" value="<?= $task['email'] ?>" disabled/>
    <input name="text" type="text" value="<?= $task['text'] ?>"/>
    <button type="submit">
        Save changes
    </button>
</form>
