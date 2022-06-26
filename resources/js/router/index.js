import axios from 'axios';
import UniversityProfile from '../views/UniversityProfile'
import Home from '../views/Home'
import Login from '../views/Login'
import Vue from 'vue'
import VueAxios from 'vue-axios';
import Router from 'vue-router'
import VueCookie from 'vue-cookie'
import VueSession from 'vue-session'
import VueSimpleAlert from "vue-simple-alert";

Vue.use(VueCookie);
// Vue.use(VueRouter)
Vue.use(VueAxios, axios);
Vue.use(VueSession)
Vue.use(VueSimpleAlert);
Vue.use(Router)

export default {
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/profile/:name/:id',
            name: 'UniversityProfile',
            component: UniversityProfile,
        },
        {
            path: '/login',
            name: 'login',
            component: Login,
        },
    ],
};