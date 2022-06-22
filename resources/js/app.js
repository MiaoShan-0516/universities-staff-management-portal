import Vue from 'vue'
import VueRouter from 'vue-router'
import App from './views/App'
import Hello from './views/Hello'
import Home from './views/Home'

Vue.use(VueRouter)

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/hello',
            name: 'hello',
            component: Hello,
        },
        {
            path: '/login',
            name: 'login',
            component: Login,
        },
    ],
});
const app = new Vue({
    el: '#app',
    components: { App },
    router,
});