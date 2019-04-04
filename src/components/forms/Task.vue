<template>
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

            <div class="col">
                <select class="form-control" name="status">
                    <option value="1">status</option>
                </select>
            </div>

            <div class="col">
                <button id="taskFromBtnSend" class="btn btn-primary btn-block">Отправить</button>
            </div>
        </div>
        <div class="alert alert-success mt-3 mb-0" role="alert" style="display: none"></div>
        <div class="alert alert-danger mt-3 mb-0" role="alert" style="display: none"></div>
    </form>
</template>

<script>
    export default {}
</script>