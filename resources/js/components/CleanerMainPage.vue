<template>
<div class="content">
    <div class="main">
        <div class="main__content">
            <h2 class="main__header">Заказы клиентов</h2>
            <div v-if="isDontHaveOrders">У вас нет активных заказов</div>
            <div class="main__cards">
                <div v-for="order in orders" v-bind:key="order.id" class="main__order-card">
                    <div class="main__order-info-item">Имя заказчика: {{order.name}}</div>
                    <div class="main__order-info-item">Мобильный телефон заказчика: {{order.phone_number}}</div>
                    <div class="main__order-info-item">Адрес заказчика: {{order.address}}</div>
                    <div class="main__order-info-item">Доп. услуги: {{order.additional_services}}</div>
                    <div class="main__order-info-item">Количество комнат: {{order.rooms_amount}}</div>
                    <div class="main__order-info-item">Дата заказа: {{order.order_date_time}}</div>
                    <button v-on:click="deleteOrder(order)" class="main__order-card-button">Заказ выполнен</button>
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
            orders:[],
            errors:[],
            isDontHaveOrders:false
        }
    },
    methods:{
        deleteOrder(order) {
            axios.delete('/api/deleteActiveOrder', {params: {id: order.id}}).then(response=>{
                axios.put('/api/addActiveReview', order).then(response=>{
                    this.deleteElem(order.id)
                }).catch((error) => {

                })
            }).catch((error) => {

            })
        },
        deleteElem(id){
            for(var i = 0; i < this.orders.length; i++){
                console.log(id)
                console.log(parseInt(this.orders[i].id))
                if(id === parseInt(this.orders[i].id)){
                    this.orders.splice(i,1);
                }
            }
            if(this.orders.length == 0)
                this.isDontHaveOrders = true;
        }
    },
    created() {
        axios.post('/api/getCleanerOrders', JSON.parse(localStorage.getItem('UserData'))).then(response=>{
            this.orders = response.data;
            if(this.orders.length == 0)
                this.isDontHaveOrders = true;
            console.log(this.orders)
        }).catch((error) => {

        })
    }
}
</script>