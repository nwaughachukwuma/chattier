import './bootstrap';
import Vue from 'vue';
import App from './components/App';
import router from './router';
import store from './store';

store.dispatch('fetchAuthUser').then(() => {
    new Vue({
        router,
        store,
        render: (h) => h(App)
    }).$mount('#app');
});
