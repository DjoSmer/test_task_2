<section class="task-new container-fluid py-3">
    <form id="taskForm" class="task-new-form">
        <input type="hidden" name="id" value="0"/>
        <div class="form-row">
            <div class="col">
                <input type="text" class="form-control" name="name" placeholder="Ваше Имя" minlength="4" required/>
            </div>
            <div class="col">
                <input type="email" class="form-control" name="email" placeholder="Ваш email" required/>
            </div>
        </div>
        <div class="form-group mt-3">
            <textarea class="form-control" rows="3" name="text" placeholder="Ваша задача" required></textarea>
        </div>
        <div class="form-row mt-3">
<?php if($admin): ?>
            <div class="col">
                <select class="form-control" name="status">
<?php foreach($statuses as $status): ?>
                    <option value="<?php echo $status['id']; ?>"><?php echo $status['name']; ?></option>
<?php endforeach; ?>
                </select>
            </div>
<?php endif; ?>
            <div class="col">
                <button id="taskFromBtnSend" class="btn btn-primary btn-block">Отправить</button>
            </div>
        </div>
        <div class="alert alert-success mt-3 mb-0" role="alert" style="display: none"></div>
        <div class="alert alert-danger mt-3 mb-0" role="alert" style="display: none"></div>
    </form>
</section>
<section class="task-list container py-3">
    <div class="task-list-sort row mb-3">
        <div class="col">
            <label for="taskSortName">Сортировать по </label>
            <select id="taskSortColumn" class="form-control">
                <option value="create">Добавления</option>
                <option value="name">Имени</option>
                <option value="email">Email</option>
                <option value="status">Cтатусу</option>
            </select>
            <select id="taskSortDirection" class="form-control">
                <option value="asc">возрастанию</option>
                <option value="desc" selected>убыванию</option>
            </select>
        </div>
    </div>
    <div class="task-list-view"></div>
    <nav class="task-list-page" aria-label="Page navigation"></nav>
</section>