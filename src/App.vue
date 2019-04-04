<template>
    <div>
        <HeaderNavbar/>
        <BodyContent/>
    </div>
</template>

<script>
    import HeaderNavbar from './components/HeaderNavbar.vue'
    import BodyContent from './components/BodyContent.vue'

    export default {
        components: {
            HeaderNavbar,
            BodyContent
        },
    }
</script>