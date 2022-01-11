<template>
    
</template>

<script>
export default {
    props: ['user'],
    data(){
        return {
            email: '',
            username: ''
        }
    },
    methods: {

    },
    created(){
        this.email = user.email
        this.username = user.name
    }
}
</script>

<style>

</style>