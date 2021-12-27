<template>
    <div class="content">
    <router-view/>
    <footer class="footer">
            <div class="footer__block">
                <div class="footer__block-header">
                    Связаться с нами
                </div>
                <div class="footer__phones">
                    <p>+7 495 888 77 66</p>
                    <p>8 800 222 33 33</p>
                </div>
                <div class="footer__address">
                    <a href="https://goo.gl/maps/NopaJtNs5zS66Bu5A">
                        <p>Россия, 127556, г.Москва,</p>
                        <p>ул.Пушкина 5с1</p>
                    </a>
                </div>
            </div>
            <div class="footer__block">
                <div class="footer__block-header">
                    Ссылки на соцсети
                </div>
                <div class="footer__social-links">
                    <a href="vk.com"><img src="Images/vk.png" alt="Вконтакте" class="footer__social-image"><p>Вконтакте</p></a>
                    <a href="facebook.com"><img src="Images/facebook.svg" alt="Фейсбук" class="footer__social-image"><p>Facebook</p></a>
                    <a href="twitter.com"><img src="Images/twitter.svg" alt="Твиттер" class="footer__social-image"><p>Twitter</p></a>
                </div>
            </div>
        </footer>
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

    .header__logo {
        font-size: 42px;
        color: whitesmoke;
        font-weight: 800;
    }

    .header {
        background-color: rgb(97, 95, 95);
        min-height: 125px;
        display: flex;
        align-items: center;
        justify-content: space-around;
    }

    .header__links a {
        color: whitesmoke;
        font-size: 18px;
        transition: .9s;
    }

    .header__links {
        display: flex;
        width: 600px;
        justify-content: space-between;
    }

    .header__links a:hover {
        font-size: 22px;
    }

    .header__logo-image {
        height: 50px;
    }

    .footer {
        display: flex;
        align-items: center;
        min-height: 200px;
        justify-content: space-around;
        background-color: rgb(31, 48, 70);
    }

    .footer__block-header {
        color: seashell;
        font-size: 24px;
        font-weight: 600;
    }

    .footer__block {
        height: 150px;
        display: flex;
        justify-content: space-between;
        flex-direction: column;
    }

    .footer__phones {
        color: seashell;
        font-size: 19px;
    }

    .footer__address {
        color: seashell;
        font-size: 17px;
    }

    a {
        color: inherit;
    }

    .footer__social-image {
        height: 32px;
        width: 32px;
    }

    .footer__social-links {
        color: seashell;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        min-height: 120px;
    }

    .footer__social-links a {
        display: flex;
        align-items: center;
    }

    .footer__social-links a p {
        margin-left: 10px;
        font-size: 24px;
        transition: .9s;
    }

    .footer__social-links img {
        transition: .9s;
    }

    .footer__social-links a p:hover, .footer__social-links img:hover {
        font-size: 28px;
        height: 40px;
        width: 40px;
    }

    @media (max-width: 610px) {
        .footer {
            flex-direction: column;
            padding-top: 25px;
            padding-bottom: 25px;
        }

        .footer__block {
            margin-top: 40px;
        }

        .footer__block-header {
            font-size: 30px;
        }

        .footer__social-links a {
            margin-top: 10px;
        }
    }

    @media (max-width: 1145px) {
        .header {
            display: flex;
            flex-direction: column;
            padding: 20px;
        }

        .header__links {
            flex-direction: column;
            width: auto;
            margin-left: auto;
            margin-right: auto;
            margin-top: 40px;
            min-height: 200px;
        }

        .header__logo {
            font-size: 38px;
        }
    }
</style>
