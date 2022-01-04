<template>
    <div>
        <div class="main">
            <div class="main__content">
                <h2 class="main__header">Оценки уборщиков</h2>
                <div class="dashboard">
                    <div class="dashboard__content">
                        <div class="dashboard__diagramm">
                            <div class="dashboard__diagramm-item dashboard__diagramm-item_mark-five"
                            v-bind:style="{height: this.fiveMarksRatio + '%'}">

                            </div>
                            <div class="dashboard__diagramm-item dashboard__diagramm-item_mark-four" 
                            v-bind:style="{height: this.fourMarksRatio + '%'}">

                            </div>
                            <div class="dashboard__diagramm-item dashboard__diagramm-item_mark-three"
                            v-bind:style="{height: this.threeMarksRatio + '%'}">

                            </div>
                            <div class="dashboard__diagramm-item dashboard__diagramm-item_mark-two"
                            v-bind:style="{height: this.twoMarksRatio + '%'}">

                            </div>
                            <div class="dashboard__diagramm-item dashboard__diagramm-item_mark-one"
                            v-bind:style="{height: this.oneMarksRatio + '%'}">

                            </div>
                        </div>
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
    }
}
</script>

<style>
    .dashboard__content {
        margin-top: 30px;
        margin-left: auto;
        margin-right: auto;
        max-width: 980px;
        height: 500px;
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

    .dashboard__diagramm-item {
        flex: 1;
        border-radius: 20px;
        transition: .5s;
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
</style>