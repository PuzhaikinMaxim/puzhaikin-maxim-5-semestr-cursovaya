<template>
<div>
    <header class="header">
            <div class="header__logo">
                Формула чистоты
                <img class="header__logo-image" src="Images/serviceLogo.svg" alt="Логотип компании с изображением инструментов для мытья">
            </div>
            <div class="header__links">
                <router-link to="/client/userWelcomePage"><a href="#">ЛК</a></router-link>
                <router-link to="/client/orderCleaning"><a href="#">Сделать заказ</a></router-link>
                <router-link to="/client/makeReview"><a href="#">Оставить отзыв</a></router-link>
                <a href="#" @click.prevent="logout">Выйти</a>
            </div>
    </header>
    <router-view/>
</div>
</template>

<script>
export default {
    methods:{
        logout() {
            axios.post('/api/logout').then(response=>{
                localStorage.removeItem('UserData')
                this.$router.push('/')
        }).catch((error) => {

        })
        }
    }
}
</script>

<style>
    .main__order-card {
        padding: 15px;
        background-color: lightseagreen;
        max-width: 400px;
        border-radius: 25px;
    }

    .main__order-info-item {
        margin-top: 15px;
        color: whitesmoke;
        font-size: 18px;
        font-weight: 600;
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