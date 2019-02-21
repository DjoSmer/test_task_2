<?php
if (isset($tasks) && count($tasks)):
    foreach ($tasks as $task):
?>
        <div class="card">
            <div class="card-header card-status<?php echo $task['status_id']; ?>"><?php echo sprintf('%s(%s)', $task['user_name'], $task['user_email']); ?></div>
            <div class="card-body">
                <blockquote class="blockquote mb-0">
                    <p><?php echo $task['task_text']; ?></p>
                    <footer class="blockquote-footer"><?php echo $task['status_name'] . ' ' . $task['task_create_at']; ?></footer>
                </blockquote>
<?php if($admin): ?>
                <div class="text-right">
                    <a href="#" class="card-link" onclick="app.getTask(<?php echo $task['task_id']; ?>);">Изменить</a>
                </div>
<?php endif; ?>
            </div>
        </div>

<?php
    endforeach;
else:
?>
    <div class="task-no-record alert alert-success" role="alert">
        <h4 class="alert-heading">Список задач пуст</h4>
        <p>Сейчас задач нет. Зайдите к нам попозже, и они обязательно будут. Так же вы сами можете добавить свою задачу.</p>
    </div>
<?php
endif;
?>
<script>
    var taskPageSetting = {
        totalCount: <?php echo $size;?>,
        pageSize: <?php echo count($tasks);?>
    };
</script>
