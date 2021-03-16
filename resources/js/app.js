require('./bootstrap');

import Vue from 'vue'
import Main from './Main'

new Vue({
    el: '#app',
    template: '<Main/>',
    components: { Main },

})
