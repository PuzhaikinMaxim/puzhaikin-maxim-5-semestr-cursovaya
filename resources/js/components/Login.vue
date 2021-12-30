<template>
<div class="content">
    <div class="main">
        <div class="main__content">
            <h2 class="main__header">Вход</h2>
            <form class="login">
                <input type="text" v-model="form.email" placeholder="Электронная почта" class="login__input">
                <input type="password" v-model="form.password" placeholder="Пароль" class="login__input">
                <button @click.prevent="loginUser" type="submit" class="login__button">Войти</button>
                <div class="result-message result-message_red" v-if="isLogFailed">
                    Вы указали неверные данные для входа
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
                email: '',
                password: '',
            },
            errors:[],
            isLogFailed: false
        }
    },
    methods:{
        loginUser(){
            axios.post('/api/login', this.form).then(response=>{
                console.log(response.data.role_id)
                if(response.data.role_id === 1)
                    this.$router.push('/client/userWelcomePage')
                if(response.data.role_id === 2)
                    this.$router.push('/cleaner/cleanerMainPage')
                if(response.data.role_id === 3)
                    this.$router.push('/admin/registerCleaner')
            }).catch((error) => {
                this.isLogFailed = true;
            })
        }
    }
}
</script>

<style>
    .login__input {
        height: 40px;
        font-size: 20px;
        font-family: 'Montserrat';
        margin-top: 10px;
        border: 1px solid gray;
        background-color:snow;
        border-radius: 10px;
        transition: .5s;
    }

    .login__input:focus {
        outline: none;
        border: 2px solid blue;
    }

    .login__button {
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

    .main__header {
        padding-top: 75px;
        color: rgb(31, 48, 70);
        text-align: center;
        font-size: 40px;
        font-weight: 900;
    }

    .login__button:hover {
        width: 225px;
        height: 65px;
        font-size: 20px;
        color: midnightblue;
    }

    .login {
        display: flex;
        flex-direction: column;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
        padding-top: 50px;
    }
</style>