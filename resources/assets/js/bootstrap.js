import Vue from 'vue';
import store from 'store';
import Buefy from 'buefy';
import ErrorPage from 'vue-error-page';
import Meta from 'vue-meta';
import { auth, config } from './util/mixins';
import Flash from './util/Flash';
import axios from 'axios';
import interceptors from './util/interceptors';
import Route from 'vue-routisan';

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

Vue.use(Buefy, {
    defaultIconPack: 'fa',
    defaultToastDuration: 3000,
    defaultNoticeQueue: false
});
Vue.use(ErrorPage, { resolver: (component) => require(`./views/Errors/${component}`) });
Vue.use(Meta);
Vue.mixin(auth);
Vue.mixin(config);

Flash.setConfig({
    handler: (message, type) => {
        type = `is-${type}`;
        Vue.prototype.$toast.open({ message, type });
    }
});

axios.defaults.baseURL = `${window.__CONFIG__.app.url}/api`;
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.interceptors.request.use(...interceptors.request);
axios.interceptors.response.use(...interceptors.response);
Vue.prototype.$http = axios;

Route.setViewResolver((component) => require(`./views/${component}`));
