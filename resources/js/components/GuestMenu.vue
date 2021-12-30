<template>
<div>
    <header class="header">
            <div class="header__logo">
                Формула чистоты
                <img class="header__logo-image" src="Images/serviceLogo.svg" alt="Логотип компании с изображением инструментов для мытья">
            </div>
            <div class="header__links">
                <router-link to="/"><a href="#">Главная страница</a></router-link>
                <router-link to="/login"><a href="#">Вход</a></router-link>
                <router-link to="/registration"><a href="#">Регистрация</a></router-link>
            </div>
    </header>
    <router-view/>
</div>
</template>