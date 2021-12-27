<template>
<div class="content">
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
  <!--
  <div class="home">
    <img alt="Vue logo" src="../assets/logo.png">
    <HelloWorld msg="Welcome to Your Vue.js App"/>
  </div>
  -->
  <main class="main">
        <div class="main__content">
            <div class="main__about-company">
                <h2 class="main__about-header">О компании</h2>
                <div class="main__about-text">
                    Мы, компания "Формула чистоты", занимаемся уборкой ваших квартир для того, чтобы вы отдыхали! Мы на рынке много лет, в течении которых 
                    мы совершенствовали свой сервис.
                </div>
            </div>
            <div class="main__successes">
                <h2 class="main__about-header">Наши успехи</h2>
                <div class="main__indicators">
                    <div class="main__indicator">
                        <img src="Images\multiple-users-silhouette.png" alt="Иконка клиентов" class="main__indicator-image">
                        Более 300 постоянных клиентов
                    </div>
                    <div class="main__indicator">
                        <img src="Images\like.png" alt="Иконка с изображенным пальцем вверх" class="main__indicator-image">
                        Более 500 положительных отзывов
                    </div>
                    <div class="main__indicator">
                        <img src="Images\bar-chart.png" alt="Иконка растущего графика" class="main__indicator-image">
                        Высшее качество уборки
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
</template>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,500;0,600;0,800;0,900;1,900&display=swap');
    html, body, div, span, applet, object, iframe,
    h1, h2, h3, h4, h5, h6, p, blockquote, pre,
    a, abbr, acronym, address, big, cite, code,
    del, dfn, em, img, ins, kbd, q, s, samp,
    small, strike, strong, sub, sup, tt, var,
    b, u, i, center,
    dl, dt, dd, ol, ul, li,
    fieldset, form, label, legend,
    table, caption, tbody, tfoot, thead, tr, th, td,
    article, aside, canvas, details, embed, 
    figure, figcaption, footer, header, hgroup, 
    menu, nav, output, ruby, section, summary,
    time, mark, audio, video {
        margin: 0;
        padding: 0;
        border: 0;
        font-size: 100%;
        font: inherit;
        vertical-align: baseline;
    }
    article, aside, details, figcaption, figure, 
    footer, header, hgroup, menu, nav, section {
        display: block;
    }
    body {
        line-height: 1;
    }
    ol, ul {
        list-style: none;
    }
    blockquote, q {
        quotes: none;
    }
    blockquote:before, blockquote:after,
    q:before, q:after {
        content: '';
        content: none;
    }
    table {
        border-collapse: collapse;
        border-spacing: 0;
    }

    textarea {
        resize: none;
    }

    body {
        background-color: #fafafa;
    }

    header {
        background-color: #fafafa;
    }

    a {
        text-decoration: none;
    }

    html {
        box-sizing: border-box;
    }

    *, *::before, *::after {
        box-sizing: inherit;
    }

    body {
        font-family: 'Montserrat';
    }

    a {
        color: inherit;
    }

    .main {
        background-color: rgb(243, 247, 243);
        /*width: 100vw;*/
    }

    .main__content {
        max-width: 1440px;
        margin: 0 auto;
        position: relative;
        /*background-color: rgb(109, 192, 223);*/
        min-height: 1000px;
        padding-bottom: 15px;
    }

    .main__about-company {
        padding-top: 50px;
    }

    .main__about-text {
        color: rgb(31, 48, 70);
        font-size: 24px;
        font-weight: 600;
        max-width: 900px;
        margin: 0 auto;
        padding-top: 20px;
        text-align: center;
    }

    h2 {
        font-size: 30px;
        font-weight: 800;
    }

    .main__about-header {
        color: rgb(31, 48, 70);
        text-align: center;
        font-size: 36px;
        font-weight: 900;
    }

    .main__successes {
        padding-top: 75px;
    }

    .main__indicators {
        padding-top: 50px;
        min-height: 250px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        margin: 0 auto;
        max-width: 520px;
    }

    .main__indicator-image {
        width: 42px;
    }

    .main__indicator {
        font-weight: 600;
        font-size: 24px;
        color: rgb(31, 48, 70);
    }

    @media (max-width: 550px) {
        .main__indicators {
            margin-left: auto;
            margin-right: auto;
            width: 440px;
        }

        .main__indicator {
            font-size: 20px;
        }

        .main__about-text {
            font-size: 22px;
        }
    }
</style>