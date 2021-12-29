<template>
    <div>
    <div class="main">
        <div class="main__content">
            <h2 class="main__header">Сделать заказ</h2>
            <div v-if="isShowWindowOpened" class="modal">
                <div class="modal__content">
                    <div class="modal__order-inner">
                        <button class="modal__exit modal__exit_center" v-on:click="isShowWindowOpened = false">×</button>
                        <label class="modal__select-label">Количество комнат: 
                        <select v-model="cur_rooms_amount" v-on:change="recountTotal()" class="modal__select">
                            <option v-for="amount in rooms_amount" v-bind:value="amount.value" v-bind:key="amount.value">
                                {{amount.text}}
                            </option>
                        </select>
                        </label>
                        <label class="modal__select-label">Месяц: 
                        <select v-model="cur_month" v-on:change="selectMonth()" class="modal__select">
                            <option v-for="month in months" v-bind:value="month.value" v-bind:key="month.value" >
                                {{month.text}}
                            </option>
                        </select>
                        </label>
                        <label class="modal__select-label">День: 
                        <select v-model="cur_day" v-on:change="validate()" class="modal__select">
                            <option v-for="day in days" v-bind:value="day" v-bind:key="day">
                                {{day}}
                            </option>
                        </select>
                        </label>
                        <label class="modal__select-label">Час: 
                        <select v-model="cur_hour" v-on:change="validate()" class="modal__select">
                            <option v-for="hour in hours" v-bind:value="hour.value" v-bind:key="hour.value">
                                {{hour.value}}
                            </option>
                        </select>
                        </label>
                        <div class="modal__additional-services-header">Дополнительные услуги:</div>
                        <label v-for="service in additional_services" class="modal__additional-services-label" v-bind:key="service.service_name">
                        <input type="checkbox" v-model="services_picked" class="modal__additional-services-checkbox" v-bind:value="service" v-on:change="recountTotal()">
                        {{service.service_name}} - {{service.service_cost}} рублей
                        </label>
                        <input type="text" v-model="phone_num" placeholder="Номер телефона без 8" @keypress="isNumber($event)" v-on:change="validate()" class="modal__input-field">
                        <input type="text" v-model="address" placeholder="Адрес" v-on:change="validate()" class="modal__input-field">
                        <div class="modal__total-price">Итого: {{total}}</div>
                        <button class="modal__make-order-button" v-if="isValid" v-on:click="makeOrder()">Сделать заказ</button>
                    </div>
                </div>
            </div>
            <div v-if="isShowComments" class="modal">
                <div class="modal__content">
                    <div class="modal__controls">
                        <div class="modal__search-container">
                            <input type="text" v-model="search_text" class="modal__input-text">
                            <button v-on:click="findReviews" class="modal__button">Найти</button>
                        </div>
                        <button class="modal__exit" v-on:click="isShowComments = false">×</button>
                    </div>
                    <div v-for="review in curComments" v-bind:key="review.id" class="modal__cleaner-review">
                        <div class="modal__reviewer-name">Имя пользователя: {{review.name}}</div>
                        <div class="modal__review-title">{{review.review_title}}</div>
                        <div class="modal__review-text">{{review.review_text}}</div>
                        <div  class="modal__review-rating">Оценка: {{review.rating}}</div>
                    </div>
                </div>
            </div>
            <!--<div class="hint">Укажите минимальную и максимальную оценку для того, чтобы подобрать подходящего вам уборщика</div>-->
            <label class="main__rating-input">Минимальная оценка: <input type="number" class="main__input-mark" :max="max_val" min="1" v-model="min_val" @change="filterCleanerInfo"></label>
            <label class="main__rating-input">Максимальная оценка: <input type="number" class="main__input-mark" :min="min_val" max="5" v-model="max_val" @change="filterCleanerInfo"></label>
            <div class="main__cards">
                <div v-for="cleanerInfo in curCleanerInfos" :key="cleanerInfo.id" class="main__cleaner-card">
                    <div class="main__card-text">ФИО Уборщика: {{cleanerInfo.cleaner_name}}</div>
                    <div class="main__card-text">Средняя оценка: {{cleanerInfo.rating}}</div>
                    <div class="main__card-text">Количество отзывов: {{cleanerInfo.reviews_amount}}</div>
                    <button v-on:click="showComments(cleanerInfo)" class="main__card-button">Показать комментарии</button>
                    <button v-on:click="openOrderWindow(cleanerInfo)" class="main__card-button">Выбрать уборщика</button>
                </div>
            </div>
        </div>
    </div>
    </div>
