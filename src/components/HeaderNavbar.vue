<template>
    <header class="navbar navbar-expand navbar-dark flex-column flex-md-row bg-dark">
        <a class="navbar-brand mr-0 mr-md-2" href="/">Задачник</a>

        <ul class="navbar-nav flex-row ml-md-auto d-none d-md-flex">
            <li class="nav-item">
                <a class="btn btn-primary" href="logout" v-if="auth">Выйти</a>
                <div class="dropdown dropleft" v-if="!auth">
                    <a class="nav-item nav-link mr-md-2" href="#" data-toggle="dropdown" @click="formAuthShow = !formAuthShow">Админ</a>
                    <transition name="fade">
                        <div class="auth-form-dropdown-menu dropdown-menu" v-if="formAuthShow" style="display: block">
                            <FormsAuth :formAuthShow="formAuthShow"/>
                        </div>
                    </transition>
                </div>
            </li>
        </ul>
    </header>
</template>

<script>
    import FormsAuth from './forms/Auth.vue'

    export default {
        data() {
            return {
                auth: false,
                formAuthShow: false
            }
        },
        components: { FormsAuth },

        methods: {
            toggle: function(){
                this.formAuthShow = !this.formAuthShow
            }
        }
    }
</script>

<style>
    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s;
    }
    .fade-enter, .fade-leave-to {
        opacity: 0;
    }
</style>