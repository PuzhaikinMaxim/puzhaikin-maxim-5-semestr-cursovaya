<template>
    <div>
        <div class="main">
            <div class="main__content">
                <h2 class="main__header">Зарегистрировать уборщика</h2>
                <div class="main__add-cleaner-form">
                    <input type="text" v-model="form.name" placeholder="ФИО уборщика" class="main__add-cleaner-input">
                    <input type="text" v-model="form.email" placeholder="Электронная почта" class="main__add-cleaner-input">
                    <input type="password" v-model="form.password" placeholder="Пароль" class="main__add-cleaner-input">
                    <input type="password" v-model="form.password_confirm" placeholder="Подтверждение пароля" class="main__add-cleaner-input">
                    <button @click.prevent="addUser()" type="submit" class="main__add-cleaner-submit">Зарегистрировать</button>
                    <div class="result-message result-message_red" v-if="isCleanerRegFailed">
                        Вы указали неверные данные для добавления уборщика в систему
                    </div>
                </div>
                <div class="main__cards">
                    <div v-for="cleaner in cleaners" v-bind:key="cleaner.id" class="main__user-cleaner-card">
                        <div class="main__user-cleaner-info">ФИО уборщика: {{cleaner.name}}</div>
                        <div class="main__user-cleaner-info">Почта уборщика: {{cleaner.email}}</div>
                        <div class="main__user-cleaner-info">Средняя оценка уборщика: {{cleaner.rating}}</div>
                        <div class="main__user-cleaner-info">Количество оценок: {{cleaner.reviews_amount}}</div>
                        <button v-on:click="deleteAccount(cleaner)" class="main__delete-cleaner">Удалить аккаунт</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return{
            cleaners: [],
            form:{
                name: '',
                email: '',
                password: '',
                password_confirm: ''
            },
            isCleanerRegFailed: false
        }
    },
    methods:{
        deleteAccount(cleaner){
            axios.post('/api/deleteCleanerAccount',cleaner).then(response=>{
                for(var i = 0; i < this.cleaners.length; i++){
                    if(this.cleaners[i].id === cleaner.id){
                        this.cleaners.splice(i,1);
                    }
                }
                alert('Данные об уборщике были удалены')
            }).catch((error) => {

            })
        },
        addUser(){
            if(this.form.password === this.form.password_confirm) {
                axios.post('/api/registrateCleaner', this.form).then(response=>{
                    axios.get('/api/getAllCleaners').then(response=>{
                        this.cleaners = response.data;
                        this.form.name = '';
                        this.form.email = '';
                        this.form.password = '';
                        this.form.password_confirm = '';
                        this.isCleanerRegFailed = false;
                        alert('Уборщик был добавлен в систему')
                    }).catch((error) => {

                    })
                }).catch((error) => {
                    this.isCleanerRegFailed = true;
                    setTimeout(()=>this.isCleanerRegFailed = false,2000)
                })
            }
            else {
                this.isCleanerRegFailed = true;
                setTimeout(()=>this.isCleanerRegFailed = false,2000)
            }
        },
        logout() {
            axios.post('/api/logout').then(response=>{
                localStorage.removeItem('UserData')
                this.$router.push('/')
        }).catch((error) => {

        })
        },
    },
    created() {
        //console.log(JSON.parse(localStorage.getItem('UserData')))
        axios.get('/api/getAllCleaners').then(response=>{
            this.cleaners = response.data;
        }).catch((error) => {

        })
    }
}
</script>

<style>
    .main__add-cleaner-form {
        margin-top: 25px;
        display: flex;
        flex-direction: column;
        padding: 20px;
        border: 2px solid slateblue;
        max-width: 500px;
        border-radius: 30px;
        margin-right: auto;
        margin-left: auto;
    }

    .main__cards {
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    }

    .main__add-cleaner-input {
        border: none;
        height: 40px;
        font-size: 16px;
        font-family: 'Montserrat';
        border: 2px solid slateblue;
        border-radius: 20px;
        transition: .25s;
        margin-top: 15px;
    }

    .main__delete-cleaner {
        height: 40px;
        border: none;
        font-size: 20px;
        font-family: 'Montserrat';
        border-radius: 20px;
        margin-top: auto;
        background-color: slateblue;
        color: whitesmoke;
        width: 100%;
    }

    .main__user-cleaner-card {
        background-color: lightseagreen;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        overflow-wrap: break-word;
        color: whitesmoke;
        padding: 15px;
        width: 400px;
        min-height: 250px;
        border-radius: 25px;
        margin-left: auto;
        margin-right: auto;
    }

    .main__user-cleaner-info {
        margin-top: 15px;
        min-height: 34px;
        font-size: 18px;
    }

    .main__add-cleaner-submit {
        height: 40px;
        border: none;
        font-size: 20px;
        font-family: 'Montserrat';
        border-radius: 20px;
        margin-top: 20px;
        background-color: slateblue;
        color: whitesmoke;
    }

    .main__add-cleaner-input:focus {
        outline: none;
        border: 3px solid blue;
    }

    @media (max-width: 891px) {
        .main__cards {
            display: flex;
            justify-content: space-between;
            flex-direction: column;
            align-items: center;
        }

        .main__user-cleaner-card {
            width: 100%;
        }
    }
</style>