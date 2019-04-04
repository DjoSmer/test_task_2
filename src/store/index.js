import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'
//import cart from './modules/cart'
//import products from './modules/products'

Vue.use(Vuex)

const debug = process.env.NODE_ENV !== 'production'

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

export default new Vuex.Store({
    state: {
        tasks: [],
        auth: false,
        currentTask: {
            userName: null,
            userEmail: null,
            taskId: null,
            taskText: null,
            taskStatus: 1
        }
    },

    actions: {
        create(state, userName, userEmail, taskText, taskStatus) {
            state.currentTask.userName = userName
            state.currentTask.userEmail = userEmail
            state.currentTask.taskText = taskText
            state.currentTask.taskStatus = taskStatus
            state.commit('createTask');
        },
        createTask(state, userName, userEmail, taskText, taskStatus) {
            const currentTask = {
                userName: userName,
                userEmail: userEmail,
                taskText: taskText,
                taskStatus: taskStatus
            }
            axios.post('task/create', currentTask)
                .then(response => {
                    state.commit('ADD_TASK', response.task);
                })
                .catch(error => {
                    console.log(error);
                })
                .finally(() => (console.log(this, arguments)));
        },
        getTasks(state) {
            axios.post('task/list-json')
                .then(response => {
                    state.commit('SET_TASKS', response.data.tasks);
                })
                .catch(error => {
                    console.log(error);
                })
                .finally(() => (console.log(this, arguments)));
        },

        signIn({ commit }, login, password) {
            axios.post('/login', { login, password })
            .then()
        }
    },

    mutations: {
        ADD_TASK(state, task) {
            state.tasks.push(task)
        },

        SET_TASKS(state, tasks) {
            state.tasks = tasks
        },

        SIGN_IN({ auth }, status) {
            auth = status
        }
    },

    strict: debug
})