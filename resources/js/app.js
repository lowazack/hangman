require('./bootstrap');

import Vuex from 'vuex';
import Vue from 'vue'
import Main from './Main'
import VueRouter from 'vue-router'
import Vuesax from 'vuesax'
import routes from "./routes";
import 'vuesax/dist/vuesax.css'
import createPersistedState from "vuex-persistedstate";

Vue.use(Vuex)

const store = new Vuex.Store({
    state: {
        user:null
    },
    mutations: {
        setUser(state, payload){
            state.user = payload;
        }
    },
    plugins: [createPersistedState()]
})
Vue.use(VueRouter)
Vue.use(Vuesax)

const router = new VueRouter({
    routes: routes
})

router.beforeEach((to, from, next) => {
    if (to.meta.requiresAuth){
        if(store.state.user !== null ){
            next()
        }
        else {
            next('/')
        }

    }
    else {
        next()
    }


})

new Vue({
    el: '#app',
    template: '<Main/>',
    components: { Main },
    router,
    store
})
