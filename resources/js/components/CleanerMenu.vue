<template>
    <div>
        <header class="header">
            <div class="header__logo">
                Формула чистоты
                <img class="header__logo-image" src="Images/serviceLogo.svg" alt="Логотип компании с изображением инструментов для мытья">
            </div>
            <div class="header__links">
                <router-link to="/cleaner/cleanerMainPage"><a href="#">ЛК</a></router-link>
                <router-link to="/cleaner/cleanerReviews"><a href="#">Отзывы</a></router-link>
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