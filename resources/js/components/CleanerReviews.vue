<template>
    <div class="main">
        <h2 class="main__header">Отзывы клиентов</h2>
        <div class="main__average-mark">
            Средняя оценка: {{averageMark}}
        </div>
        <div class="cleaners-reviews">
            <div class="cleaners-reviews__content">
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
</template>

<script>
export default {
    data(){
        return{
            reviews: [],
            averageMark: 0
        }
    },
    created() {
        axios.get('/api/getReviewsOnCleaner').then(response=>{
            this.reviews = response.data
            var allMarksSumm = 0
            for(var i = 0; i < this.reviews.length; i++){
                allMarksSumm += this.reviews[i].rating
            }
            this.averageMark = Math.round(allMarksSumm/this.reviews.length*100)/100
        }).catch((error) => {
                    
        })
    }
}
</script>

<style>
    .main__average-mark{
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin-top: 25px;
        font-weight: 600;
        max-width: 295px;
        min-height: 140px;
        margin-left: auto;
        margin-right: auto;
        background-color: darkslateblue;
        border-radius: 10px;
        color: #fff;
        text-align: center;
    }
</style>