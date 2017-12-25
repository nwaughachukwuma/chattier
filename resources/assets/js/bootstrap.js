import Vue from 'vue';
import store from 'store';
import Buefy from 'buefy';
import { auth, config } from './util/mixins';
import iziToast from 'izitoast';
import Flash from './util/Flash';
import axios from 'axios';
import interceptors from './util/interceptors';
import Route from 'vue-routisan';
import ErrorPage from 'vue-error-page';

Vue.config.productionTip = false;

window.eventBus = new Vue();

window.store = store;
window.store.addPlugin(() => {
    return {
        pull (_, key) {
            const value = this.get(key);
            this.remove(key);
            return value;
        },
        has (_, key) {
            return (typeof this.get(key) !== 'undefined');
        }
    };
});

Vue.use(Buefy, { defaultIconPack: 'fa' });
Vue.use(ErrorPage, { resolver: (component) => require(`./views/errors/${component}`) });
Vue.mixin(auth);
Vue.mixin(config);

iziToast.settings({
    position: 'topCenter',
    timeout: 3000
});

Flash.setConfig({
    handler: (message, options) => {
        const validTypes = ['info', 'success', 'warning', 'error', 'question'];
        const type = (validTypes.includes(options) ? options : 'show');
        iziToast[type]({ message });
    }
});

axios.defaults.baseURL = `${window.__CONFIG__.app.url}/api`;
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.interceptors.request.use(...interceptors.request);
axios.interceptors.response.use(...interceptors.response);
Vue.prototype.$http = axios;

Route.setViewResolver((component) => require(`./views/${component}`));
