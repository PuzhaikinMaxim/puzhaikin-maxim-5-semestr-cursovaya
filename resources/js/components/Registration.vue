<template>
<div class="content">
    <div class="main">
        <div class="main__content">
            <h2 class="main__header">Регистрация</h2>
            <form class="registration">
                <input type="text" v-model="form.name" placeholder="Имя пользователя" class="registration__input">
                <input type="text" v-model="form.email" placeholder="Электронная почта" class="registration__input">
                <input type="password" v-model="form.password" placeholder="Пароль" class="registration__input">
                <input type="password" v-model="form.password_confirm" placeholder="Подтверждение пароля" class="registration__input">
                <button @click.prevent="addUser" type="submit" class="registration__button">Зарегистрироватся</button>
                <div class="result-message result-message_green" v-if="isRegSuccess">
                    Вы успешно зарегистрировались
                </div>
                <div class="result-message result-message_red" v-if="isRegFailed">
                    Вы указали неверные данные для регистрации
                </div>
            </form>
        </div>
    </div>
</div>
</template>

<script>
export default {
    data(){
        return{
            form:{
                name: '',
                email: '',
                password: '',
                password_confirm: ''
            },
            isRegFailed: false,
            isRegSuccess: false,
            errors:[]
        }
    },
    methods:{
        addUser(){
            if(this.form.password === this.form.password_confirm) {
                axios.post('/api/registrate', this.form).then(response=>{
                    this.form.name = "";
                    this.form.email = "";
                    this.form.password = "";
                    this.form.password_confirm = "";
                    this.isRegSuccess = true;
                    this.isRegFailed = false;
                }).catch((error) => {
                    this.isRegFailed = true;
                    this.isRegSuccess = false;
                })
            }
            else {
                this.isRegFailed = true;
                this.isRegSuccess = false;
            }
        }
    }
}
</script>

<style>
    .registration__input {
        height: 40px;
        font-size: 20px;
        font-family: 'Montserrat';
        margin-top: 10px;
        border: 1px solid gray;
        background-color:snow;
        border-radius: 10px;
        transition: .5s;
    }

    .registration__input:focus {
        outline: none;
        border: 2px solid blue;
    }

    .registration__button {
        height: 50px;
        width: 200px;
        margin-left: auto;
        margin-right: auto;
        margin-top: 25px;
        border-radius: 15px;
        border-style: none;
        background-color: springgreen;
        font-family: 'Montserrat';
        font-size: 16px;
        color: rgb(73, 73, 73);
        font-weight: 600;
        transition: .5s;
    }

    .result-message {
        font-size: 18px;
        height: 40px;
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
    }

    .result-message_green {
        color: green;
    }

    .result-message_red {
        color: red;
    }

    .registration__button:hover {
        width: 225px;
        height: 65px;
        font-size: 20px;
        color: midnightblue;
    }

    .registration {
        display: flex;
        flex-direction: column;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
        padding-top: 50px;
    }
</style>