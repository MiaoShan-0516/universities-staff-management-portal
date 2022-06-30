// import App from './views/App'
import axios from 'axios';
import Vue from 'vue'
import VueAxios from 'vue-axios';
import VueRouter from 'vue-router'
import VueCookie from 'vue-cookie'
import { VuejsDatatableFactory } from 'vuejs-datatable';
import VueSession from 'vue-session'
import VueSimpleAlert from "vue-simple-alert";
import VueSocialauth from 'vue-social-auth'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'

import store from "./store";
import routes from './router'

Vue.use(VueCookie);
Vue.use(VuejsDatatableFactory);
Vue.use(VueRouter)
Vue.use(VueAxios, axios);
Vue.use(VueSession);
Vue.use(VueSimpleAlert);
Vue.use(VueSocialauth, {
  providers: {
    google: {
      clientId: '691121027545-qv5m3omrgs27blmnoh727jkuer7meb4u.apps.googleusercontent.com',
      redirectUri: 'http://localhost:8000/auth/google/callback'
    }
  }
});
Vue.use(Vuetify);

const app = new Vue({
    el: '#app',
    // store,
    vuetify: new Vuetify(),
    router: new VueRouter(routes),
});
