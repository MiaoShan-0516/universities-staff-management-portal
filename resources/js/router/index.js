import axios from 'axios';
import Home from '../views/Home'
import Login from '../views/Login'
import StaffProfile from '../views/StaffProfile'
import UniversityProfile from '../views/UniversityProfile'
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
            path: '/login',
            name: 'login',
            component: Login,
        },
        {
            path: '/profile/:name/id=:id',
            name: 'UniversityProfile',
            component: UniversityProfile,
        },
        {
            path: '/:uniId/staff/:name/id=:id',
            name: 'StaffProfile',
            component: StaffProfile,
        },
    ],
};