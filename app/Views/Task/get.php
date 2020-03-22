<?php
/**
 * @var $tasks array
 * @var $isAuthorized bool
 * @var $page int
 * @var $pages int
 */
?>
<table>
    <tr>
        <th>Number</th>
        <th>Username</th>
        <th>Email</th>
        <th>Text</th>
        <th>Status</th>
    </tr>
    <? foreach ($tasks as $task): ?>
    <tr>
        <td><?= $task['id'] ?></td>
        <td><?= $task['username'] ?></td>
        <td><?= $task['email'] ?></td>
        <td>
            <?= $task['text'] ?>
            <br/>
            <?= $task['isEdited'] ? '* Edited by administrator' : '' ?>
        </td>
        <td><?= $task['isCompleted'] ? 'Completed' : 'Await' ?></td>
    </tr>
    <? endforeach; ?>
</table>

<div>
    <? for($i = 1; $i <= $pages; $i++): ?>
        <? if ($i != $page): ?>
            <a href="?page=<?=$i?>"><?=$i?></a>
        <? else: ?>
            <div><?=$page?></div>
        <? endif; ?>
    <? endfor; ?>
</div>

<div>
    <a href="/create-task">Create task</a>
</div>

<? if (!$isAuthorized): ?>
    <div>
        <a href="/Login">Login</a>
    </div>
<? else: ?>
    <div>
        <form method="post" action="/logout">
            <button type="submit">Logout</button>
        </form>
    </div>
<? endif; ?>
