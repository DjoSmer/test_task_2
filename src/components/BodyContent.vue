<template>
    <main>
        <section class="task-new container-fluid py-3">
            <FormsTask/>
        </section>
        <section class="task-list container py-3">
            <div class="task-list-sort row mb-3">
                <div class="col">
                    <label for="taskSortColumn">Сортировать по</label>
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
            <TaskList/>
            <nav class="task-list-page" aria-label="Page navigation"></nav>
        </section>
        <div class="ajax-modal" style1="display: block">
            <div class="ajax-running"></div>
        </div>
    </main>
</template>

<script>
    import FormsTask from './forms/Task.vue'
    import TaskList from './TaskList.vue'

    export default {
        components: {
            FormsTask, TaskList
        }
    }
</script>