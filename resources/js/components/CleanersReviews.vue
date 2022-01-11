<template>
    <div>
        <div class="main">
            <div class="main__content">
                <h2 class="main__header">Оценки уборщиков</h2>
                <div class="dashboard">
                    <div class="main__cleaner-selection">
                        <select v-model="curCleanerId" v-on:change="updateMarks(curCleanerId)" class="select-cleaner">
                            <option v-for="cleaner in cleaners" v-bind:value="cleaner.id" v-bind:key="cleaner.id" v-bind:selected="cleaner.id === -1">
                                {{cleaner.name}}
                            </option>
                        </select>
                    </div>
                    <div class="dashboard__content">
                        <div class="dashboard__pie"><pie :chartdata="pie_data" ref="pie"></pie></div>
                        <div class="dashboard__diagramm">
                            <div class="dashboard__diagramm-item dashboard__diagramm-item_mark-five"
                            v-bind:style="[this.fiveMarks > 0 ? {'height': this.fiveMarksRatio + '%','min-height': '24px'} : {'height': '0'}]">
                                <div class="dashboard__diagram-item-value" v-if="this.fiveMarks>0">
                                    {{this.fiveMarksRepresentation}}
                                </div>
                            </div>
                            <div class="dashboard__diagramm-item dashboard__diagramm-item_mark-four" 
                            v-bind:style="[this.fourMarks > 0 ? {'height': this.fourMarksRatio + '%','min-height': '24px'} : {'height': '0'}]">
                                <div class="dashboard__diagram-item-value" v-if="this.fourMarks>0">
                                    {{this.fourMarksRepresentation}}
                                </div>
                            </div>
                            <div class="dashboard__diagramm-item dashboard__diagramm-item_mark-three"
                            v-bind:style="[this.threeMarks > 0 ? {'height': this.threeMarksRatio + '%','min-height': '24px'} : {'height': '0'}]">
                                <div class="dashboard__diagram-item-value" v-if="this.threeMarks>0">
                                    {{this.threeMarksRepresentation}}
                                </div>
                            </div>
                            <div class="dashboard__diagramm-item dashboard__diagramm-item_mark-two"
                            v-bind:style="[this.twoMarks > 0 ? {'height': this.twoMarksRatio + '%','min-height': '24px'} : {'height': '0'}]">
                                <div class="dashboard__diagram-item-value" v-if="this.twoMarks>0">
                                    {{this.twoMarksRepresentation}}
                                </div>
                            </div>
                            <div class="dashboard__diagramm-item dashboard__diagramm-item_mark-one"
                            v-bind:style="[this.oneMarks > 0 ? {'height': this.oneMarksRatio + '%','min-height': '24px'} : {'height': '0'}]">
                                <div class="dashboard__diagram-item-value" v-if="this.oneMarks>0">
                                    {{this.oneMarksRepresentation}}
                                </div>
                            </div>
                        </div>
                        <div class="dashboard__categories">
                            <div class="dashboard__category">5</div>
                            <div class="dashboard__category">4</div>
                            <div class="dashboard__category">3</div>
                            <div class="dashboard__category">2</div>
                            <div class="dashboard__category">1</div>
                        </div>
                        <div class="dashboard__statistics">
                            <div class="dashboard__stat">
                                <div class="dashboard__stat-header">Всего отзывов:</div>
                                <div class="dashboard__stat-value">{{this.allMarks}}</div>
                            </div>
                            <div class="dashboard__stat">
                                <div class="dashboard__stat-header">Средняя оценка:</div>
                                <div class="dashboard__stat-value">{{this.averageMark}}</div>
                            </div>
                            <div class="dashboard__stat">
                                <div class="dashboard__stat-header">Положительные отзывы:</div>
                                <div class="dashboard__stat-value">{{this.fiveMarks+this.fourMarks+this.threeMarks}}</div>
                            </div>
                            <div class="dashboard__stat">
                                <div class="dashboard__stat-header">Отрицательные отзывы:</div>
                                <div class="dashboard__stat-value">{{this.twoMarks+this.oneMarks}}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="cleaners-reviews">
                    <div class="cleaners-reviews__content">
                        <div class="cleaners-reviews__button-container">
                            <button v-on:click="getReviews" class="cleaners-reviews__show-reviews-button">Показать все отзывы</button>
                        </div>
                        <div class="cleaners-reviews__list">
                            <div class="cleaners-reviews__review" v-for="(review, index) in reviews" v-bind:key="index">
                                <div class="cleaners-reviews__reviewer-name">Имя клиента: {{review.user_name}}</div>
                                <div class="cleaners-reviews__cleaner-name">ФИО уборщика: {{review.cleaner_name}}</div>
                                <div class="cleaners-reviews__rating">Оценка: {{review.rating}}</div>
                                <div class="cleaners-reviews__review__title">Заголовок: {{review.review_title}}</div>
                                <div class="cleaners-reviews__review-text">{{review.review_text}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Pie from './PieChart.vue'
export default {
    components: {
        Pie
    },
    data(){
        return{
            cleaners: [],
            curCleanerId: -1,
            fiveMarks: 0,
            fourMarks: 0,
            threeMarks: 0,
            twoMarks: 0,
            oneMarks: 0,
            allMarks: 0,
            noMarks: 0,
            reviews: [],
            pie_data: {hoverBackgroundColor: "red",
                hoverBorderWidth: 10,
                labels: ["Оценка проставлена", "Оценка не проставлена"],
                datasets: [
                {
                    label: "Data One",
                    backgroundColor: ["#41B883", "#808080"],
                    data: [this.allMarks,this.noMarks]
                }
            ]}
        }
    },
    computed: {
        fiveMarksRatio: function() {
            return (this.fiveMarks/this.allMarks)*100
        },
        fourMarksRatio: function() {
            return (this.fourMarks/this.allMarks)*100
        },
        threeMarksRatio: function() {
            return (this.threeMarks/this.allMarks)*100
        },
        twoMarksRatio: function() {
            return (this.twoMarks/this.allMarks)*100
        },
        oneMarksRatio: function() {
            return (this.oneMarks/this.allMarks)*100
        },
        fiveMarksRepresentation: function() {
            if(this.fiveMarks<1000){
                return this.fiveMarks
            }
            else{
                return Math.round(this.fiveMarks/100)/10 + 'K'
            }
        },
        fourMarksRepresentation: function() {
            if(this.fourMarks<1000){
                return this.fourMarks
            }
            else{
                return Math.round(this.fourMarks/100)/10 + 'K'
            }
        },
        threeMarksRepresentation: function() {
            if(this.threeMarks<1000){
                return this.threeMarks
            }
            else{
                return Math.round(this.threeMarks/100)/10 + 'K'
            }
        },
        twoMarksRepresentation: function() {
            if(this.twoMarks<1000){
                return this.twoMarks
            }
            else{
                return Math.round(this.twoMarks/100)/10 + 'K'
            }
        },
        oneMarksRepresentation: function() {
            if(this.oneMarks<1000){
                return this.oneMarks
            }
            else{
                return Math.round(this.oneMarks/100)/10 + 'K'
            }
        },
        averageMark: function() {
            return Math.round((this.fiveMarks*5+this.fourMarks*4+this.threeMarks*3+this.twoMarks*2+this.oneMarks)/this.allMarks*100)/100
        }
    },
    methods: {
        updateMarks(id){
            if(id != -1){
                axios.get('/api/getCleanersReviews', {params: {id}}).then(response=>{
                    this.setMarks(response)
                    this.updatePieData()
                }).catch((error) => {

                })
            }
            else {
                axios.get('/api/getCleanersReviews').then(response=>{
                    this.setMarks(response)
                    this.updatePieData()
                }).catch((error) => {

                })
            }
        },
        updatePieData(){
            let array = [this.allMarks, this.noMarks]
            this.pie_data = {
                hoverBackgroundColor: "red",
                hoverBorderWidth: 10,
                labels: ["Оценка проставлена", "Оценка не проставлена"],
                datasets: [
                {
                    label: "Data One",
                    backgroundColor: ["#41B883", "#808080"],
                    data: array
                }
                ]
            }
            this.$refs.pie.updateChart(this.pie_data)
        },
        setMarks(response){
            this.allMarks = response.data[0].all_marks
            this.fiveMarks = response.data[0].five_mark
            this.fourMarks = response.data[0].four_mark
            this.threeMarks = response.data[0].three_mark
            this.twoMarks = response.data[0].two_mark
            this.oneMarks = response.data[0].one_mark
            this.noMarks = response.data[0].no_marks
        },
        getReviews(){
            if(this.curCleanerId == -1){
                axios.get('/api/getReviews').then(response=>{
                    this.reviews = response.data
                }).catch((error) => {

                })
            }
            else{
                var curCleanerId = this.curCleanerId
                axios.get('/api/getReviews', {params: {curCleanerId}}).then(response=>{
                    this.reviews = response.data
                }).catch((error) => {
                    
                })
            }
        }
    },
    created() {
        axios.get('/api/getCleanersReviews').then(response=>{
            this.setMarks(response)
            this.updatePieData()
        }).catch((error) => {

        })
        axios.get('/api/getAllCleaners').then(response=>{
            this.cleaners.push({id: -1, name: 'Все уборщики'})
            for(var i = 0; i < response.data.length; i++){
                this.cleaners.push({id: response.data[i].id, name: response.data[i].name})
            }
        }).catch((error) => {

        })
    }
}
</script>

<style>
    .dashboard__content {
        margin-top: 30px;
        margin-left: auto;
        margin-right: auto;
        max-width: 1000px;
        min-height: 970px;
        border-radius: 20px;
        border: 3px solid slateblue;
        background-color: rgb(253, 251, 251);
    }

    .dashboard__diagramm {
        border: 1px solid blue;
        max-width: 780px;
        height: 400px;
        margin-top: 30px;
        margin-left: auto;
        margin-right: auto;
        border-radius: 20px;
        display: flex;
        align-items: flex-end;
        background-color: darkslategray;
    }

    .dashboard__statistics {
        margin-top: 20px;
        min-height: 160px;
        display: flex;
        justify-content: space-around;
    }

    .dashboard__stat-header {
        font-size: 22px;
        text-align: center;
    }

    .dashboard__stat-value {
        font-size: 24px;
        color: white
    }

    .dashboard__stat {
        display: flex;
        align-items: center;
        flex-direction: column;
        justify-content: space-around;
        background-color: cadetblue;
        border-radius: 8px;
        width: 240px;
    }

    .dashboard__diagramm-item {
        flex: 1;
        border-radius: 20px;
        transition: .5s;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .dashboard__diagramm-item_mark-five {
        background-color: rgba(0, 255, 128, 0.678);
    }

    .dashboard__diagramm-item_mark-four {
        background-color: rgba(182, 248, 59, 0.678);
    }

    .dashboard__diagramm-item_mark-three {
        background-color: rgba(255, 255, 0, 0.678);
    }

    .dashboard__diagramm-item_mark-two {
        background-color: rgb(255, 101, 41, 0.678);
    }

    .dashboard__diagramm-item_mark-one {
        background-color: rgba(255, 0, 0, 0.678);
    }

    .dashboard__categories {
        display: flex;
        justify-content: space-around;
        max-width: 780px;
        margin-top: 5px;
        margin-left: auto;
        margin-right: auto;
    }

    .dashboard__category {
        font-size: 26px;
    }

    .dashboard__diagram-item-value {
        font-size: 22px;
    }

    .select-cleaner {
        width: 280px;
        height: 35px;
        border-radius: 7px;
        font-size: 16px;
        font-weight: 600px;
        transition: 1.5s;
        border: none;
        transition: .5s;
        background-color: royalblue;
        color: white;
        font-family: 'Montserrat';
    }

    .main__cleaner-selection {
        display: flex;
        justify-content: center;
        margin-top: 30px;
    }

    .dashboard__pie {
        max-width: 300px;
        max-height: 300px;
        margin-left: auto;
        margin-right: auto;
    }

    .cleaners-reviews__content {
        max-width: 1200px;
        margin-top: 50px;
        margin-right: auto;
        margin-left: auto;
        min-height: 60px;
        border: 3px solid slateblue;
        background-color: white;
        border-radius: 20px;
    }

    .cleaners-reviews__list {
        max-width: 1100px;
        margin-left: auto;
        margin-right: auto;
        margin-top: 40px;
        margin-bottom: 40px;
    }

    .cleaners-reviews__review {
        background-color: rgb(223, 223, 223);
        margin-top: 20px;
        padding: 15px 15px 15px 15px;
        border-radius: 10px;
    }

    .cleaners-reviews__reviewer-name {
        font-size: 22px;
        font-weight: 700;
    }

    .cleaners-reviews__cleaner-name {
        margin-top: 7px;
        font-size: 20px;
    }

    .cleaners-reviews__rating {
        margin-top: 7px;
        font-size: 20px;
    }

    .cleaners-reviews__review__title {
        margin-top: 7px;
        font-size: 20px;
    }

    .cleaners-reviews__review-text {
        margin-top: 12px;
        font-size: 16px;
    }

    .cleaners-reviews__show-reviews-button {
        width: 250px;
        height: 50px;
        font-family: 'Montserrat';
        font-size: 20px;
        border-radius: 10px;
        border: none;
        background-color: slateblue;
        color: white;
    }

    .cleaners-reviews__button-container {
        margin-left: auto;
        margin-right: auto;
        margin-top: 30px;
        max-width: fit-content;
    }

    @media (max-width: 1000px) {
        .dashboard__statistics {
            display: grid;
            grid-template-columns: 1fr 1fr;
            grid-template-rows: 1fr 1fr;
            row-gap: 20px;
            column-gap: 20px;
            height: 300px;
            margin-left: auto;
            margin-right: auto;
            max-width: 995px;
        }

        .dashboard__stat {
            width: auto;
        }

        .dashboard__content {
            border-radius: 0px;
            border: none;
        }
    }
</style>