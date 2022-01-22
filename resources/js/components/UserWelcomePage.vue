<template>
<div>
    <div class="main">
        <div class="main__content">
            <ChangeUserDataForm></ChangeUserDataForm>
            <h2 class="main__header">Активные заказы</h2>
            <div class="main__hidden-message" v-if="isHaveActiveOrders">У вас нет активных заказов</div>
            <div class="main__cards">
                <div v-for="order in orders" v-bind:key="order.id" class="main__order-card">
                    <div class="main__order-info-item">ФИО уборщика: {{order.name}}</div>
                    <div class="main__order-info-item">Дата и время уборки: {{order.order_date_time}}</div>
                    <div class="main__order-info-item">Количество комнат: {{order.rooms_amount}}</div>
                    <div class="main__order-info-item">Дополнительные услуги: {{order.additional_services}}</div>
                    <div class="main__order-info-item">Адрес: {{order.address}}</div>
                    <div class="main__order-info-item">Итого: {{order.total_price}}</div>
                    <button class="main__order-card-button" v-on:click="cancelOrder(order)">Отменить заказ</button>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import ChangeUserDataForm from './ChangeUserDataComponent.vue'
export default {
    components: {
        ChangeUserDataForm
    },
    data(){
        return{
            errors:[],
            orders:[],
            isHaveActiveOrders: false
        }
    },
    methods:{
        cancelOrder(order){
            console.log(order);
            axios.post('/api/deleteActiveOrder',order).then(response=>{
                for(var i = 0; i < this.orders.length; i++){
                    if(this.orders[i].id === order.id)
                        this.orders.splice(i,1);
                }
                if(this.orders.length == 0)
                    this.isHaveActiveOrders = true;
                alert('Заказ был успешно отменен')
            }).catch((error) => {

            })
        }
    },
    created() {
        //console.log(JSON.parse(localStorage.getItem('UserData')))
        axios.post('/api/getOrders', JSON.parse(localStorage.getItem('UserData'))).then(response=>{
            this.orders = response.data;
            console.log(this.orders);
            if(this.orders.length == 0)
                this.isHaveActiveOrders = true;
            this.msg = 'dsdsdsdsdsddsbbbbbbbbbbbb'
        }).catch((error) => {

        })
    }
}
</script>

<style>
    .main__order-card {
        padding: 15px;
        background-color: lightseagreen;
        width: 400px;
        border-radius: 25px;
        margin-left: auto;
        margin-right: auto;
    }

    .main__cards {
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    }

    .main__order-info-item {
        margin-top: 15px;
        color: whitesmoke;
        font-size: 18px;
        font-weight: 600;
        overflow-wrap: break-word;
        width: 100%;
    }

    .main__order-card-button {
        margin-top: 20px;
        color: whitesmoke;
        background-color: rebeccapurple;
        border: none;
        width: 200px;
        height: 50px;
        border-radius: 25px;
        font-family: 'Montserrat';
        font-size: 18px;
        transition: .5s;
    }

    .main__hidden-message {
        color: rgb(83, 83, 83);
        font-size: 20px;
        margin-top: 20px;
    }

    .main__order-card-button:hover {
        width: 225px;
        height: 60px;
        font-size: 20px;
    }

    @media (max-width: 891px) {
        .main__cards {
            display: flex;
            justify-content: space-between;
            flex-direction: column;
            align-items: center;
        }
    }

    @media print {
        @page :first { 
            margin: 1cm; 
        }

        @page :left { 
            margin: 1cm 3cm 1cm 1.5cm;
        }

        .footer {
            display: none !important;
        }

        .header {
            display: none !important;
        }

        div { 
            page-break-inside: avoid;
            widows: 4;
            font-size: 1.15em;
            text-align: left;
            orphans: 1;
        }

        a[href]:after {
            content: " (" attr(href) ")";
        }

        .main {
            max-width: none;
        }

        .page {
            page-break-after: always;
        }

        @page { 
            size: A4;
            margin: 1cm;
        }

        .main__order-card-button {
            display: none;
        }

        .main__order-info-item {
            page-break-inside: avoid;
            page-break-after: avoid;
        }

        .main__order-info-item {
            font-family: 'Times New Roman', Times, serif;
            font-weight: 500;
            color: black;
            font-size: 22px;
        }

        body{
            background: none;
        }

        .main__cards {
            padding-top: 5px !important;
            width: 450px;
        }

        .main__header {
            font-size: 26px;
            font-weight: 700;
            font-family: 'Times New Roman', Times, serif;
        }

        .main__header + .main__order-info-item {
            page-break-before: avoid;
            page-break-inside: avoid;
        }
    }
</style>