</template>

<style>
    .main__cleaner-card{
        display: flex;
        flex-direction: column;
        min-height: 195px;
        justify-content: space-between;
        max-width: 400px;
        background-color: lightseagreen;
        padding: 10px;
        align-items: center;
        border-radius: 25px;
    }

    .modal__controls {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal__exit_center {
        margin: 0 auto;
    }

    .main__card-text {
        color: whitesmoke;
        font-size: 16px;
        font-weight: 600;
    }

    .modal__total-price {
        margin-top: 10px;
        font-size: 26px;
        font-weight: 800;
        margin-top: 15px;
    }

    .modal__make-order-button {
        height: 50px;
        border-radius: 25px;
        font-family: 'Montserrat';
        font-size: 22px;
        font-weight: 600;
        border: none;
        background-color: slateblue;
        color: whitesmoke;
        margin-top: 20px;
    }

    .modal__additional-services-header {
        margin-top: 15px;
        font-size: 22px;
        font-weight: 700;
    }

    .modal__select-label {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 300px;
        margin-top: 25px;
        font-size: 20px;
    }

    .modal__additional-services-label {
        display: flex;
        align-items: center;
        font-size: 20px;
        margin-top: 10px;
    }

    .modal__additional-services-checkbox {
        width: 30px;
        height: 30px;
        background-color: whitesmoke;
    }

    .modal__input-field {
        height: 35px;
        width: 350px;
        border-radius: 7px;
        font-size: 22px;
        font-weight: 600px;
        transition: 1.5s;
        border: none;
        margin-top: 25px;
        transition: .5s;
    }

    .modal__select {
        height: 35px;
        width: 160px;
        border-radius: 7px;
        font-size: 18px;
        font-weight: 600px;
        transition: 1.5s;
        border: none;
        transition: .5s;
    }

    .modal__input-field:focus {
        outline: none;
        border: solid 3px rgb(96, 96, 204);
        background-color: rgb(83, 0, 192);
        color: whitesmoke;
    }

    .hint {
        font-size: 20px;
    }

    .modal__order-inner {
        display: flex;
        flex-direction: column;
    }

    .modal__reviewer-name{
        color: whitesmoke;
        font-size: 20px;
    }

    .modal__exit {
        width: 35px;
        height: 35px;
        background-color: slateblue;
        color: whitesmoke;
        font-size: 20px;
        border-radius: 50%;
        border: none;
    }

    .modal__review-title {
        margin-top: 10px;
        font-size: 26px;
        color: whitesmoke;
        font-weight: 800;
    }

    .modal__search-container {
        display: flex;
        width: 280px;
        justify-content: space-between;
        align-items: center;
    }

    .modal__review-text {
        margin-top: 15px;
        font-size: 18px;
        max-width: 350px;
        word-wrap: break-word;
        color: whitesmoke;
    }

    .modal__review-rating {
        color: whitesmoke;
        margin-top: 12px;
        font-size: 20px;
    }

    .modal__input-text {
        border: none;
        height: 35px;
        border-radius: 10px;
        transition: .5s;
    }

    .modal__input-text:focus {
        outline: none;
        border: 2px solid blue;
    }

    .modal__cleaner-review {
        margin-top: 20px;
        background-color: rebeccapurple;
        border-radius: 10px;
        padding: 15px;
    }

    .modal__content {
        margin-top: 30px;
        padding-top: 30px;
        margin-bottom: 30px;
        background-color: lightseagreen;
        overflow-y: auto;
        padding-left: 20px;
        padding-right: 20px;
        padding-bottom: 20px;
        border-radius: 15px;
        border: 3px solid purple;
        color: whitesmoke;
        max-height: 80%;
    }

    .modal__button {
        font-family: 'Montserrat';
        font-size: 18px;
        border: none;
        background-color: slateblue;
        height: 35px;
        color: whitesmoke;
        border-radius: 15px;
        transition: .5s;
        width: 100px;
    }

    .modal {
        position: absolute;
        z-index: 5;
        min-width: 100%;
        display: flex;
        justify-content: center;
        height: 100%;
    }

    .main__rating-input {
        display: flex;
        align-items: center;
        width: 250px;
        justify-content: space-between;
        padding-top: 20px;
        padding-left: 30px;
    }

    input[type="number"] {
        background-color: #eee;
        vertical-align: top;
        outline: none;
        padding: 0;
        line-height: 40px;    
        text-indent: 10px;
        box-sizing: border-box;
        border: 1px solid #ddd;
        font-size: 14px;
        border-radius: 3px;
        font-family: 'Montserrat';
        font-size: 18px;
    }

    .main__input-mark {
        height: 40px;
        width: 50px;
    }

    .main__cards {
        display: grid;
        padding-top: 50px;
        padding-left: 30px;
        padding-right: 30px;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        column-gap: 15px;
        row-gap: 15px;
    }
    
    input[type="number"]:focus {
        outline: 2px solid blue;
    }

    .main__card-button {
        font-family: 'Montserrat';
        font-size: 18px;
        border: none;
        background-color: slateblue;
        height: 35px;
        color: whitesmoke;
        border-radius: 15px;
        transition: .5s;
        width: 300px;
    }

    .main__card-button:hover {
        height: 40px;
        width: 325px;
    }

    @media (max-width: 792px) {
        .main__rating-input {
            margin-left: auto;
            margin-right: auto;
        }

        .main__cleaner-card{
            width: 400px;
        }
    }
</style>

<script>
export default {
    data(){
        return{
            errors:[],
            cleanerInfos:[],
            isShowWindowOpened:false,
            cur_rooms_amount: 1,
            cleaning_date_time: "",
            cur_month: new Date().getMonth() + 1,
            cur_day: new Date().getDate(),
            cur_hour: 10,
            total: 0,
            search_text: "",
            phone_num: "",
            address: "",
            cleaner_id: "",
            curCleanerInfos: [],
            max_val: 5,
            min_val: 1,
            selCleaner: "",
            curComments: [],
            allComments: [],
            //order_date_time,
            rooms_amount: [
                {text: 'Одна комната', value: 1},
                {text: 'Две комнаты', value: 2},
                {text: 'Три комнаты', value: 3},
                {text: 'Четыре комнаты', value: 4},
                {text: 'Пять комнат', value: 5},
            ],
            months: [
                {text: 'Январь', value: 1},
                {text: 'Февраль', value: 2},
                {text: 'Март', value: 3},
                {text: 'Апрель', value: 4},
                {text: 'Май', value: 5},
                {text: 'Июнь', value: 6},
                {text: 'Июль', value: 7},
                {text: 'Август', value: 8},
                {text: 'Сентябрь', value: 9},
                {text: 'Октябрь', value: 10},
                {text: 'Ноябрь', value: 11},
                {text: 'Декабрь', value: 12},
            ],
            hours: [
                {value: 10},
                {value: 15},
                {value: 18},
            ],
            days: [],
            additional_services: [],
            services_picked: [],
            isValid: false,
            isShowComments: false
        }
    },
    methods:{
        selectMonth(){
                this.days = []
                console.log('sssssssssss')
                var dt = new Date();
                var month = this.cur_month;
                var year = dt.getFullYear();
                var daysInMonth = new Date(year, month, 0).getDate();
                for(var i = 1; i <= daysInMonth; i++) {
                    this.days.push(i);
                }
                this.validate()
        },
        openOrderWindow(cleanerInfo){
            this.selCleaner = cleanerInfo
            this.isShowWindowOpened = true;
            axios.get('/api/additionalServices').then(response=>{
                this.additional_services = response.data;
            })
            //console.log(cleanerInfo)
                var dt = new Date();
                var month = this.cur_month;
                var year = dt.getFullYear();
                var daysInMonth = new Date(year, month, 0).getDate();
                for(var i = 1; i <= daysInMonth; i++) {
                    this.days.push(i);
                }
            this.recountTotal();
        },
        findReviews(){
            axios.post('/api/searchReviews', {id: this.cleaner_id, text: "%" + this.search_text + "%"}).then(response=>{
                this.curComments = response.data;
                this.allComments = response.data;
            })
        },
        showComments(cleanerInfo) {
            console.log(cleanerInfo)
            axios.post('/api/getCleanerReviews', cleanerInfo).then(response=>{
                this.curComments = response.data;
                this.allComments = response.data;
                this.cleaner_id = cleanerInfo.id
            })
            this.isShowComments = true;
        },
        logout() {
            axios.post('/api/logout').then(response=>{
                localStorage.removeItem('UserData')
                this.$router.push('/')
            }).catch((error) => {

            })
        },
        validate() {
            var valid = true;
            var insertedDate = new Date(new Date().getFullYear(),this.cur_month-1,this.cur_day,this.cur_hour)
            var millis = insertedDate - new Date();
            if(millis <= 0)
                valid = false;
            if(this.phone_num.length != 10)
                valid = false;
            if(this.address.length < 15)
                valid = false;
            this.isValid = valid;
            console.log(this.isValid)
        },
        isNumber: function(evt) {
            if(this.phone_num.length == 10)
                evt.preventDefault();;
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                evt.preventDefault();;
            } else {
                return true;
            }
        },
        filterCleanerInfo() {
            this.curCleanerInfos = [];
            for(var i = 0; i < this.cleanerInfos.length; i++){
                if(this.cleanerInfos[i].rating > this.min_val && !(this.cleanerInfos[i].rating > this.max_val) ){
                    this.curCleanerInfos.push(JSON.parse(JSON.stringify(this.cleanerInfos[i])));
                }
                else if(Number(this.cleanerInfos[i].rating) == Number(this.max_val) && Number(this.cleanerInfos[i].rating)%1===0){
                    this.curCleanerInfos.push(JSON.parse(JSON.stringify(this.cleanerInfos[i])));
                }
                else if(Number(this.cleanerInfos[i].rating) == Number(this.min_val) && Number(this.cleanerInfos[i].rating)%1===0){
                    this.curCleanerInfos.push(JSON.parse(JSON.stringify(this.cleanerInfos[i])));
                }
            }
        },
        makeOrder(){
            var datetime = new Date().getFullYear() + "-" + this.cur_month + "-" + this.cur_day + " " + this.cur_hour + ":00:00";
            var id = JSON.parse(localStorage.getItem('UserData')).id
            var add_services = "";
            for(var i = 0; i < this.services_picked.length; i++) {
                add_services = add_services + this.services_picked[i].service_name + ", "
            }
            add_services = add_services.substring(0,add_services.length-2);
            var orderInfo = {orderDate: datetime, 
            address: this.address, 
            phone: "8" + this.phone_num, 
            cleaner_id: this.selCleaner.id, 
            user_id: id,
            services: add_services,
            total_cost: this.total,
            rooms_amount: this.cur_rooms_amount};
            axios.put('/api/makeOrder',orderInfo).then(response=>{
                this.$router.push('/userWelcomePage')
            }).catch((error) => {

            })
        },
        recountTotal(){
            var cleanerAllowance = 1;
            if(this.selCleaner.rating >= 4 && this.selCleaner.reviews_amount>=10)
                cleanerAllowance = 1.1
            else if(this.selCleaner.rating >= 4.5 && this.selCleaner.reviews_amount>=20)
                cleanerAllowance = 1.15
            
            this.total = this.cur_rooms_amount * 750 * cleanerAllowance
            //console.log(this.services_picked)
            for(var i = 0; i < this.services_picked.length; i++) {
                this.total = this.total + parseInt(this.services_picked[i].service_cost)
            }
        }
    },
    created() {
        //console.log(JSON.parse(localStorage.getItem('UserData')))
        axios.get('/api/getCleanersInfo').then(response=>{
            this.cleanerInfos = response.data;
            this.curCleanerInfos = JSON.parse(JSON.stringify(response.data))
            console.log(this.curCleanerInfos)
        }).catch((error) => {

        })
    }
}
</script>