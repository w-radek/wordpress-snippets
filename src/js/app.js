import "../scss/main.scss";

import Vue from 'vue';
import axios from "axios";
import VueAxios from "vue-axios";

Vue.use(VueAxios, axios);

Vue.component(
    'contact-form',
    require('./vue/contact-form.vue').default
);

const app = new Vue({
    el: '#app'
});

// var fBlack = require('./blank.js');
//
// function refreshScripts() {
//     fBlack();
// }
//
// $(document).ready(function() {
//     refreshScripts();
//
//     $('body').fadeIn(800);
//
// });