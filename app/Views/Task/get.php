<?php
/**
 * @var $tasks array
 * @var $page int
 * @var $pages int
 * @var $sortBy string
 * @var $isAuthorized bool
 */

/**
 * @param string $sortBy
 * @param string $fieldName
 * @return string
 */
function getSortBy(string $sortBy, string $fieldName) {
    return strpos($sortBy, $fieldName) === false || strpos($sortBy, '-') !== false
        ? $fieldName
        : '-' . $fieldName
    ;
}

?>
<script>
    function sendComplete(object) {
        const request = new XMLHttpRequest();
        request.open('PATCH', `/tasks/${object.dataset.taskId}/set-complete`);
        request.setRequestHeader('Content-Type', 'application/json');
        request.send(JSON.stringify({isComplete: object.value}));
    }
</script>
<div style="margin-bottom: 30px">
    <a class="button" href="/create-task">Create task</a>
</div>
<table class="table">
    <thead>
        <tr>
            <th><a href="?page=<?=$page?>&sortBy=<?=getSortBy($sortBy, 'id')?>">Number</a></th>
            <th><a href="?page=<?=$page?>&sortBy=<?=getSortBy($sortBy, 'username')?>">Username</a></th>
            <th><a href="?page=<?=$page?>&sortBy=<?=getSortBy($sortBy, 'email')?>">Email</a></th>
            <th><a href="?page=<?=$page?>&sortBy=<?=getSortBy($sortBy, 'text')?>">Text</a></th>
            <th><a href="?page=<?=$page?>&sortBy=<?=getSortBy($sortBy, 'status')?>">Status</a></th>
            <?= $isAuthorized ? "<th>Action</th>" : '' ?>
        </tr>
    </thead>
    <tbody>
        <? foreach ($tasks as $task): ?>
        <tr>
            <td><?= $task['id'] ?></td>
            <td><?= $task['username'] ?></td>
            <td><?= $task['email'] ?></td>
            <td>
                <?= $task['text'] ?>
                <br/>
                <span class="excerpt"><?= $task['isEdited'] ? '* Edited by administrator' : '' ?></span>
            </td>
            <td>
                <? if (!$isAuthorized): ?>
                    <?= $task['isCompleted'] ? 'Completed' : 'Await' ?>
                <? else: ?>
                    <select class="task-status" data-task-id="<?=$task['id']?>" onchange="sendComplete(this)">
                        <option value="0" <?= $task['isCompleted'] ? '' : 'selected' ?>>Await</option>
                        <option value="1" <?= $task['isCompleted'] ? 'selected' : '' ?>>Completed</option>
                    </select>
                <? endif; ?>
            </td>
            <?= $isAuthorized ? "<td><a class='button' href='/tasks/{$task['id']}/edit'>Edit</a></td>" : '' ?>
        </tr>
        <? endforeach; ?>
    </tbody>
</table>
<div class="btn-toolbar" role="toolbar" >
    <div class="btn-group mr-2" role="group" >
        <? for($i = 1; $i <= $pages; $i++): ?>
            <? if ($i != $page): ?>
                <a class="page-button" href="?page=<?=$i?>&sortBy=<?=$sortBy?>"><?=$i?></a>
            <? else: ?>
                <div class="page-button active"><?=$page?></div>
            <? endif; ?>
        <? endfor; ?>

    </div>
</div>
