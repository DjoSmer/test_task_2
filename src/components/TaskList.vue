<template>
    <div class="task-list-view">
        <div class="card" v-for="task in tasks" :key="task.task_id">
            <div class="card-header card-status1 task.status_id">
                {{ task.user_name }}({{ task.user_email }})
            </div>
            <div class="card-body">
                <blockquote class="blockquote mb-0">
                    <p>{{ task.task_text }}</p>
                    <footer class="blockquote-footer">
                        {{ task.status_name }} {{ task.task_create_at }}
                    </footer>
                </blockquote>
                <div class="text-right" v-if="false">
                    <a href="#" class="card-link" onclick="app.getTask('task_id');">Изменить</a>
                </div>
            </div>
        </div>

        <div v-if="!tasksCount()" class="task-no-record alert alert-success" role="alert">
            <h4 class="alert-heading">Список задач пуст</h4>
            <p>Сейчас задач нет. Зайдите к нам попозже, и они обязательно будут. Так же вы сами можете добавить свою задачу.</p>
        </div>
    </div>
</template>

<script>
    import { mapState } from 'vuex'

    export default {
        computed: mapState({
            tasks: function (state) {
                return state.tasks
            }
        }),

        created() {
            this.$store.dispatch('getTasks');
        },

        methods: {
            tasksCount() {
                return this.tasks.length;
            }
        }

    }
</script>