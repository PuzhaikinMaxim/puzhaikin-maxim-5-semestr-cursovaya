<template>
    <div class="data-change-form">
        <div class="data-change-form__content">
            <div class="data-change-form__title">Имя пользователя</div>
            <input type="text" v-model="username" placeholder="Имя пользователя" class="data-change-form__change-data-input">
            <div class="data-change-form__title">Электронная почта</div>
            <input type="text" v-model="email" placeholder="Электронная почта" class="data-change-form__change-data-input">
            <button v-on:click="changeUserData()" class="data-change-form__change-data-submit">Изменить данные</button>
            <div v-if="show_message" class="data-change-form__message">{{message}}</div>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return {
            email: '',
            username: '',
            show_message: false,
            message: 'Данные были успешно изменены'
        }
    },
    methods: {
        changeUserData(){
            var email = this.email
            var username = this.username
            if(email != '' && username != ''){
                axios.post('/api/updateUserData', {email, username}).then(response=>{
                    this.message = 'Данные были успешно изменены'
                    this.show_message = true
                    setTimeout(() => this.show_message = false,2000)
                }).catch((error) => {
                    this.message = 'Данные не были изменены'
                    this.show_message = true
                    setTimeout(() => this.show_message = false,2000)
                })
            }
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
    .data-change-form {
        display: flex;
        justify-content: center;
        padding-top: 30px;
    }

    .data-change-form__content {
        display: flex;
        flex-direction: column;
        background-color: cornflowerblue;
        max-width: 600px;
        padding-left: 15px;
        padding-right: 15px;
        padding-bottom: 15px;
        border-radius: 15px;
        flex: 1;
    }

    .data-change-form__change-data-input {
        border: none;
        height: 40px;
        font-size: 16px;
        font-family: 'Montserrat';
        border: 2px solid slateblue;
        border-radius: 20px;
        transition: .25s;
        margin-top: 10px;
    }

    .data-change-form__change-data-input:focus {
        outline: none;
        border: 3px solid blue;
    }

    .data-change-form__change-data-submit {
        height: 40px;
        border: none;
        font-size: 20px;
        font-family: 'Montserrat';
        border-radius: 20px;
        margin-top: 30px;
        background-color: slateblue;
        color: whitesmoke;
    }

    .data-change-form__title {
        font-size: 24px;
        margin-top: 30px;
        font-weight: 700;
    }

    .data-change-form__message {
        text-align: center;
        font-size: 22px;
        color: white;
        margin-top: 15px;
    }

    @media print {
        .data-change-form {
            display: none;
        }
    }
</style>