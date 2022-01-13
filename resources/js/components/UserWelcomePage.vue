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