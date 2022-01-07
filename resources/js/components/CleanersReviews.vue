<template>
    <div>
        <div class="main">
            <div class="main__content">
                <h2 class="main__header">Оценки уборщиков</h2>
                <div class="dashboard">
                    <div class="dashboard__content">
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
                                Всего отзывов: {{this.allMarks}}
                            </div>
                            <div class="dashboard__stat">
                                Средняя оценка: {{this.averageMark}}
                            </div>
                            <div class="dashboard__stat">
                                Количество положительных отзывов: {{this.fiveMarks+this.fourMarks+this.threeMarks}}
                            </div>
                            <div class="dashboard__stat">
                                Количество отрицательных отзывов: {{this.twoMarks+this.oneMarks}}
                            </div>
                        </div>
                    </div>
                </div>
                <select v-model="curCleanerId" v-on:change="updateMarks(curCleanerId)" class="select">
                    <option v-for="cleaner in cleaners" v-bind:value="cleaner.id" v-bind:key="cleaner.id" v-bind:selected="cleaner.id === -1">
                        {{cleaner.name}}
                    </option>
                </select>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return{
            cleaners: [],
            curCleanerId: -1,
            fiveMarks: 0,
            fourMarks: 0,
            threeMarks: 0,
            twoMarks: 0,
            oneMarks: 0,
            allMarks: 0
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
                    this.allMarks = response.data[0].all_marks
                    this.fiveMarks = response.data[0].five_mark
                    this.fourMarks = response.data[0].four_mark
                    this.threeMarks = response.data[0].three_mark
                    this.twoMarks = response.data[0].two_mark
                    this.oneMarks = response.data[0].one_mark
                }).catch((error) => {

                })
            }
            else {
                axios.get('/api/getCleanersReviews').then(response=>{
                    this.allMarks = response.data[0].all_marks
                    this.fiveMarks = response.data[0].five_mark
                    this.fourMarks = response.data[0].four_mark
                    this.threeMarks = response.data[0].three_mark
                    this.twoMarks = response.data[0].two_mark
                    this.oneMarks = response.data[0].one_mark
                }).catch((error) => {

                })
            }
        }
    },
    created() {
        axios.get('/api/getCleanersReviews').then(response=>{
            this.allMarks = response.data[0].all_marks
            this.fiveMarks = response.data[0].five_mark
            this.fourMarks = response.data[0].four_mark
            this.threeMarks = response.data[0].three_mark
            this.twoMarks = response.data[0].two_mark
            this.oneMarks = response.data[0].one_mark
        }).catch((error) => {

        })
        axios.get('/api/getAllCleaners').then(response=>{
            //this.cleaners = response.data;
            this.cleaners.push({id: -1, name: 'Все уборщики'})
            for(var i = 0; i < response.data.length; i++){
                this.cleaners.push({id: response.data[i].id, name: response.data[i].name})
            }
            console.log(this.cleaners)
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
        max-width: 980px;
        height: 650px;
        border-radius: 20px;
        border: 3px solid slateblue;
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
    }

    .dashboard__statistics {
        margin-top: 20px;
        margin-left: auto;
        margin-right: auto;
        max-width: 780px;
        height: 160px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: center;
    }

    .dashboard__stat {
        font-size: 18px;
        flex-grow: 1;
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
        background-color: springgreen;
    }

    .dashboard__diagramm-item_mark-four {
        background-color: rgb(182, 248, 59);
    }

    .dashboard__diagramm-item_mark-three {
        background-color: yellow;
    }

    .dashboard__diagramm-item_mark-two {
        background-color: rgb(255, 101, 41);
    }

    .dashboard__diagramm-item_mark-one {
        background-color: red;
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
</style>