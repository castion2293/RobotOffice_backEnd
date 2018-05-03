
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css' // Ensure you are using css-loader
import 'vuetify/dist/vuetify.min.js'
import FullCalendar from 'vue-full-calendar'
import "fullcalendar/dist/fullcalendar.min.css"

Vue.use(Vuetify)
Vue.use(FullCalendar)

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

//Vue.component('exampleComponent', require('./components/ExampleComponent.vue'));
import example from './components/ExampleComponent'
import calendar from './components/Calendar'
import Userlists from './components/UserList'
import UserInfo from './components/UserInfo'

const app = new Vue({
    el: '#app',
    components: {
        example,
        calendar,
        Userlists,
        UserInfo
    },
});
