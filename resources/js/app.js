/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import Vue from 'vue'
import VueRouter from 'vue-router'
import WelcomePage from './components/WelcomePage.vue'
import Registration from './components/Registration.vue'
import Login from './components/Login.vue'
import UserWelcomePage from './components/UserWelcomePage.vue'
import OrderCleaning from './components/OrderCleaning.vue'
import CleanerMainPage from './components/CleanerMainPage.vue'
import MakeReview from './components/MakeReview.vue'
import RegisterCleaner from './components/RegisterCleaner.vue'
import AddAdditionalService from './components/AddAdditionalService.vue'
import CleanersReviews from './components/CleanersReviews.vue'
import ClientMenu from './components/ClientMenu.vue'
import CleanerMenu from './components/CleanerMenu.vue'
import AdminMenu from './components/AdminMenu.vue'
import GuestMenu from './components/GuestMenu.vue'
import CleanerReviews from './components/CleanerReviews.vue'
import AdminWelcomePage from './components/AdminWelcomePage.vue'

//const VueRouter = require('vue-router').default;

Vue.use(VueRouter);

window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('main-component', require('./components/MainComponent.vue').default);

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '',
            component: GuestMenu,
            children: [
                {
                    path: '/',
                    component: WelcomePage,
                    meta: {title: '?????????????? ?????????????? - ?????????????????????? ????????????????'}
                },
                {
                    path: 'registration',
                    component: Registration,
                    meta: {title: '??????????????????????'}
                },
                {
                    path: 'login',
                    component: Login,
                    meta: {title: '????????'}
                }
            ]
        },
        {
            path: '/client',
            name: 'client',
            component: ClientMenu,
            beforeEnter: (to, from, next) => {
                axios.get('/api/GetUser').then(response=>{
                    User = response.data;
                    localStorage.setItem('UserData', JSON.stringify(response.data))
                    if(User.role_id === 1) {
                        next()
                    }
                }).catch((error) => {

                })
            },
            children: [
                {
                    path: 'userWelcomePage',
                    component: UserWelcomePage,
                    meta: {title: '???????????? ??????????????'}
                },
                {
                    path: 'makeReview',
                    component: MakeReview,
                    meta: {title: '???????? ????????????'}
                },
                {
                    path: 'orderCleaning',
                    component: OrderCleaning,
                    meta: {title: '?????????? ???????????? ???? ??????'}
                }
            ]
        },
        {
            path: '/cleaner',
            name: 'cleaner',
            component: CleanerMenu,
            beforeEnter: (to, from, next) => {
                axios.get('/api/GetUser').then(response=>{
                    User = response.data;
                    localStorage.setItem('UserData', JSON.stringify(response.data))
                    if(User.role_id === 2) {
                        next()
                    }
                }).catch((error) => {

                })
            },
            children: [
                {
                    path: 'cleanerMainPage',
                    component: CleanerMainPage,
                    meta: {title: '???????????? ??????????????'}
                },
                {
                    path: 'cleanerReviews',
                    component: CleanerReviews,
                    meta: {title: '???????????? ???? ???????? ????????????'}
                }
            ]
        },
        {
            path: '/admin',
            name: 'admin',
            component: AdminMenu,
            beforeEnter: (to, from, next) => {
                axios.get('/api/GetUser').then(response=>{
                    User = response.data;
                    localStorage.setItem('UserData', JSON.stringify(response.data))
                    if(User.role_id === 3) {
                        next()
                    }
                }).catch((error) => {

                })
            },
            children: [
                {
                    path: 'registerCleaner',
                    component: RegisterCleaner,
                    meta: {title: '?????????????????????? ????????????????'}
                },
                {
                    path: 'addAdditionalService',
                    component:AddAdditionalService,
                    meta: {title: '???????????????????????????? ????????????'}
                },
                {
                    path: 'cleanersReviews',
                    component: CleanersReviews,
                    meta: {title: '????????????'}
                },
                {
                    path: 'adminWelcomePage',
                    component: AdminWelcomePage,
                    meta: {title: '???????????? ??????????????'}
                }
            ]
        },
    ]
});

router.beforeEach((to, from, next) => {
    document.title = to.meta.title

    next()
  })

var User;

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    components: { app },
    router,
    User,
});
