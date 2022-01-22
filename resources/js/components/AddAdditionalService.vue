<template>
    <div>
        <div class="main">
            <div class="main__content">
                <h2 class="main__header">Изменение списка доп. услуг</h2>
                <div class="main__add-service-form">
                    <input type="text" class="main__service-name-input" v-model="form.service_name" placeholder="Название услуги">
                    <label class="main__service-price-label">Стоимость услуги: 
                        <input class="main__service-price" type="number" v-model="form.service_cost" placeholder="Стоимость услуги" min="250" max="10000">
                    </label>
                    <button class="main__service-add-button" @click.prevent="addService()" type="submit">Добавить услугу</button>
                    <div class="result-message result-message_red" v-if="isAddFailed">
                        Вы указали неверные данные для добавления в таблицу
                    </div>
                </div>
                <div class="main__cards">
                    <div v-for="service in additionalServices" v-bind:key="service.service_name" class="main__service-card">
                        <div class="main__service-name">{{service.service_name}}</div>
                        <label class="main__service-cost-label">Стоимость услуги: 
                        <input type="number" v-model="service.service_cost" placeholder="Стоимость услуги" min="250" max="10000">
                        </label>
                        <button class="main__service-card-button" v-on:click="updateService(service)">Изменить стоимость услуги</button>
                        <button class="main__service-card-button" v-on:click="deleteService(service)">Удалить услугу</button>
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
            additionalServices: [],
            form:{
                service_name: "",
                service_cost: 0
            },
            isAddFailed: false
        }
    },
    methods:{
        deleteService(service){
            axios.post('/api/deleteService',service).then(response=>{
                for(var i = 0; i < this.additionalServices.length; i++){
                    if(this.additionalServices[i].service_name === service.service_name){
                        this.additionalServices.splice(i,1);
                    }
                }
                alert("Услуга была удалена")
            }).catch((error) => {

            })
        },
        updateService(service){
            axios.post('/api/updateService',service).then(response=>{
                alert("Цена была изменена")
            }).catch((error) => {
                alert("Ошибка в изменении цены")
            })
        },
        addService(){
            axios.post('/api/addService', this.form).then(response=>{
                this.additionalServices.push({service_name: this.form.service_name, 
                service_cost: this.form.service_cost})
                this.form.service_name = "",
                this.form.service_cost = 0
                this.isAddFailed = false;
                alert("Услуга была добавлена")
            }).catch((error) => {
                this.isAddFailed = true;
                setTimeout(()=>this.isAddFailed = false,2000)
            })
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
        axios.get('/api/additionalServices').then(response=>{
            this.additionalServices = response.data;
        }).catch((error) => {

        })
    }
}
</script>

<style>
    .main__service-card {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        width: 400px;
        background-color: lightseagreen;
        padding: 10px;
        align-items: center;
        border-radius: 25px;
        color: whitesmoke;
        min-height: 225px;
        margin-left: auto;
        margin-right: auto
    }

    .main__cards {
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    }

    .main__service-name {
        font-size: 24px;
        font-weight: 700;
        text-align: center;
        overflow-wrap: break-word;
        max-width: 100%;
    }

    .main__service-price-label {
        display: flex;
        max-width: 300px;
        justify-content: space-between;
        margin-top: 20px;
        align-items: center;
        font-size: 20px;
    }

    .main__service-add-button {
        height: 40px;
        border: none;
        font-size: 20px;
        font-family: 'Montserrat';
        border-radius: 20px;
        margin-top: 20px;
        background-color: slateblue;
        color: whitesmoke;
    }

    .main__service-name-input {
        border: none;
        height: 40px;
        font-size: 18px;
        font-family: 'Montserrat';
        border: 2px solid slateblue;
        border-radius: 20px;
        transition: .25s;
    }

    .main__service-name-input:focus {
        outline: none;
        border: 4px solid blue;
    }

    .main__add-service-form {
        margin-top: 25px;
        display: flex;
        flex-direction: column;
        padding: 15px;
        border: 2px solid slateblue;
        max-width: 400px;
        border-radius: 30px;
        margin-right: auto;
        margin-left: auto;
    }

    .main__service-cost-label {
        display: flex;
        align-items: center;
        font-size: 20px;
        width: 310px;
        justify-content: space-between;
    }

    .main__service-card-button {
        color: whitesmoke;
        background-color: slateblue;
        border: none;
        border-radius: 15px;
        width: 300px;
        height: 40px;
        font-size: 18px;
        font-family: 'Montserrat';
    }

    @media (max-width: 891px) {
        .main__cards {
            display: flex;
            justify-content: space-between;
            flex-direction: column;
            align-items: center;
        }

        .main__service-card {
            width: 100%;
        }
    }
</style>