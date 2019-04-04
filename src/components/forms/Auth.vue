<template>
    <form class="px-4 py-3" autocomplete="off">
        <div class="form-group">
            <h5 class="card-title">Вход для персонала</h5>
        </div>
        <div class="form-group">
            <input class="form-control" v-model.trim="login" placeholder="логин">
        </div>
        <div class="form-group">
            <input type="password" class="form-control" v-model="password" placeholder="Пароль">
        </div>
        <button type="button" @click="signIn" class="btn btn-primary">Войти</button>
    </form>
</template>

<script>
    export default {
        data() {
            return {
                login: '',
                password:''
            }
        },
        methods: {
            signIn: function () {
                alert('sign In')
            }
        }
    }
</script>