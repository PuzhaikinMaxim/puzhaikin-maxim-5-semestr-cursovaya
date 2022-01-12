<template>
    <div class="user-data-change-form">
        <input type="text" v-model="username" placeholder="Имя пользователя" class="main__change-user-data-input">
        <input type="text" v-model="email" placeholder="Электронная почта" class="main__change-user-data-input">
        <input type="password" v-model="old_password" placeholder="Старый пароль" class="main__change-user-data-input">
        <input type="password" v-model="new_password" placeholder="Новый пароль" class="main__change-user-data-input">
        <button v-on:click="changeUserData()" class="main__change-user-data-submit">Подтвердить изменения</button>
        <div v-if="is_successful">Данные были успешно изменены</div>
    </div>
</template>

<script>
export default {
    data(){
        return {
            email: '',
            username: '',
            old_password: '',
            new_password: '',
            is_successful: false
        }
    },
    methods: {
        changeUserData(){
            var email = this.email
            var username = this.username
            var old_password = this.old_password
            var new_password = this.new_password
            axios.post('/api/updateUserData', {email, username, old_password, new_password}).then(response=>{
                this.is_successful = true
            })
        }
    },
    created(){
        axios.get('/api/GetUser').then(response=>{
            this.email = response.data.email
            this.username = response.data.name
            console.log(response.data)
        })
    }
}
</script>

<style>

</style>