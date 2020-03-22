<?php
/**
 * @var $tasks array
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
            <?= $task['isEdited'] ?? '* Edited by administrator' ?>
        </td>
        <td><?= $task['isCompleted'] ? 'Completed' : 'Await' ?></td>
    </tr>
    <? endforeach; ?>
</table>
