<template>
    <div>
        <div class="main">
            <div class="main__content">
                <h2 class="main__header">Оставить отзыв</h2>
                <div class="main__reviews-header" v-if="isHaveActiveReviews">Текущие отзывы</div>
                <div class="main__reviews-header" v-else>Вы еще не оставили ни одного отзыва</div>
                <div class="main__cards">
                    <div v-for="(review, index) in reviews" v-bind:key="index" class="main__review-card">
                        <div class="main__review-cleaner-name">ФИО уборщика: {{review.name}}</div>
                        <label class="main__review-title-label"> Заголовок отзыва: 
                            <input type="text" v-model="review.review_title" class="main__review-title-input">
                        </label>
                        <label>
                            <textarea cols="39" rows="10" v-model="review.review_text" class="main__review-text-input"></textarea>
                        </label>
                        <label class="main__review-rating-label">Оценка: 
                            <select v-model="review.rating" class="main__review-rating-select">
                                <option v-for="rating in ratings" v-bind:value="rating.value" v-bind:key="rating.value">
                                    {{rating.value}}
                                </option>
                            </select>
                        </label>
                        <button v-on:click="redactReview(review)" class="main__review-submit">Изменить отзыв</button>
                    </div>
                </div>
                <div class="main__reviews-header" v-if="isCanMakeNewReview">Оставьте отзыв на работу уборщиков</div>
                <div class="main__reviews-header" v-else>Вы не можете добавить новый отзыв</div>
                <div class="main__cards">
                    <div v-for="(review, index) in empty_reviews" v-bind:key="index" class="main__review-card">
                        <div class="main__review-cleaner-name">ФИО уборщика: {{review.name}}</div>
                        <label class="main__review-title-label"> Заголовок отзыва:
                            <input class="main__review-title-input" type="text" v-model="review.review_title">
                        </label>
                        <label>
                            <textarea cols="39" rows="10" v-model="review.review_text" class="main__review-text-input"></textarea>
                        </label>
                        <label class="main__review-rating-label">Оценка: 
                            <select v-model="review.rating" class="main__review-rating-select">
                                <option v-for="rating in ratings" v-bind:value="rating.value" v-bind:key="rating.value">
                                    {{rating.value}}
                                </option>
                            </select>
                        </label>
                        <button v-on:click="createReview(review)" class="main__review-submit">Написать отзыв</button>
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
            empty_reviews: [],
            ratings: [
                {value: 1},
                {value: 2},
                {value: 3},
                {value: 4},
                {value: 5}
            ],
            isHaveActiveReviews: false,
            isCanMakeNewReview: false
        }
    },
    methods: {
        createReview(review){
            console.log(review)
            if(review.rating != null && review.review_title != null && review.review_text != null){
                if(review.review_title.length >= 5 && review.review_text.length >= 10) {
                    axios.post('/api/makeReview',review).then(response=>{
                        review.id = response.id;
                        console.log(response)
                        for(var i = 0; i < this.empty_reviews.length; i++){
                            if(this.empty_reviews[i] != null){
                                var item = this.empty_reviews[i];
                                this.reviews.push(item);
                                this.empty_reviews.splice(i,1);
                            }
                        }
                        if(this.empty_reviews.length == 0)
                            this.isCanMakeNewReview = false;
                    }).catch((error) => {

                    })
                }
            }
        },
        redactReview(review){
            if(review.review_title != null && review.review_text != null){
                if(review.review_title.length >= 5 && review.review_text.length >= 10) {
                    axios.put('/api/redactReview',review).then(response=>{
                }).catch((error) => {

                })
                }
            }
        }
    },
    created() {
        //console.log(JSON.parse(localStorage.getItem('UserData')))
        axios.get('/api/getUserReviews').then(response=>{
            //this.reviews = response.data;
            for(var i = 0; i < response.data.length; i++){
                console.log(response.data[i].review_id)
                if(response.data[i].review_id != null)
                    this.reviews.push(response.data[i]);
                else
                    this.empty_reviews.push(response.data[i]);
            }

            if(this.empty_reviews.length > 0)
                this.isCanMakeNewReview = true;
            if(this.reviews.length > 0)
                this.isHaveActiveReviews = true;
            console.log(this.reviews);
        }).catch((error) => {

        })
    }
}
</script>

<style>
    .main__review-card{
        display: flex;
        flex-direction: column;
        background-color: lightseagreen;
        padding: 15px;
        border-radius: 25px;
        width: 400px;
        color: whitesmoke;
        margin-left: auto;
        margin-right: auto;
    }

    .main__cards {
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    }

    .main__review-title-label {
        font-size: 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 15px;
    }

    .main__review-rating-label {
        margin-top: 20px;
        font-size: 22px;
        font-weight: 600;
    }

    .main__reviews-header {
        font-size: 28px;
        font-weight: 700;
        margin-left: 30px;
        margin-top: 40px;
    }

    .main__review-title-input {
        border: none;
        height: 30px;
        font-size: 18px;
        font-family: 'Montserrat';
        border-radius: 15px;
        transition: .5s;
    }

    .main__review-text-input {
        border: none;
        transition: .5s;
        font-size: 16px;
        border-radius: 10px;
        margin-top: 15px;
        font-family: 'Montserrat';
    }

    .main__review-submit {
        margin-top: 20px;
        height: 50px;
        background-color: slateblue;
        font-size: 22px;
        color: whitesmoke;
        border-radius: 20px;
        border: none;
        transition: .5s;
    }

    .main__review-submit:hover {
        height: 55px;
        font-size: 24px;
    }

    .main__review-rating-select {
        height: 30px;
        width: 50px;
        border: none;
        border-radius: 10px;
        font-size: 18px;
        font-family: 'Montserrat';
    }

    .main__review-rating-select:focus {
        outline: none;
    }

    .main__review-text-input:focus {
        outline: none;
    }

    .main__review-title-input:focus {
        outline: none;
        border: 1px solid blue;
    }

    .main__review-cleaner-name {
        font-size: 22px;
        font-weight: 700;
    }

    @media (max-width: 792px) {
        .main__reviews-header {
            text-align: center;
        }
    }
</style>